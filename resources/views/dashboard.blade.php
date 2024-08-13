<x-app-layout>
    <div class="container mx-auto p-4">
        <h3 class="text-lg font-semibold mb-4">Komik Terbaru</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse ($comics as $comic)
            <div class="bg-transparent shadow-md rounded-lg overflow-hidden transform transition-transform duration-300 hover:-translate-y-2 flex flex-col">
                @if($comic->image)
                <div class="overflow-hidden">
                    <img src="{{ asset('images/' . $comic->image) }}" class="w-full h-48 object-cover" alt="{{ $comic->title }}">
                </div>
                @endif
                <div class="p-3 flex-grow ">
                    <a href="{{ route('comics.show', $comic->id) }}" class="hover:underline mt-2 block">
                        <h4 class="text-xl font-semibold mb-2">{{ $comic->title }}</h4>
                    </a>
                </div>
            </div>
            @empty
            <p class="text-gray-600">No comics available.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>