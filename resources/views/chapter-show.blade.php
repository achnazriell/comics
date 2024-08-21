<x-app-layout>
    <button type="button" class="bg-gray-500 text-white px-4 py-2 ml-2 rounded hover:bg-gray-600"
        onclick="window.location.href='{{ route('comics.show', $chapter->comic_id) }}'">Back</button>
    <div id="chapter-{{ $chapter->id }}" class="m-5">
        <h5 class="text-lg font-semibold">{{ $chapter->title }}</h5>
        <div class="grid grid-cols-2 md:grid-cols-1 gap-2">
            @foreach ($chapter->chapterImages as $image)
                <div class="relative">
                    <img src="{{ asset('chapter_images/' . $image->image) }}" alt="{{ $chapter->title }}"
                        class="w-full h-auto object-contain mb-2"> <!-- Natural aspect ratio -->
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
