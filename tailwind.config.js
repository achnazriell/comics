import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode using the class strategy
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Extend colors for light and dark modes
                background: {
                    light: '#f5f5f5', // Light mode background color
                    dark: '#333',    // Dark mode background color
                },
                text: {
                    light: '#333',    // Light mode text color
                    dark: '#fff',    // Dark mode text color
                },
            },
        },
    },

    plugins: [forms],
};
