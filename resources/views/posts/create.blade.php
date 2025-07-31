@extends('layout')

@section('content')
    <h1>Create New Post</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Title:</label><br>
    <input type="text" name="title"><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="5"></textarea><br><br>

    <label>Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Save</button>
</form>

@endsection
