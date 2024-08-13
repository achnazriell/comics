<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Comic Wizard</h1>
        
        <form id="comicWizardForm" action="{{ route('comics.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            @csrf

            <!-- Step 1: Comic Details -->
            <div id="step1" class="wizard-step">
                <h2 class="text-xl font-semibold mb-4">Step 1: Comic Details</h2>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
                    <select name="author_id" id="author_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="publisher_id" class="block text-sm font-medium text-gray-700">Publisher</label>
                    <select name="publisher_id" id="publisher_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        @foreach ($publishers as $publisher)
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="genres" class="block text-sm font-medium text-gray-700">Genres</label>
                    <select name="genres[]" id="genres" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple required>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="synopsis" class="block text-sm font-medium text-gray-700">Synopsis</label>
                    <textarea name="synopsis" id="synopsis" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                </div>
                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="showStep(2)">Next</button>
            </div>

            <!-- Step 2: Upload Image -->
            <div id="step2" class="wizard-step" style="display:none;">
                <h2 class="text-xl font-semibold mb-4">Step 2: Upload Image</h2>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <!-- Image preview -->
                    <img id="image-preview" class="mt-2 w-32" style="display: none;" />
                </div>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" onclick="showStep(1)">Back</button>
                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="showStep(3)">Next</button>
            </div>

            <!-- Step 3: Add Chapter -->
            <div id="step3" class="wizard-step" style="display:none;">
                <h2 class="text-xl font-semibold mb-4">Step 3: Add Chapter</h2>
                <div id="chapterSection">
                    <!-- Chapter Input Fields -->
                    <div class="mb-4">
                        <label for="chapter_title" class="block text-sm font-medium text-gray-700">Chapter Title</label>
                        <input type="text" name="chapter_title[]" id="chapter_title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="chapter_images" class="block text-sm font-medium text-gray-700">Chapter Images</label>
                        <input type="file" name="chapter_images[]" id="chapter_images" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple required>
                    </div>
                </div>
                <button type="button" id="addChapter" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Another Chapter</button>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" onclick="showStep(2)">Back</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Finish</button>
            </div>
        </form>
    </div>

    <script>
        function showStep(step) {
            document.querySelectorAll('.wizard-step').forEach((el) => el.style.display = 'none');
            document.getElementById('step' + step).style.display = 'block';
        }

        document.getElementById('image').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('image-preview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });

        document.getElementById('addChapter').addEventListener('click', function() {
            const chapterSection = document.getElementById('chapterSection');
            const newChapter = document.createElement('div');
            newChapter.className = 'mb-4';
            newChapter.innerHTML = `
                <label for="chapter_title" class="block text-sm font-medium text-gray-700">Chapter Title</label>
                <input type="text" name="chapter_title[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <label for="chapter_images" class="block text-sm font-medium text-gray-700">Chapter Images</label>
                <input type="file" name="chapter_images[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple required>
            `;
            chapterSection.appendChild(newChapter);
        });
    </script>
</x-app-layout>
