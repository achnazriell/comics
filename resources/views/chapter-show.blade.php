<x-app-layout>
    <div id="chapter-{{ $chapter->id }}" class="m-5">
        <h5 class="text-lg font-semibold">{{ $chapter->title }}</h5>
        <div class="grid grid-cols-2 md:grid-cols-1 gap-2">
            @foreach ($chapter->chapterImages as $image)
                <div class="relative" style="padding-bottom: 56.25%;"> <!-- 16:9 Aspect Ratio -->
                    <img src="{{ asset('chapter_images/' . $image->image) }}" alt="{{ $chapter->title }}"
                        class="absolute top-0 left-0 w-full h-full object-cover mb-2">
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
