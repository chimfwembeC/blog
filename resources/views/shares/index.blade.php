<!-- resources/views/shares/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-2 px-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Shares') }}
            </h2>
            <!-- Add a link to create a new share -->
            <a href="{{ route('shares.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Share
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
            <div class="overflow-hidden shadow-xl sm:rounded-lg">          
                <div class="grid grid-cols-1  gap-4">
                    @foreach($shares as $share)
                        <div class="col-span-4 relative">
                            <div class="py-2 text-sm text-gray-700 bg-white p-4 rounded-lg shadow-md">
                                <div class="mb-4">
                                    <h3 class="text-lg py-2 text-sm text-gray-700 bg-white-200 font-semibold mb-2">{{ $share->title }}</h3>
                                    <label for="caption" class="block text-sm font-large text-gray-600">Posted By - {{ $share->post->user->name }}</label>    
                                    <div class="mb-6 p-6 bg-gray-200 border-b border-gray-200 shadow-xl sm:rounded-lg">                                        
                                        <label for="caption" class="block text-sm font-medium text-gray-600">Post Contents</label>
                                        <p class="capitalise">
                                            {{ $share->post->comment }}
                                        </p>
                                    </div>
                                    <p class="text-dark bold">shareed by - {{ $share->user->name }}</p>
                                    <span class="text-gray-700 lead-none inline-block font-semibold px-2 py-1 rounded-full">Likes: {{ $share->post->likes->count() }}</span>
                                    <span class="text-gray-700 lead-none inline-block font-semibold px-2 py-1 rounded-full ms-2">Shares: {{ $share->post->shares->count() }}<spanp>
                                </divspan


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
                                         
                                          <!-- Edit and Delete forms for shares owned by the active user -->
                                                @if(auth()->user() && $share->user_id == auth()->user()->id)
                                                    <div class="">
                                                        <form action="{{ route('shares.edit', $share->id) }}" method="get">
                                                            <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-200 w-full text-left">Edit</button>
                                                        </form>
                                                        
                                                        <form method="share" action="{{ route('shares.destroy', $share->id) }}" onsubmit="return confirm('Are you sure you want to delete this share?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-200 w-full text-left">Delete</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <a href="{{ route('shares.show', $share->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-200 w-full text-left">Share</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $shares->links() }}            
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
