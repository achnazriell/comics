<div class="{{ $type == 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }} px-4 py-3 rounded relative mt-4" role="alert">
    <strong class="font-bold">{{ $type == 'success' ? 'Success!' : 'Error!' }}</strong>
    <span class="block sm:inline">{{ $message }}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg class="fill-current h-6 w-6 {{ $type == 'success' ? 'text-green-500' : 'text-red-500' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="{{ $type == 'success' ? 'M7.629 12.357l-3.243-3.243 1.414-1.414L7.629 9.53l7.636-7.636 1.415 1.414L7.629 12.357z' : 'M10 8.586L13.586 12l1.414-1.414L11.414 7.172 15 3.586 13.586 2 10 5.586 6.414 2 5 3.586l3.586 3.586-3.586 3.586L6.414 12 10 8.586z' }}" />
        </svg>
    </span>
</div>
