<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Support\Str;
use App\Jobs\ProcessVideoJob;
use App\Http\Requests\StoreVideo;

class VideoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('video.create');
    }

    /**
     * @param \App\Http\Requests\StoreVideo $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVideo $request)
    {
        $id = Str::random(5);
        $file = $request->file('video');
        $extension = $file->getClientOriginalExtension();

        $video = Video::create([
            'id' => $id,
            'title' => $request->input('title'),
            'extension' => $extension,
        ]);

        $file->storeAs('tmp-video', $id . '.' . $extension);

        ProcessVideoJob::dispatch($video);

        return redirect()->route('index');
    }

    /**
     * @param \App\Models\Video $video
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Video $video)
    {
        return view('video.show', compact('video'));
    }
}
