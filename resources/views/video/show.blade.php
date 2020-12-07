@extends('layouts.app')

@section('content')

    <div class="w-1/2 mx-auto">
        <h1 class="text-2xl mb-2">{{ $video->title }}</h1>
        <video id="video-player" class="video-js vjs-16-9" controls preload="auto" poster="{{ s3_url($video->id . '-00001.png') }}" data-setup="{}">
            <source src="{{ s3_url($video->id . '.m3u8') }}" type="application/x-mpegURL" />
        </video>
    </div>

@endsection
