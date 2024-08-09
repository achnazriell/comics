<!-- resources/views/components/card.blade.php -->

<div {{ $attributes->merge(['class' => 'bg-white shadow-md rounded-lg overflow-hidden']) }}>
    @if($image)
    <img src="{{ asset('storage/' . $image) }}" class="w-full h-48 object-cover" alt="{{ $title }}">
    @endif
    <div class="p-4">
        <h4 class="text-xl font-semibold mb-2">{{ $title }}</h4>
        <p class="text-gray-600">{{ $description }}</p>
        <a href="#" class="text-blue-500 hover:underline mt-2 block">{{ $buttonText }}</a>
    </div>
</div>
