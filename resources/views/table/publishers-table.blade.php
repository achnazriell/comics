<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Genres</h1>
        <a href="{{ route('genres.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 border border-black">Add Genre</a>
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">
                    {{session('success')}}
                </span>
            </div>
        @endif
        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md">
                <thead class="bg-blue-400">
                    <tr class="border border-black">
                        <th class="py-2 px-4 border border-black">No</th>
                        <th class="py-2 px-4 border border-black">Name Publisher</th>
                        <th class="py-2 px-4 border border-black">Address</th>
                        <th class="py-2 px-4 border border-black">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishers as $public)
                        <tr class="border border-black">
                            <td class="py-2 px-4 border border-black">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border border-black">{{ $public->name }}</td>
                            <td class="py-2 px-4 border border-black">{{ $public->address }}</td>
                            <td class="py-2 px-4 border border-black">
                                <a href="{{ route('genres.edit', $public) }}"
                                    class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600 border border-black">Edit</a>
                                <form action="{{ route('genres.destroy', $public) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-600 border border-black">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
