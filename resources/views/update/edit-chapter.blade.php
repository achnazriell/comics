<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Chapter</h1>




        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            
                <!-- Display success or error messages -->
                @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif


        <form id="edit-chapter-form" action="{{ route('chapters.update', $chapter) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hidden fields for chapter and comic IDs -->
            <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
            <input type="hidden" name="comic_id" value="{{ $chapter->comic_id }}">

            <!-- Comic title -->
            <div class="mb-4">
                <label for="comic_id" class="block text-gray-700">Comic</label>
                <p class="mt-1 block w-full bg-gray-200 p-2 rounded">{{ $chapter->comic->title }}</p>
            </div>

            <!-- Display existing chapter images with delete option -->
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

            <!-- Submit button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Finish</button>

            <button type="button" id="addImageToExistingChapter" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Image to Existing Chapter</button>

            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" onclick="window.location.href='{{ route('comics.edit', $chapter->comic_id) }}'">Back</button>

            <a href="{{ route('chapters.create', ['comic_id' => $chapter->comic_id]) }}" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add Another Chapter</a>

        </form>

        

        <!-- Display all chapters -->
        <div id="allChapters" class="mt-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">All Chapters</h3>
            <div class="grid grid-cols-3 gap-4 mb-4">
                @foreach($chapters as $index => $ch)
                    <div class="relative p-2 border rounded">
                        <p>Chapter {{ $index + 1 }}</p>
                        <a href="{{ route('chapters.edit', $ch->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        <!-- Delete button -->
                        <form id="delete-form-{{ $ch>id }}" action="{{ route('chapters.destroy', $ch->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="oneClickDelete({{ $ch->id }})" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
-                        
                    </div>
                @endforeach
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- JavaScript for handling form actions -->
        <script>
            // Function to delete chapter with one click
            function oneClickDelete(chapterId) {
                if (confirm('Are you sure you want to delete this chapter?')) {
                    document.getElementById('delete-form-' + chapterId).submit();
                }
            }

            // Function to add image input to existing chapter
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

            

        // Validate image before form submission
            document.getElementById('edit-chapter-form').addEventListener('submit', function(event) {
                const inputs = document.querySelectorAll('input[type="file"]');
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                const maxFileSize = 2 * 1024 * 1024; // 2MB

                for (const input of inputs) {
                    if (input.files.length > 0) {
                        const file = input.files[0];
                        const fileExtension = file.name.split('.').pop().toLowerCase();

                        if (!allowedExtensions.includes(fileExtension)) {
                            event.preventDefault();
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid file type',
                                text: 'Only JPG, JPEG, PNG, and GIF files are allowed.',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        if (file.size > maxFileSize) {
                            event.preventDefault();
                            Swal.fire({
                                icon: 'error',
                                title: 'File too large',
                                text: 'The file size must not exceed 2MB.',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }
                    }
                }
            });
        </script>
    </div>
</x-app-layout>
