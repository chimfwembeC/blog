<!-- resources/views/posts/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center py-2 px-4">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>      
    </div>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">            
        <div class="overflow-hidden shadow-xl sm:rounded-lg">
        @if($shares->isEmpty())
                    <p class="p-6 bg-white border-b border-gray-200">No posts available.</p>
                @else
                <p class="p-6 bg-white border-b border-gray-200">loading shared post</p>
        @endif
        </div>
    </div>
    </div>
</x-app-layout>
