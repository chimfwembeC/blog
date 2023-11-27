<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center py-2 px-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Posts') }}
        </h2>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Post
        </a>
    </div>
    </x-slot>

    @if(session('success'))
        <div class="block px-4 py-2 text-sm text-white-700 bg-green-200 w-full text-left">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="block px-4 py-2 text-sm text-white-700 bg-red-200 w-full text-left">
            {{ session('error') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
            @if($posts->isEmpty())
                    <p class="p-6 bg-white border-b border-gray-200">No posts available.</p>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($posts as $post)
                        <div class="col-span-1 relative">
                            <div class="py-2 text-sm text-gray-700 bg-white-500 p-4 rounded-lg shadow-md">
                                <div class="mb-4">
                                    <h3 class="text-lg py-2 text-sm text-gray-700 bg-gray-200 font-semibold mb-2">{{ $post->title }}</h3>
                                    <p>{{ $post->comment }}</p>
                                    <p class="text-dark bold">posted by - {{ $post->user->name }}</p>
                                    <p class="text-gray-700">Likes: {{ $post->likes->count() }}</p>
                                </div>

                                <!-- Comment form for each post -->
                                <form method="POST" action="{{ route('comments.store') }}" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                                    <div class="mb-2">
                                        <label for="comment" class="block text-sm font-medium text-gray-700">Add a comment:</label>
                                        <textarea id="comment" name="comment" rows="2" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                    </div>

                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Submit Comment
                                    </button>
                                </form>

                                <!-- Display comments for the post -->
                                @foreach($post->comments as $comment)
                                    <div class="mt-2 py-2 text-sm text-gray-700 bg-white-500 p-4 rounded-lg shadow-md">
                                        <p class="text-gray-700">{{ $comment->content }}</p>
                                        <p class="text-dark bold">Commented by - {{ $comment->user->name }}</p>                                        
                                    </div>
                                @endforeach

                                <!-- Dropdown menu for actions -->
                                <div class="absolute top-0 right-0 m-2">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <button @click="open = !open" class="text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                            <div class="py-1">
                                            <form method="POST" action="{{ route('likePost', $post->id) }}">
                                                @csrf
                                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-200 w-full text-left">
                                                    Like
                                                      <!-- Display the number of likes -->                                                    
                                                </button>
                                            </form>    
                                            <form action="{{ route('posts.edit', $post->id) }}" method="get">
                                                 <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-200 w-full text-left">Edit</button>
                                            </form>                                                                                           
                                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-200 w-full text-left">Delete</button>
                                            </form>
                                                <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-200 w-full text-left">Share</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $posts->links() }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
