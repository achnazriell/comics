<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Genres</h1>
        <a href="{{ route('genres.create') }}" class="bg-indigo-500 text-black px-4 py-2 rounded-lg hover:bg-blue-600">Add
            Genre</a>
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-700"
                role="alert">
                <span class="font-medium">
                    {{session('success')}}
                </span>
            </div>
        @endif
        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black-200 rounded-lg shadow-md">
                <thead class="bg-blue-400">
                    <tr >
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Genre</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($genres as $genre)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b">{{ $genre->name }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('genres.edit', $genre) }}"
                                    class="bg-yellow-500 text-black     px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('genres.destroy', $genre) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
