<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Comic</h1>
        <form action="{{ route('comics.update', $comic->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $comic->title) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
                <select name="author_id" id="author_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ $author->id == old('author_id', $comic->author_id) ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="genres" class="block text-sm font-medium text-gray-700">Genres</label>
                <select name="genres[]" id="genres" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple required>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', $selectedGenres)) ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="synopsis" class="block text-sm font-medium text-gray-700">Synopsis</label>
                <textarea name="synopsis" id="synopsis" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ old('synopsis', $comic->synopsis->content ?? '') }}</textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @if($comic->image)
                    <img src="{{ asset('images/'.$comic->image) }}" alt="Comic Image" class="mt-2 w-32">
                @endif
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
