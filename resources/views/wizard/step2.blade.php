<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Step 2: Upload Image</h1>
        <form action="{{ route('comics.store.step2') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Image Upload -->

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Next</button>
            </div>
        </form>
    </div>
</x-app-layout>
