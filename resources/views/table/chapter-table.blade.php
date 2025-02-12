<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Chapters</h1>
        <a href="{{ route('chapters.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add
            Chapter</a>

        <!-- Alert Section -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M7.629 12.357l-3.243-3.243 1.414-1.414L7.629 9.53l7.636-7.636 1.415 1.414L7.629 12.357z" />
                    </svg>
                </span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 8.586L13.586 12l1.414-1.414L11.414 7.172 15 3.586 13.586 2 10 5.586 6.414 2 5 3.586l3.586 3.586-3.586 3.586L6.414 12 10 8.586z" />
                    </svg>
                </span>
            </div>
        @endif

        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white border border-black rounded-lg shadow-md">
                <thead class="bg-gradient-to-r from-gray-900 via-gray-400 to-gray-900 ... text-white">
                    <tr class="border border-black">
                        <th class="py-2 px-4 border border-black">No</th>
                        <th class="py-2 px-4 border border-black">Comic</th>
                        <th class="py-2 px-4 border border-black">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chapters as $chapter)
                        <tr class="border border-black">
                            <td class="py-2 px-4 border border-black">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border border-black">{{ $chapter->comic->title }}</td>
                            <td class="py-2 px-4 border border-black">
                                <a href="{{ route('chapters.edit', $chapter) }}"
                                    class="bg-gradient-to-r from-gray-900 to-blue-500 ... text-white px-4 py-2 rounded hover:bg-yellow-600">Update</a>
                                <form action="{{ route('chapters.destroy', $chapter) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-gradient-to-r from-gray-900 to-red-500 ... text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- SweetAlert2 Alert Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}'
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '{{ session('error') }}'
                    });
                @endif
            });

            function confirmDeletion() {
                return Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        return true;
                    }
                    return false;
                });
            }
        </script>
    </div>
</x-app-layout>
