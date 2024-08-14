<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Comics</h1>
        <a href="{{ route('comics.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Comic</a>

        <!-- Search Form -->
        <form action="{{ route('comics.index') }}" method="GET" class="flex items-center mt-4">
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
            <a href="{{ route('comics.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Reset</a>
        </form>

        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md">
                <thead class="bg-blue-400">
                    <tr class="border border-black">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">Author</th>
                        <th class="py-2 px-4">Publisher</th>
                        <th class="py-2 px-4">Genres</th>
                        <th class="py-2 px-4">Comic Image</th>
                        <th class="py-2 px-4">Synopsis</th>
                        <th colspan="2" class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comics as $index => $comic)
                        <tr class="border border-black">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $comic->title }}</td>
                            <td class="py-2 px-4">{{ $comic->author->name ?? 'Unknown' }}</td>
                            <td class="py-2 px-4">{{ $comic->publisher->name ?? 'No Publisher' }}</td>
                            <td class="py-2 px-4">
                                @if ($comic->genres->isNotEmpty())
                                    {{ $comic->genres->pluck('name')->implode(', ') }}
                                @else
                                    No Genres
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                @if ($comic->image)
                                <img src="{{ asset('storage/' . $comic->image) }}" alt="{{ $comic->title }}" class="w-16 h-16 object-cover">
                            @else
                                No Image
                            @endif
                            </td>
                            <td class="py-2 px-4">
                                @if ($comic->synopsis)
                                    {{ $comic->synopsis->content }}
                                @else
                                    No Synopsis
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                <a href="{{ route('comics.edit', $comic) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                            </td>
                            <td class="py-2 px-4">
                                <form action="{{ route('comics.destroy', $comic) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this comic?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

                <!-- SweetAlert2 Alert Script -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        @if (session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '{{ session('success') }}'
                            });
                        @endif

                        @if (session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: '{{ session('error') }}'
                            });
                        @endif
                    });

                    function confirmDeletion() {
                        return Swal.fire({
                            title: 'Are you sure?',
                            text: 'This action cannot be undone!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                return true;
                            }
                            return false;
                        });
                    }
                </script>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $comics->links() }}
        </div>
    </div>
</x-app-layout>
