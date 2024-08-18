<x-app-layout>
    <div class="container mx-auto p-4">
        <h3 class="text-lg font-semibold mb-4">Komik Terbaru</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse ($comics as $comic)
                <a href="{{ route('comics.show', $comic->id) }}" class="hover:bg-black hover:opacity-50">
                    <div class="shadow-md rounded-lg overflow-hidden transform transition-transform duration-300 hover:-translate-y-2 flex flex-col border border-gray-400">
                        @if ($comic->image)
                            <!-- Use flex-grow to stretch the image container -->
                            <div class="flex-grow h-full bg-cover bg-center" style="background-image: url('{{ asset('images/' . $comic->image) }}');">
                                <!-- Ensure the content inside the image container is positioned correctly -->
                                <div class="p-5 bg-black bg-opacity-50 text-white flex items-end h-full">
                                    <h4 class="text-xl font-semibold mb-2">{{ $comic->title }}</h4>
                                </div>
                            </div>
                        @endif
                    </div>
                </a>
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
