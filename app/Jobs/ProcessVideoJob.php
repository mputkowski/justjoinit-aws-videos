<?php

namespace App\Jobs;

use App\Models\Video;
use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Video
     */
    protected $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id = $this->video->id;
        $path = 'tmp-video/' . $id . '.' . $this->video->extension;

        $s3Path = $id . '.' . $this->video->extension;

        Storage::disk('s3')->writeStream($s3Path, Storage::disk('local')->readStream($path));

        $client = new ElasticTranscoderClient([
            'credentials' => [
                'key' => config('services.ses.key'),
                'secret' => config('services.ses.secret'),
            ],
            'region' => config('services.ses.region'),
            'version' => '2012-09-25'
        ]);

        $client->createJob([
            'PipelineId' => config('services.transcoder.pipeline_id'),
            'Input' => [
                'Key' => $s3Path,
            ],
            'Output' => [
                'Key' => $id,
                'SegmentDuration' => '10',
                'PresetId' => config('services.transcoder.preset_id'),
                'ThumbnailPattern' => $id . '-{count}',
            ],
        ]);
    }
}
