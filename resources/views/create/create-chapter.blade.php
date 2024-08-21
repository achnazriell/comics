<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Chapter</h1>
        <form action="{{ route('chapters.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            @csrf
            <!-- Hidden field for comic_id -->
            <input type="hidden" name="comic_id" value="{{ request()->query('comic_id') }}" />
        
            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                <div id="image-inputs">
                    <input type="file" name="images[]" id="images" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple>
                </div>
                <button type="button" id="add-image" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Add More Images</button>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Chapter</button>
        </form>        
    </div>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM fully loaded and parsed');

            document.getElementById('add-image').addEventListener('click', function () {
                const imageInputs = document.getElementById('image-inputs');
                const newInput = document.createElement('input');
                newInput.type = 'file';
                newInput.name = 'images[]';
                newInput.className = 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm';
                imageInputs.appendChild(newInput);
            });

            document.querySelector('form').addEventListener('submit', function (event) {
                console.log('Form submission triggered');

                const allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                const files = document.querySelectorAll('input[type="file"]');

                for (let fileInput of files) {
                    for (let file of fileInput.files) {
                        console.log('Checking file:', file.name, file.size);

                        const fileExtension = file.name.split('.').pop().toLowerCase();
                        if (!allowedExtensions.includes(fileExtension)) {
                            event.preventDefault();
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid File Type',
                                text: 'Only JPEG, PNG, and GIF files are allowed.',
                            });
                            console.log('Invalid file type:', fileExtension);
                            return;
                        }

                        if (file.size > maxSize) {
                            event.preventDefault();
                            Swal.fire({
                                icon: 'error',
                                title: 'File Too Large',
                                text: 'Each file must be less than 2MB.',
                            });
                            console.log('File too large:', file.size);
                            return;
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
