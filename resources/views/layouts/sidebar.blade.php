<!-- Sidebar -->
<div id="sidebar" class="bg-white dark:bg-gray-800 w-64 min-h-screen shadow-md transform transition-transform -translate-x-full md:translate-x-0">
    <div class="p-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-500">Sidebar</h2>
        <ul class="mt-4">
            <!-- Home Link -->
            <li class="mb-2">
                <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Home') }}
                </a>
            </li>
            <!-- Comics Link -->
            <li class="mb-2">
                <a href="{{ route('comics.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Comics') }}
                </a>
            </li>
            <!-- Authors Link -->
            <li class="mb-2">
                <a href="{{ route('authors.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Authors') }}
                </a>
            </li>
            <!-- Publishers Link -->
            <li class="mb-2">
                <a href="{{ route('publishers.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Publisher') }}
                </a>
            </li>
            <!-- Genres Link -->
            <li class="mb-2">
                <a href="{{ route('genres.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Genre') }}
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('chapters.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Chapter') }}
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Overlay for small screens -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 z-10 hidden md:hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    });
</script>
