<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Step 3: Add Chapters</h1>
        <form action="{{ route('comics.store.step3') }}" method="POST">
            @csrf

            <!-- Chapter Title, Number, and Content Fields -->
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Chapter</button>
            </div>
        </form>

        <div class="mt-6">
            <a href="{{ route('comics.finish') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Finish</a>
        </div>
    </div>
</x-app-layout>
