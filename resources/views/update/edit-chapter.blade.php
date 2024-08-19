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
                <div id="currentChapterSection">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Current Chapter Images</h3>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        @foreach($chapter->images as $image)
                            <div class="relative">
                                <img src="{{ asset('chapter_images/' . $image->image) }}" alt="Chapter Image" class="w-full h-32 object-cover">
                                <!-- Checkbox untuk menghapus gambar -->
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="absolute top-0 right-0 m-2">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Input untuk mengunggah gambar baru -->
                <div id="chapterSection">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Add New Chapter Images</h3>
                    <div class="mb-4">
                        <label for="chapter_images" class="block text-sm font-medium text-gray-700">Chapter Images</label>
                        <input type="file" name="chapter_images[]" id="chapter_images"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            multiple>
                    </div>
                </div>

                <!-- Display all chapters -->
                <div id="allChapters">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">All Chapters</h3>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        @foreach($chapters as $index => $ch)
                            <div class="relative p-2 border rounded">
                                <p>Chapter {{ $index + 1 }}</p> <!-- Display chapter index starting from 1 -->
                                <a href="{{ route('chapters.edit', $ch->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol untuk menambahkan input gambar baru -->
                <button type="button" id="addChapter"
                    class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Another Chapter Image</button>

                <!-- Tombol navigasi -->
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                    onclick="showStep(2)">Back</button>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Finish</button>
            </form>
        </div>
    </div>
</x-app-layout>
    