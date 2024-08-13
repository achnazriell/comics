<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Step 1: Comic Details</h1>
        <form action="{{ route('comics.store.step1') }}" method="POST">
            @csrf

            <!-- Title, Author, Publisher, Genres, Synopsis -->
            <!-- Similar to the form you already have in your `create` method -->

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Next</button>
            </div>
        </form>
    </div>
</x-app-layout>
