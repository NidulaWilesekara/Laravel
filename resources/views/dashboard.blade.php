<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Welcome back, ') . Auth::user()->name . '!' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Top Action Buttons -->
            <div class="flex justify-between mb-6">
                <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    📄 View My Posts
                </a>
                <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                    ➕ Create New Post
                </a>
            </div>

            <!-- Welcome Card -->
            <div class="mb-6 overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
                                <span class="text-lg font-bold text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600">You're successfully logged in. Here's your dashboard overview.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Cards -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                <!-- My Posts -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">My Posts</h4>
                                <p class="text-gray-600">Manage your blog posts</p>
                                <a href="{{ route('posts.index') }}" class="text-indigo-600 hover:text-indigo-800">View Posts →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create Post -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Create Post</h4>
                                <p class="text-gray-600">Write a new blog post</p>
                                <a href="{{ route('posts.create') }}" class="text-green-600 hover:text-green-800">Create New →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Profile</h4>
                                <p class="text-gray-600">Update your profile</p>
                                <a href="{{ route('profile.edit') }}" class="text-purple-600 hover:text-purple-800">Edit Profile →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Account Information</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                            <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Login</label>
                            <p class="mt-1 text-sm text-gray-900">{{ now()->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
