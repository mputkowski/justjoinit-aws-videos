@extends('layouts.app')

@section('content')

    <a href="{{ route('video.create') }}">
        <button class="btn">New video</button>
    </a>
    <h4 class="mt-4 text-xl">Videos</h4>
    @foreach ($videos as $video)
        <div class="my-4">
            <a href="{{ route('video.show', $video) }}" class="underline">{{ $video->title }}</a>
        </div>
    @endforeach


@endsection
