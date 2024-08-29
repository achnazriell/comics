<x-app-layout>
    <div class="container mx-auto p-4">
        <h3 class="text-lg font-semibold mb-4">Komik Terbaru</h3>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @forelse ($comics as $comic)
                <div class="shadow-md rounded-lg overflow-hidden transform transition-transform duration-300 hover:-translate-y-2 flex flex-col border border-gray-400">
                    @if ($comic->image)
                        <div class=" overflow-hidden">
                            <a href="{{ route('comics.show', $comic->id) }}">
                                <img src="{{ asset('images/' . $comic->image) }}" class="w-full h-43 object-cover" alt="{{ $comic->title }}">
                                <h3 class=" absolute bottom-0 left-0 right-0 p-7 text-white text-xl font-semibold bg-black bg-opacity-50 text-center block text-ellipsis whitespace-nowrap">
                                    <p>{{ Str::limit($comic->title, 16) }}</p>
                                </h3>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-600">No comics available.</p>
            @endforelse
        </div>
    </div>
    <!-- SweetAlert2 Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @elseif ($errors->any())
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
