<!DOCTYPE html>
<html>
<head>
    <title>My Posts App</title>
</head>
<body>
    <nav>
        <a href="{{ route('posts.index') }}">All Posts</a> |
        <a href="{{ route('posts.create') }}">Create Post</a> |
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
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
