<nav x-data="{ open: false, searchOpen: false, sidebarOpen: false }" class="bg-gray-400 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-400 dark:text-gray-300">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link :href="route('comics.index')" :active="request()->routeIs('comics.index')" class="text-gray-400 dark:text-gray-300">
                        {{ __('Comics') }}
                    </x-nav-link>

                    <x-nav-link :href="route('authors.index')" :active="request()->routeIs('authors.index')" class="text-gray-400 dark:text-gray-300">
                        {{ __('Authors') }}
                    </x-nav-link>

                    <x-nav-link :href="route('publishers.index')" :active="request()->routeIs('publishers.index')" class="text-gray-400 dark:text-gray-300">
                        {{ __('Publishers') }}
                    </x-nav-link>

                    <x-nav-link :href="route('genres.index')" :active="request()->routeIs('genres.index')" class="text-gray-400 dark:text-gray-300">
                        {{ __('Genre') }}
                    </x-nav-link>

                    <x-nav-link :href="route('chapters.index')" :active="request()->routeIs('chapters.index')" class="text-gray-400 dark:text-gray-300">
                        {{ __('Chapters') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Search Button -->
            <div class="relative ml-auto flex items-center">
                <button @click="searchOpen = !searchOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- Change icon based on searchOpen state -->
                        <path :class="{ 'hidden': searchOpen, 'inline-flex': !searchOpen }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16.293 17.293a6 6 0 111.414-1.414l3.5 3.5a1 1 0 01-1.414 1.414l-3.5-3.5zM10 4a6 6 0 106 6 6 6 0 00-6-6z" />
                        <path :class="{ 'hidden': !searchOpen, 'inline-flex': searchOpen }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute z-50 right-0 mt-0 bg-transparent dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md shadow-lg w-80 p-2 mr-11">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" placeholder="Search..."
                            class="border border-gray-300 dark:border-gray-600 rounded-md p-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200"
                            value="{{ old('search', $search) }}">
                        <button type="submit" class="ml-2 p-2 bg-gray-100 text-gray-800 rounded-md">Search</button>
                    </form>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <!-- Dropdown Trigger -->
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="inline-flex items-center justify-center p-2 rounded-full text-white dark:text-gray-400 bg-gray-800 dark:bg-gray-800 hover:bg-gray-700 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-700 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                        <img src="{{ asset('images/user.png') }}" alt="User Photo" class="h-7 w-7 rounded-full object-cover">
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="dropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md shadow-lg">
                        <div class="p-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-900">
                                {{ __('Profile') }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-900">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-400 dark:text-gray-300">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('genres.index')" :active="request()->routeIs('genres.index')" class="text-gray-400 dark:text-gray-300">
                {{ __('Genres') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-400 dark:text-gray-300">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                            this.closest('form').submit();" class="text-gray-400 dark:text-gray-300">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Overlay for small screens -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 z-10 hidden md:hidden"></div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
