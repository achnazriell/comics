<!-- resources/views/reviews/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Review for: ') . $comic->title }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('review.store', $comic->id) }}" method="POST">
                @csrf

                <!-- Since the comic is already selected, no need for a select dropdown -->
                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                    <input type="number" name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" min="1" max="5" required>
                </div>

                <div class="mb-4">
                    <label for="review" class="block text-sm font-medium text-gray-700">Review</label>
                    <textarea name="review" id="review" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
