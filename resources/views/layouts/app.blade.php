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
    <!-- Scripts -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.10.5/dist/algoliasearch.umd.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Preline Select CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.css">

    <!-- Preline Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Algolia search setup
            const client = algoliasearch('YourApplicationID',
                'YourSearchOnlyAPIKey'); // Use Search-Only API Key for security
            const index = client.initIndex('dashboard');

            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const resultsContainer = document.getElementById('results');

            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const query = searchInput.value;

                index.search(query).then(({
                    hits
                }) => {
                    resultsContainer.innerHTML = '';

                    if (hits.length > 0) {
                        const ul = document.createElement('ul');
                        hits.forEach(hit => {
                            const li = document.createElement('li');
                            li.textContent =
                                `${hit.title} - ${hit.author}`; // Adjust based on your data
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

    <script>
window.addEventListener('load', function() {
    setTimeout(function() {
        // Tambahkan class 'slide-out-up' untuk memulai transisi
        document.getElementById('preloader').classList.add('transform', '-translate-y-full');

        // Hapus preloader setelah transisi selesai (misal 700ms)
        setTimeout(function() {
            document.getElementById('preloader').style.display = 'none';
            document.getElementById('content').classList.remove('opacity-0');
            document.getElementById('content').classList.add('opacity-100');
        }, 700); // Sesuaikan dengan durasi transisi
    }, 1000); // Durasi preloader ditampilkan (3000ms = 3 detik)
});

    </script>
</head>

<body class="font-sans antialiased">
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
            <div id="preloader" class="fixed inset-0 flex items-center justify-center bg-white z-50 transition-transform duration-700 transform">
                <img src="{{ asset('images/KomikQue1.png') }}" alt="Loading" class="h-20 w-20 animate-shake">
            </div>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
