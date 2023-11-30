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
            
            <div class="shadow-xl sm:rounded-lg">
            @if($posts->isEmpty())
                    <p class="p-6 bg-white border-b border-gray-200">No posts available.</p>
                @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($posts as $post)
                        <div class="col-span-1 relative">
                            <div class="py-2 text-sm text-gray-700 bg-white-500 p-4 rounded-lg shadow-md">
                                <div class="mb-4">
                                    <span class="text-lg py-2 text-lg text-gray-700 bg-gray-200 rounded-full w-full px-4 m-2 font-semibold">{{ $post->title }}</span>
                                    <p class="bg-white text-black font-captalise p-4 text-sm m-4 rounded-full shadow-md">{{ $post->comment }}</p>
                                    <p class="m-2 lead-none text-end block font-semibold px-2 py-1 text-lg">posted by - {{ $post->user->name }}</p>
                                    <i class="fas fa-heart"></i>
                                    @php
                                        $isLiked = auth()->user() ? $post->likes->contains('user_id', auth()->user()->id) : false;
                                    @endphp                             
                                    <span class="m-2 lead-none inline-block font-semibold px-2 py-1 rounded-full @if($isLiked)  bg-green-500 text-white @else  bg-blue-500 text-white @endif">{{ $isLiked ? 'Liked' : 'Likes' }} : {{ $post->likes->count() }}</span>                                    
                                    @php
                                        $isShared = auth()->user() ? $post->shares->contains('user_id', auth()->user()->id) : false;
                                    @endphp
                                    <span class="m-2 lead-none inline-block font-semibold px-2 py-1 rounded-full bg-gray-200 @if($isShared) bg-orange-500 text-white @else bg-yellow-500 text-white @endif "> {{ $isShared ? 'Shared' : 'Shares' }} : {{ $post->shares->count() }}</span>
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
                                    <p class="text-gray-700" id="editComment_{{ $comment->id }}" data-comment-content="{{ $comment->content }}">{{ $comment->content }}</p>
                                    @php
                                        $isCommented = auth()->user() ? $post->comments->contains('user_id', auth()->user()->id) : false;
                                    @endphp
                                    @if ($isCommented)
                                        <div class="mt-2 py-2 text-sm p-4 shadow-md  @if($isCommented) text-gray-700 bg-green-100 @endif">
                                            <p class="text-gray-700 bg-white p-4 m-2 rounded-full  shadow-md">{{ $comment->content }}</p>
                                            <p class="m-2 lead-none inline-block font-semibold px-2 py-1 rounded-full bg-gray-200 ">
                                                <span class="text-gray-700 lead-none inline-block font-semibold px-2 py-1 rounded-full">{{ $isCommented ? 'You Commented :' : 'Commented By :' }}</span> 
                                                <span class="text-green-500">{{ $comment->user->name }}</span>
                                            </p>  
                                        </div>                                            
                                        @else
                                        <div class="mt-2 py-2 text-sm p-4 rounded-lg shadow-md text-gray-700 bg-gray-100">
                                            <p class="text-gray-700 bg-white p-4 m-2  shadow-md">{{ $comment->content }}</p>                                            
                                            <p class="m-2 lead-none inline-block font-semibold px-2 py-1 rounded-full bg-gray-200 ">
                                                <span class="text-gray-700 lead-none inline-block font-semibold px-2 py-1 rounded-full">{{ $isCommented ? 'You Commented :' : 'Commented By :' }}</span> 
                                                <span class="text-green-500">{{ $comment->user->name }}</span>
                                            </p>                                        
                                        </div>   
                                        @endif       

                                    <!-- Dropdown menu for actions -->
                                    <div class="relative inline-block text-left">
                                        <button @click="openCommentDropdown_{{ $comment->id }} = !openCommentDropdown_{{ $comment->id }}" class="text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div x-show="openCommentDropdown_{{ $comment->id }}" @click.away="openCommentDropdown_{{ $comment->id }} = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                            <div class="py-1">
                                                <form method="POST" action="{{ route('likeComment', $comment->id) }}">
                                                    @csrf
                                                    @php
                                                        $isLiked = auth()->user() ? $comment->commentLikes->contains('user_id', auth()->user()->id) : false;
                                                    @endphp

                                                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-200 w-full @if($isLiked) bg-blue-200 @else hover:bg-blue-200 @endif w-full text-end">
                                                        {{ $isLiked ? 'Liked' : 'Like' }}                                                        
                                                        <span class="text-gray-700">Likes: {{ $comment->commentLikes->count() }}</span>
                                                    </button>
                                                </form>

                                                @if(auth()->user() && auth()->user()->id == $comment->user_id)
                                                    <!-- Use onclick attribute to call the function with the comment ID -->
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-200 w-full text-left" onclick="editComment('{{ $comment->id }}')">Edit</a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-200 w-full text-left" onclick="deleteComment('{{ $comment->id }}')">Delete</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                                <!-- Dropdown menu for actions -->
                                
                        </div>
                    @endforeach
                    
                </div>
                {{ $posts->links() }}
                @endif
            </div>
        </div>
    </div>
    <script>
           function deleteComment(commentId) {
        // Display a confirmation prompt
        var confirmDelete = confirm('Are you sure you want to delete this comment?');

        if (confirmDelete) {
            // Redirect to the delete route
            window.location.href = `/comments/${commentId}`;
        }
    }
   
    function deleteComment(commentId) {
        // Display a confirmation prompt
        var confirmDelete = confirm('Are you sure you want to delete this comment?');

        if (confirmDelete) {
            // Redirect to the delete route
            window.location.href = `/comments/${commentId}`;
        }
    }

    function editComment(commentId) {
        // Get comment data from data attribute
        var commentContent = document.getElementById(`editComment_${commentId}`).dataset.commentContent;

        // Display the edit form
        var editForm = document.createElement('form');
        editForm.method = 'POST';
        editForm.action = `/comments/${commentId}`;
        editForm.innerHTML = `
            @method('PUT')
            <textarea name="comment" rows="2" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">${commentContent}</textarea>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Update Comment</button>
        `;

        // Replace the comment content with the edit form
        var commentContainer = document.getElementById(`editComment_${commentId}`);
        commentContainer.innerHTML = '';
        commentContainer.appendChild(editForm);
    }


    </script>    
</x-app-layout>
