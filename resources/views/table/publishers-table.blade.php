<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Publishers</h1>
        <a href="{{ route('publishers.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 border border-black">Add Publisher</a>

        <!-- Search Form -->
        <form action="{{ route('publishers.index') }}" method="GET" class="flex items-center mt-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search Publishers..."
                class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Search
            </button>

            <a href="{{ route('publishers.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Reset</a>
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

        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md">
                <thead class='bg-blue-400'>
                    <tr class="border border-black">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Publisher Name</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishers as $index => $publisher)
                        <tr class="border border-black">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $publisher->name }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('publishers.edit', $publisher) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('publishers.destroy', $publisher) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure want to delete data publisher?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $publishers->links() }}
        </div>
    </div>
</x-app-layout>
