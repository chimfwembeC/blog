<!-- resources/views/posts/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Post') }}
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

                    <!-- Post Form -->
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-600">Title</label>
                            <input type="text" name="title" id="title" class="form-input mt-1 block w-full rounded-md border-gray-300">
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-600">Content</label>
                            <textarea name="content" id="content" rows="4" class="form-input mt-1 block w-full rounded-md border-gray-300"></textarea>
                        </div>

                        <div class="flex items-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
