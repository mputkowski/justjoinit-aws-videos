@extends('layouts.app')

@section('content')

    <div class="flex justify-center items-center">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <h4 class="text-xl">New video</h4>
            <div class="mt-5">
                <label class="block">Title</label>
                <input type="text" name="title" class="w-full" required>
            </div>
            <div class="mt-3">
                <input type="file" name="video" class="w-full" required>
            </div>
            <div class="flex justify-end mt-4">
                <button class="btn" type="submit">Submit</button>
            </div>
        </form>
    </div>

@endsection
