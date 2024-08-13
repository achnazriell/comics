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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <!-- Scripts -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.10.5/dist/algoliasearch.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Algolia search setup
            const client = algoliasearch('YourApplicationID', 'YourSearchOnlyAPIKey'); // Use Search-Only API Key for security
            const index = client.initIndex('dashboard');

            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const resultsContainer = document.getElementById('results');

            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const query = searchInput.value;

                index.search(query).then(({ hits }) => {
                    resultsContainer.innerHTML = '';

                    if (hits.length > 0) {
                        const ul = document.createElement('ul');
                        hits.forEach(hit => {
                            const li = document.createElement('li');
                            li.textContent = `${hit.title} - ${hit.author}`; // Adjust based on your data
                            ul.appendChild(li);
                        });
                        resultsContainer.appendChild(ul);
                    } else {
                        resultsContainer.innerHTML = '<p>No results found.</p>';
                    }
                }).catch(err => {
                    console.error('Error during search:', err);
                });
            });
        });
    </script>

    <body class="font-sans antialiased">
        <!-- Toggle button for mobile -->
        <button id="sidebarToggle" class="p-2 m-2 bg-gray-800 text-white rounded-md md:hidden">
            ☰
        </button>

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
