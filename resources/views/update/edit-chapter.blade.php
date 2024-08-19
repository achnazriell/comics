<x-app-layout>
        <!-- Wizard Step 3: Add Chapter -->
        <div id="step3" class="wizard-step">
            <h2 class="text-xl font-semibold mb-4">Edit Chapter</h2>
            <form action="{{ route('chapters.update', $chapter) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

            <!-- Hidden fields for chapter and comic IDs -->
            <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
            <input type="hidden" name="comic_id" value="{{ $chapter->comic_id }}">

            <div class="mb-4">
                <label for="comic_id" class="block text-gray-700">Comic</label>
                <p class="mt-1 block w-full bg-gray-200 p-2 rounded">{{ $chapter->comic->title }}</p>
            </div>

            <!-- Display existing chapter images -->
            <div id="currentChapterSection">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Current Chapter Images</h3>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    @foreach($chapter->images as $image)
                        <div class="relative">
                            <img src="{{ asset('chapter_images/' . $image->image) }}" alt="Chapter Image" class="w-full h-32 object-cover">
                            <!-- Checkbox for image deletion -->
                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="absolute top-0 right-0 m-2">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section for adding new images -->
            <div id="chapterSection">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Add New Chapter Images</h3>
                <div id="chapterImagesWrapper" class="mb-4">
                    <!-- Initial image input -->
                    <div class="chapter-image-input mb-4">
                        <label for="chapter_images" class="block text-sm font-medium text-gray-700">Chapter Images</label>
                        <input type="file" name="chapter_images[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- Section for adding new chapters -->
            <div id="newChaptersSection">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Add New Chapters</h3>
                <div id="newChaptersWrapper" class="mb-4">
                    <!-- Existing chapters will be appended here -->
                </div>
            </div>

            <!-- Display all chapters -->
            <div id="allChapters">
                <h3 class="text-sm font-medium text-gray-700 mb-2">All Chapters</h3>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    @foreach($chapters as $index => $ch)
                        <div class="relative p-2 border rounded">
                            <p>Chapter {{ $index + 1 }}</p>
                            <a href="{{ route('chapters.edit', $ch->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Buttons for adding chapters and images -->
            <a href="{{ route('chapters.create') }}" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Another Chapter</a>
            <button type="button" id="addImageToExistingChapter" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Image to Existing Chapter</button>

            <!-- Navigation buttons -->
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" onclick="window.location.href='{{ route('comics.edit', $chapter->comic_id) }}'">Back</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Finish</button>
        </form>
    </div>

    <script>
        // Function to add a new chapter form
        document.getElementById('addChapter').addEventListener('click', function() {
            const wrapper = document.getElementById('newChaptersWrapper');
            const index = wrapper.children.length;
            const newChapter = document.createElement('div');
            newChapter.classList.add('chapter-image-input', 'mb-4');
            newChapter.innerHTML = `
                <h4 class="text-sm font-medium text-gray-700 mb-2">Chapter ${index + 1}</h4>
                <label class="block text-sm font-medium text-gray-700">Chapter Image</label>
                <input type="file" name="new_chapters[][image]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            `;
            wrapper.appendChild(newChapter);
        });

        // Function to add image input for existing chapters
        document.getElementById('addImageToExistingChapter').addEventListener('click', function() {
            const wrapper = document.getElementById('chapterImagesWrapper');
            const newInput = document.createElement('div');
            newInput.classList.add('chapter-image-input', 'mb-4');
            newInput.innerHTML = `
                <label class="block text-sm font-medium text-gray-700">Chapter Images</label>
                <input type="file" name="chapter_images[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            `;
            wrapper.appendChild(newInput);
        });
    </script>
</x-app-layout>
