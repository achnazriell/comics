<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<<<<<<< HEAD
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        });
    </script>
</head>
<!-- Tambahkan di bagian atas dari body atau di bagian navbar -->
<button id="sidebarToggle" class="p-2 m-2 bg-gray-800 text-white rounded-md md:hidden">
    ☰
</button>


<body class="font-sans antialiased">
    <!-- Tambahkan di bagian atas dari body atau di bagian navbar -->

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
=======
                    <!-- Tabel Dropdown -->
                    <div @mouseenter="open = true" @mouseleave="open = false" class="relative">
                        <button @click="open = !open"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white dark:text-gray-400 bg dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 sm:flex sm:items-center sm:ms-2 sm:mt-4">
                            <div>{{ __('Table') }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-gray-800">
                                <x-dropdown-link :href="route('comics.index')">
                                    {{ __('Comics') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('authors.index')">
                                    {{ __('Authors') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('publishers.index')">
                                    {{ __('Publisher') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('genres.index')">
                                    {{ __('Genre') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('chapters.create')">
                                    {{ __('chapter') }}
                                </x-dropdown-link>
                                <!-- Add more links here as needed -->
                            </div>
                        </div>
>>>>>>> 56b114c50f4b4b9a23812433d9c2454a9756e1d6
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        });
    </script>
</head>
<!-- Tambahkan di bagian atas dari body atau di bagian navbar -->
<button id="sidebarToggle" class="p-2 m-2 bg-gray-800 text-white rounded-md md:hidden">
    ☰
</button>


<body class="font-sans antialiased">
    <!-- Tambahkan di bagian atas dari body atau di bagian navbar -->

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
