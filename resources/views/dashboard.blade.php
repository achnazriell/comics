<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Home') }}
            </h2>

            <!-- Search Form -->
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search Comics..."
                    class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-300"
                />
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Search
                </button>
            </form>
        </div>
    </x-slot>

    <div class="container mx-auto p-4">
        <h3 class="text-lg font-semibold mb-4">Komik Terbaru</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($comics as $comic)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                @if($comic->image)
                <img src="{{ asset('images/' . $comic->image) }}" class="w-full h-48 object-cover" alt="{{ $comic->title }}">
                @endif
                <div class="p-4">
                    <h4 class="text-xl font-semibold mb-2">{{ $comic->title }}</h4>
                    <p class="text-gray-600">{{ $comic->synopsis->content ?? 'No synopsis available' }}</p>
                    <a href="{{ route('comics.show', $comic->id) }}" class="text-blue-500 hover:underline mt-2 block">Baca Selengkapnya</a>
                </div>
            </div>
            @empty
            <p class="text-gray-600">No comics available.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
