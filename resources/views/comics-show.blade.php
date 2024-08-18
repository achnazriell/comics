<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col md:flex-row">
            @if ($comic->image)
                <div class="md:w-1/2">
                    <img src="{{ asset('images/' . $comic->image) }}" class="w-full h-full object-cover" alt="{{ $comic->title }}">
                </div>
            @endif
            <div class="p-4 md:w-1/2 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-semibold mb-4">{{ $comic->title }}</h3>
                    <p class="text-gray-600 mb-4"><strong>Synopsis:</strong> {{ $comic->synopsis->content ?? 'No synopsis available' }}</p>
                    <hr class="my-4">
                    <p class="text-gray-600 mb-4"><strong>Author:</strong> {{ $comic->author->name }}</p>
                    <p class="text-gray-600 mb-4"><strong>Publisher:</strong> {{ $comic->publisher->name }}</p>
                    <p class="text-gray-600 mb-4"><strong>Genres:</strong>
                        @foreach ($comic->genres as $genre)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $genre->name }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>

        <h4 class="text-xl font-semibold mb-2 mt-4">Chapters</h4>
        <div class="grid grid-cols-2 md:grid-cols-7 gap-4 mb-3">
            <a href="{{ route('chapters.create', ['comic_id' => $comic->id]) }}" class="block p-4 bg-gray-200 rounded-lg shadow-md text-center hover:bg-gray-300">
                <span class="text-lg font-semibold">Create</span>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($filteredChapters as $chapter)
                <a href="{{ route('chapters.show', $chapter) }}" class="block p-4 bg-gray-200 rounded-lg shadow-md text-center hover:bg-gray-300">
                    <span class="text-lg font-semibold">Chapter {{ $loop->iteration }}</span>
                </a>
            @empty
                <p>No chapters available.</p>
            @endforelse
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    title: 'Success',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @elseif($errors->any())
                Swal.fire({
                    title: 'Oops!',
                    text: "{{ $errors->first() }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
</x-app-layout>
