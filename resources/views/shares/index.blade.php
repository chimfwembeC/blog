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
                @if($shares->isEmpty())
                    <p class="p-6 bg-white border-b border-gray-200">No shares available.</p>
                @else
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($shares as $share)
                            <div class="col-span-1 relative">
                                <!-- Share content here -->
                                <div class="bg-white-500 p-4 rounded-lg shadow-md">
                                    <p class="text-dark bold">Shared by - {{ $share->user->name }}</p>
                                    <div class="text-sm text-gray-700 bg-white p-4 rounded-lg shadow-md">
                                        <div class="mb-4">
                                            <h3 class="text-lg py-2 text-sm text-gray-700 font-semibold mb-2">{{ $share->post->title }}</h3>
                                            <p class="overflow-hiddenpy-2 text-sm text-gray-700 font-semibold mb-2">{{ $share->post->comment }}</p>
                                            <i class="fas fa-heart"></i>
                                            
                                        </div>
                                        <!-- Other share details and actions go here -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $shares->links() }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
