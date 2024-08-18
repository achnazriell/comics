<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Publishers</h1>
        <a href="{{ route('publishers.create') }}" class="bg-gradient-to-r from-gray-900 to-gray-400 ... text-white px-4 py-2 rounded hover:bg-blue-600 border border-black">Add Publisher</a>

        <!-- Search Form -->
        <form action="{{ route('publishers.index') }}" method="GET" class="flex items-center mt-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search Publishers..."
                class="border border-gray-700 rounded-md px-4 py-2 w-1/3 focus:outline-none focus:ring focus:border-gray-300">
            <button type="submit" class="ml-2 px-4 py-2 bg-gradient-to-r from-gray-900 to-gray-400 ... text-white rounded-md hover:bg-blue-600">
                Search
            </button>

            <a href="{{ route('publishers.index') }}" class="ml-2 px-4 py-2 bg-gradient-to-r to-gray-900 from-gray-400 ... text-white rounded-md hover:bg-gray-600">Reset</a>
        </form>

        <div class="table-container rounded-lg shadow-md mt-4 overflow-x-auto">
            <table class="table-auto min-w-full bg-white rounded-lg shadow-md">
                <thead class='bg-gradient-to-r from-gray-900 via-gray-400 to-gray-900 ... text-white'>
                    <tr>
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Publisher Name</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($publishers as $index => $publisher)
                        <tr>
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $publisher->name }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('publishers.edit', $publisher) }}" class="inline-block px-4 py-2 bg-gradient-to-r from-gray-900 to-blue-500 ... text-white rounded hover:bg-blue-600 m-2">Edit</a>
                                <form action="{{ route('publishers.destroy', $publisher) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-gray-900 to-red-500 ... text-white rounded hover:bg-red-600 m-2" onclick="return confirm('Are you sure want to delete this publisher?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- SweetAlert2 Alert Script -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $publishers->links() }}
        </div>
    </div>
</x-app-layout>
