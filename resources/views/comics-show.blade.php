<!-- resources/views/comics/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $comic->title }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if($comic->image)
            <img src="{{ asset('images/' . $comic->image) }}" class="w-full h-64 object-cover" alt="{{ $comic->title }}">
            @endif
            <div class="p-4">
                <h3 class="text-2xl font-semibold mb-4">{{ $comic->title }}</h3>
                <p class="text-gray-600 mb-4">Author: {{ $comic->author->name }}</p>
                <p class="text-gray-600 mb-4">Publisher: {{ $comic->publisher->name }}</p>
                <p class="text-gray-600 mb-4">Genres:
                    @foreach($comic->genres as $genre)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $genre->name }}</span>
                    @endforeach
                </p>
                <p class="text-gray-600 mb-4">{{ $comic->synopsis->content ?? 'No synopsis available' }}</p>
                <h4 class="text-xl font-semibold mb-2">Chapters:</h4>
                <ul class="list-disc list-inside text-gray-600">
                    @forelse($comic->chapters as $chapter)
                    <li>
                        <li class="py-2 px-4">
                            @if ($comic->chapters->isNotEmpty())
                                @foreach ($comic->chapters as $chapter)
                                    <p><strong>{{ $chapter->title }}</strong></p>
                                    @foreach ($chapter->chapterImages as $image)
                                        <img src="{{ asset('chapter_images/' . $image->image) }}" alt="{{ $chapter->title }}" class="w-16 h-16 object-cover mb-2">
                                    @endforeach
                                    <br>
                                @endforeach
                            @endif
                        </td>
                    @empty
                    <li>No chapters available.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
