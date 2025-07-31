@extends('layout')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    <p><a href="{{ route('posts.edit', $post->id) }}">Edit</a></p>

    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
@endsection
