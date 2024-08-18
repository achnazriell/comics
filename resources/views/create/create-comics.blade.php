<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Comic Wizard</h1>

        <form id="comicWizardForm" action="{{ route('comics.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow-md">
            @csrf

            <!-- Step 1: Comic Details -->
            <div id="step1" class="wizard-step">
                <h2 class="text-xl font-semibold mb-4">Step 1: Comic Details</h2>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
                    <select name="author_id" id="author_id"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Choose a Author</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="publisher_id" class="block text-sm font-medium text-gray-700">Publisher</label>
                    <select name="publisher_id" id="publisher_id"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Choose a Publisher</option>
                        @foreach ($publishers as $publisher)
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="genres" class="block text-sm font-medium text-gray-700">Genres</label>
                    <select multiple name="genres[]" id="genres"
                        data-hs-select='{
                            "placeholder": "Choose a genre",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                        class="hidden">
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ (collect(old('genres'))->contains($genre->id)) ? 'selected' : '' }}>
                                {{ $genre->name }}</option>
                        @endforeach
                    </select>
                    <!-- End Select -->
                </div>
                <div class="mb-4">
                    <label for="synopsis" class="block text-sm font-medium text-gray-700">Synopsis</label>
                    <textarea name="synopsis" id="synopsis"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('synopsis') }}</textarea>
                </div>
                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    onclick="showStep(2)">Next</button>
            </div>

            <!-- Step 2: Upload Image -->
            <div id="step2" class="wizard-step" style="display:none;">
                <h2 class="text-xl font-semibold mb-4">Step 2: Upload Image</h2>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <!-- Image preview -->
                    <img id="image-preview" class="mt-2 w-32" style="{{ old('image') ? '' : 'display: none;' }}"
                    src="{{ old('image') ? asset('images/' . old('image')) : '' }}" alt="Old Image Preview"/>
                </div>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                    onclick="showStep(1)">Back</button>
                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    onclick="showStep(3)">Next</button>
            </div>
            <!-- Step 3: Add Chapter -->
            <div id="step3" class="wizard-step" style="display:none;">
                <h2 class="text-xl font-semibold mb-4">Step 3: Add Chapter</h2>
                <div id="chapterSection">
                    <!-- Chapter Input Fields -->
                    <div class="mb-4">
                        <label for="chapter_images" class="block text-sm font-medium text-gray-700">Chapter
                            Images</label>
                        <input type="file" name="chapter_images[]" id="chapter_images"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            multiple>
                    </div>
                </div>
                <button type="button" id="addChapter"
                    class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Another Chapter</button>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                    onclick="showStep(2)">Back</button>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Finish</button>
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

        document.getElementById('chapter_images').addEventListener('change', function(event) {
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

                <label for="chapter_images" class="block text-sm font-medium text-gray-700">Chapter Images</label>
                <input type="file" name="chapter_images[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple >
            `;
            chapterSection.appendChild(newChapter);
        });

        // Debugging: Check form submission
        document.getElementById('comicWizardForm').addEventListener('submit', function(event) {
            console.log('Form is being submitted.');
            // You can add further debugging or validation logic here
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Preline Select
            document.querySelectorAll('[data-hs-select]').forEach(el => {
                new HSSelect(el);
            });
        });
    </script>

    <!-- SweetAlert2 Script for Validation Errors -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                let errorText = '';
                @foreach ($errors->all() as $error)
                    errorText += '{{ $error }}\n';
                @endforeach
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorText
                });
            @endif
        });
    </script>
</x-app-layout>
