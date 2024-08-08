<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Comics</h1>
        <a href="{{ route('comics.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Comic</a>
        @if (session('success'))
            <div class="mt-4 bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="border-b bg-gray-100 text-left">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">Author</th>
                        <th class="py-2 px-4">Genres</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comics as $comic)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b">{{ $comic->title }}</td>
                            <td class="py-2 px-4 border-b">{{ $comic->author->name }}</td>
                            <td class="py-2 px-4 border-b">
                                @foreach ($comic->genres as $genre)
                                    {{ $genre->name }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('comics.edit', $comic) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('comics.destroy', $comic) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
