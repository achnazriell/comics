<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Comics</h1>
        <a href="{{ route('comics.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Comic</a>
        @if (session('success'))
            <div class="mt-4 bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md">
                <thead class='bg-blue-400'>
                    <tr class="border border-black">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">Author</th>
                        <th class="py-2 px-4">Publisher</th> <!-- Add this column -->
                        <th class="py-2 px-4">Genres</th>
                        <th class="py-2 px-4">Image</th>
                        <th class="py-2 px-4">Synopsis</th> <!-- Add this column -->
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comics as $index => $comic)
                        <tr class="border border-black">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $comic->title }}</td>
                            <td class="py-2 px-4">{{ $comic->author->name }}</td>
                            <td class="py-2 px-4">{{ $comic->publisher ? $comic->publisher->name : 'No Publisher' }}</td>
                            <td class="py-2 px-4">
                                @foreach ($comic->genres as $genre)
                                    {{ $genre->name }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="py-2 px-4">
                                @if ($comic->image)
                                    <img src="{{ asset('images/' . $comic->image) }}" alt="{{ $comic->title }}" class="w-16 h-16 object-cover">
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                @if ($comic->synopsis)
                                    {{ $comic->synopsis->content }} <!-- Display Synopsis -->
                                @else
                                    No Synopsis
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                <a href="{{ route('comics.edit', $comic) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('comics.destroy', $comic) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
