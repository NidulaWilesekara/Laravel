<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post CRUD</title>
</head>
<body>
    <nav>
        <a href="{{ route('posts.index') }}">All Posts</a> |
        <a href="{{ route('posts.create') }}">Create Post</a> |
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <hr>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @yield('content')
</body>
</html>
