<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Chapter</h1>
        
        <!-- Wizard Step 3: Add Chapter -->
        <div id="step3" class="wizard-step">
            <h2 class="text-xl font-semibold mb-4">Edit Chapter</h2>
            <form action="{{ route('chapters.update', $chapter) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="comic_id" class="block text-gray-700">Comic</label>
                    <input type="hidden" name="comic_id" value="{{ $chapter->comic_id }}">
                    <p class="mt-1 block w-full bg-gray-200 p-2 rounded">{{ $chapter->comic->title }}</p>
                </div>

                <!-- Menampilkan gambar yang sudah ada -->
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Current Chapter Images</h3>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        @foreach($chapter->images as $image)
                            <div class="relative">
                                <img src="{{ asset('chapter_images/' . $image->image) }}" alt="Chapter Image" class="w-full h-32 object-cover">
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="absolute top-0 right-0 m-2">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Input untuk mengunggah gambar baru -->
                <div id="chapterSection">
                    <h3 class="text-sm font-medium text-gray-700 mb-2"></h3>
                    <div class="mb-4">
                        <label for="chapter_images_{{ $chapter->id }}" class="block text-sm font-medium text-gray-700">New Chapter Images</label>
                        <input type="file" name="chapter_images[]" id="chapter_images_{{ $chapter->id }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple>
                    </div>
                </div>

                <!-- Tombol untuk menambahkan input gambar baru -->
                <button type="button" id="addChapter"
                    class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Another Chapter Image</button>

                <!-- Tombol navigasi -->
                <div class="mb-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Chapter {{ $chapter->number }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
