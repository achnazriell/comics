

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Genres</h1>
    <a href="{{ route('create-genre') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Genre</a>
    
    @if (session('success'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block">{{ session('success') }}</span>
        </div>
    @endif
    
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mt-6">
        <thead class="bg-gray-200 text-gray-600">
            <tr>
                <th class="px-4 py-2 border-b">Genre</th>
                <th class="px-4 py-2 border-b">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($genres as $genre)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $genre->name }}</td>
                    <td class="px-4 py-2 border-b">
                        <a href="#" class="text-yellow-500 hover:text-yellow-600 mr-2">Edit</a>
                        <form action="{{ route('genres.destroy', $genre) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-4 py-2 text-center">No genres found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
