<!-- resources/views/create/create-publisher.blade.php -->

<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Publisher</h1>
        <!-- Kotak di sekitar form -->
        <div class="bg-white border border-gray-300 rounded-lg shadow-lg p-6">
            <form action="{{ route('publishers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-medium">Address</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
