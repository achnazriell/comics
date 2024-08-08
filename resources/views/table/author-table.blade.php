<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Authors</h1>
        <a href="{{ route('authors.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Author</a>
        @if (session('success'))
            <div class="mt-4 bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md text-center">
                <thead class='bg-blue-400'>
                    <tr class="border border-black">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($authors as $author)
                        <tr class="border border-black">
                            <td>{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b">{{ $author->name }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('authors.edit', $author) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('authors.destroy', $author) }}" method="POST" style="display:inline;">
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
