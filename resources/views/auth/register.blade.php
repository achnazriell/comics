<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <button type="button"
                    class="absolute inset-y-0 end-0 flex items-center px-4 text-gray-600 dark:text-gray-400"
                    onclick="togglePasswordVisibility('password', 'eye-icon')">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <!-- Eye icon -->
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12m-3 0a3 3 0 1 0 6 0 3 3 0 1 0-6 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.478 5 12 5c4.522 0 8.268 2.943 9.542 7-1.274 4.057-5.02 7-9.542 7-4.522 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm the password')" />

            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <button type="button"
                    class="absolute inset-y-0 end-0 flex items-center px-4 text-gray-600 dark:text-gray-400"
                    onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-confirm')">
                    <svg id="eye-icon-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <!-- Eye icon -->
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12m-3 0a3 3 0 1 0 6 0 3 3 0 1 0-6 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.478 5 12 5c4.522 0 8.268 2.943 9.542 7-1.274 4.057-5.02 7-9.542 7-4.522 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <p>Already have an account?</p>
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Login') }}
            </a>
            &emsp;&emsp;&emsp;&emsp;
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- SweetAlert2 Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @elseif ($errors->any())
                Swal.fire({
                    title: 'Oops!',
                    text: "{{ $errors->first() }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <!-- Eye with slash icon -->
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.98 8.5a10.978 10.978 0 0 1 8.02-3.5c4.478 0 8.32 2.76 9.904 6.72a1 1 0 0 1 0 .56c-.02.06-.04.12-.06.18-.02.05-.04.1-.06.15-.17.43-.38.84-.6 1.22a10.978 10.978 0 0 1-8.02 3.5c-4.478 0-8.32-2.76-9.904-6.72-.02-.06-.04-.12-.06-.18a1 1 0 0 1 0-.56c.18-.42.38-.84.6-1.22M15 12m-3 0a3 3 0 1 0 6 0 3 3 0 1 0-6 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2 2l20 20" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML =
                    `
                    <!-- Eye icon -->
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12m-3 0a3 3 0 1 0 6 0 3 3 0 1 0-6 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.478 5 12 5c4.522 0 8.268 2.943 9.542 7-1.274 4.057-5.02 7-9.542 7-4.522 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</x-guest-layout>
