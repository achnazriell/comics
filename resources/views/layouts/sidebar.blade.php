<!-- resources/views/layouts/sidebar.blade.php -->

<!-- Toggle Button -->
<button id="sidebarToggle" class="md:hidden p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
    </svg>
</button>

<!-- Sidebar -->
<div id="sidebar" class="bg-white dark:bg-gray-800 w-64 min-h-screen shadow-md transform transition-transform -translate-x-full md:translate-x-0">
    <div class="p-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-500">Sidebar</h2>
        <ul class="mt-4">
            <li class="mb-2">
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Dashboard</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Orders</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Products</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Reports</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Settings</a>
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
