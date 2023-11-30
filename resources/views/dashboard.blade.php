<x-app-layout>
    <x-slot name="header">       
        <div class="flex justify-between items-center py-2 px-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Post
        </a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class=" bg-white p-4 sm:rounded-lg mb-3">
                    <div class="flex justify-between items-center py-2 px-4">
                        <p class="text-bold text-uppercase text-4xl">Blog feed</p>
                        <p class="text-bold text-uppercase text-4xl">All blog posts: {{ $postCount }}</p>                
                    </div>

                </div>
            <div class="overflow-hidden shadow-xl sm:rounded-lg">          
                <div class="grid grid-cols-1 gap-4">
                    @foreach($posts as $post)
                        <div class="col-span-1 relative">
                            <div class="py-2 text-sm text-gray-700 bg-white p-4 rounded-lg shadow-md">
                                <div class="mb-4">
                                    <h3 class=" font-bold font-captalise lead-none bg-blue-200 inline-block font-semibold px-4 py-1 rounded-full text-blue-800 p-1 text-xl m-2">{{ $post->title }}</h3>
                                    <p class="text-gray-700 bg-gray-200 p-4 m-2 rounded-full  shadow-md">{{ $post->comment }}</p>
                                    <p class=" font-bold font-captalise lead-none inline-block font-semibold px-2 py-1 text-gray-500 p-1 mb-2 text-lg mx-2 w-full text-end">Posted by - {{ $post->user->name }}</p> <br>
                                    @php
                                        $isLiked = auth()->user() ? $post->likes->contains('user_id', auth()->user()->id) : false;
                                    @endphp
                                    <span class="text-gray-700 ms-2 lead-none text-gray-500 inline-block font-semibold px-2 py-1 rounded-full hover:bg-blue-200  @if($isLiked) text-white  bg-green-500 @else bg-blue-200 @endif">{{ $isLiked ? 'Liked' : 'Likes'}} | {{ $post->likes->count() }} </span>                                                            
                                    @php
                                        $isShared = auth()->user() ? $post->shares->contains('user_id', auth()->user()->id) : false;
                                    @endphp
                                    <span class="lead-none text-white inline-block font-semibold px-2 py-1 rounded-full @if($isShared) bg-orange-500 text-gray-800 @else  bg-yellow-500  @endif">{{ $isShared ? 'Shared' : 'share' }} | {{ $post->shares->count() }}</span>                                  
                                </div>

                                <!-- Comment form for each post -->
                                <form method="POST" action="{{ route('comments.store') }}" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                                    <div class="mb-2">
                                        <label for="comment" class="block text-sm font-medium text-gray-700">Add a comment:</label>
                                        <textarea id="comment" name="comment" rows="2" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                    </div>
                                    <div class="w-full text-end">
                                        <button type="submit" class="bg-blue-500 rounded-full hover:bg-blue-700 text-white font-bold py-2 px-4">
                                            Submit Comment
                                        </button>
                                    </div>
                                   
                                </form>

                                <!-- Display comments for the post -->
                                @foreach($post->comments as $comment)
                                    @php
                                        $isCommented = auth()->user() ? $post->comments->contains('user_id', auth()->user()->id) : false;
                                    @endphp
                                    @if ($isCommented)
                                        <div class="mt-2 py-2 text-sm p-4 shadow-md p-6 @if($isCommented) text-gray-700 bg-green-100 @else bg-gray-200 @endif">
                                            <p class="text-gray-700 bg-white p-4 m-2 rounded-full shadow-md">{{ $comment->content }}</p>
                                            <p class="m-2 lead-none inline-block font-semibold px-2 py-1 rounded-full bg-gray-200 ">
                                                <span class="text-gray-800 lead-none inline-block font-semibold px-2 py-1 rounded-full">You Commented</span> 
                                                <span class="text-green-500">{{ $comment->user->name }}</span>
                                            </p>  
                                        </div>                                            
                                        @else
                                        <div class="mt-2 py-2 text-sm p-4 rounded-lg shadow-md text-gray-700 bg-gray-100">
                                            <p class="text-gray-700 bg-white p-4 m-2  shadow-md">{{ $comment->content }}</p>                                            
                                            <p class="m-2 lead-none inline-block font-semibold px-2 py-1 rounded-full bg-gray-200 ">
                                                <span class="text-gray-800 lead-none inline-block font-semibold px-2 py-1 rounded-full">Commented By</span> 
                                                <span class="text-green-500">{{ $comment->user->name }}</span>
                                            </p>                                        
                                        </div>   
                                        @endif       
                                
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
                                          <!-- Edit and Delete forms for posts owned by the active user -->
                                                @if(auth()->user() && $post->user_id == auth()->user()->id)
                                                    <div class="">
                                                        <form action="{{ route('posts.edit', $post->id) }}" method="get">
                                                            <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-200 w-full text-left">Edit</button>
                                                        </form>
                                                        
                                                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-200 w-full text-left">Delete</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <a href="{{ route('shares.show', $post->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-200 w-full text-left">Share</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $posts->links() }}            
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
