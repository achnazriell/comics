<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Genres</h1>

        <!-- Add Genre Button -->
        <a href="{{ route('genres.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 border border-black">Add Genre</a>

        <!-- Search Form -->
        <form action="{{ route('genres.index') }}" method="GET" class="mb-4">
            <input type="text" name="query" value="{{ request('query') }}" class="border rounded px-4 py-2 w-1/3" placeholder="Search genres...">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
            <a href="{{ route('genres.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">Reset</a>
        </form>

        <!-- Alert Section -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Genre Table -->
        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md">
                <thead class="bg-blue-400">
                    <tr class="border border-black">
                        <th class="py-2 px-4 border border-black">No</th>
                        <th class="py-2 px-4 border border-black">Genre</th>
                        <th class="py-2 px-4 border border-black">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($genres as $genre)
                        <tr class="border border-black">
                            <td class="py-2 px-4 border border-black">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border border-black">{{ $genre->name }}</td>
                            <td class="py-2 px-4 border border-black">
                                <a href="{{ route('genres.edit', $genre) }}" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600 border border-black">Edit</a>
                                <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-600 border border-black">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 px-4 border border-black text-center">No genres found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
