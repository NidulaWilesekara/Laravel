@extends('layout')

@section('content')
    <h1>My Posts</h1>

    @foreach ($posts as $post)
        <div style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;">
            <h3>{{ $post->title }}</h3>
            <p>{{ Str::limit($post->content, 100) }}</p>
            <a href="{{ route('posts.show', $post->id) }}">View</a> |
            <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>

        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" width="150">
        @endif

    @endforeach
    
@endsection
