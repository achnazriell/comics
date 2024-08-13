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
        </form>

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

        <!-- Alert Section -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>

                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M7.629 12.357l-3.243-3.243 1.414-1.414L7.629 9.53l7.636-7.636 1.415 1.414L7.629 12.357z" />
                    </svg>
                </span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 8.586L13.586 12l1.414-1.414L11.414 7.172 15 3.586 13.586 2 10 5.586 6.414 2 5 3.586l3.586 3.586-3.586 3.586L6.414 12 10 8.586z" />
                    </svg>
                </span>

            </div>
        @endif

        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md">
                <thead class='bg-blue-400'>
                    <tr class="border border-black">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">Author</th>
                        <th class="py-2 px-4">Publisher</th>
                        <th class="py-2 px-4">Genres</th>
                        <th class="py-2 px-4">Comic Image</th>
                        <th class="py-2 px-4">Chapter Images</th>
                        <th class="py-2 px-4">Synopsis</th>
                        <th colspan="2" class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comics as $index => $comic)
                        <tr class="border border-black">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $comic->title }}</td>
                            <td class="py-2 px-4">{{ $comic->author->name }}</td>
                            <td class="py-2 px-4">{{ $comic->publisher ? $comic->publisher->name : 'No Publisher' }}
                            </td>
                            <td class="py-2 px-4">
                                @foreach ($comic->genres as $genre)
                                    {{ $genre->name }}@if (!$loop->last)
                                    @endif
                                @endforeach
                            </td>
                            <td class="py-2 px-4">
                                @if ($comic->image)
                                    <img src="{{ asset('images/' . $comic->image) }}" alt="{{ $comic->title }}"
                                        class="w-16 h-16 object-cover">
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
                                <a href="{{ route('comics.edit', $comic) }}"
                                    class="text-blue-500 hover:underline">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('comics.destroy', $comic) }}" method="POST"
                                    style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Are you sure want to delete data comic?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $comics->links() }}
        </div>
    </div>
</x-app-layout>
