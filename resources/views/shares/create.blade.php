<!-- resources/views/shares/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Share a Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="mb-4 text-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Share Form -->
                    <form method="POST" action="{{ route('shares.store') }}">
                        @csrf

                        <div class="mb-4">                          
                            <input type="text" name="post_id" value="{{ $post->id }}" class="form-input mt-1 hidden block w-full rounded-md border-gray-300">
                        </div>

                        <div class="mb-4">
                            <label for="caption" class="block text-sm font-medium text-gray-600">Caption</label>
                            <textarea name="caption" id="caption" rows="4" class="form-input mt-1 block w-full rounded-md border-gray-300"></textarea>
                        </div>
                            <div class="mb-6 p-6 bg-white border-gray-200" shadow-2xl sm:rounded-lg>
                                <label for="caption" class="block text-sm font-large text-gray-600">Posted By - {{ $post->user->name }}</label>    
                                    <div class="mb-6 p-6 bg-white border-b border-gray-200" shadow-xl sm:rounded-lg>                                        
                                        <label for="caption" class="block text-sm font-medium text-gray-600">Post Contents</label>
                                        <p class="text-capitalise">
                                            {{ $post->comment }}
                                        </p>
                                    </div>
                                    <p>Like: {{ $post->likes->count() }}</p>
                                    <p>shares: {{ $post->shares->count() }}</p>
                            </div>
                        <div class="flex items-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Share Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
