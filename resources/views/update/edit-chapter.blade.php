<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Chapter</h1>
        <form action="{{ route('chapters.update', $chapter) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="comic_id" class="block text-gray-700">Comic</label>
                <select name="comic_id" id="comic_id" class="mt-1 block w-full">
                    @foreach($comics as $comic)
                        <option value="{{ $comic->id }}" {{ $comic->id == $chapter->comic_id ? 'selected' : '' }}>
                            {{ $comic->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="number" class="block text-gray-700">Chapter Number</label>
                <input type="number" name="number" id="number" class="mt-1 block w-full" value="{{ old('number', $chapter->number) }}" required>
            </div>
            <div class="mb-4">
                <label for="images" class="block text-gray-700">Upload Images</label>
                <input type="file" name="images[]" id="images" class="mt-1 block w-full" multiple>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
