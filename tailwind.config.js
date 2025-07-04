import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
                primary: {
                    DEFAULT: '#1e3a8a',
                    light: '#3730a3',
                    dark: '#1e40af',
                },
                secondary: {
                    DEFAULT: '#f59e0b',
                    light: '#fbbf24',
                    dark: '#d97706',
                },
                accent: {
                    DEFAULT: '#ff6a3d',
                    light: '#ff8a6d',
                    dark: '#e5502d',
                },
                highlight: {
                    DEFAULT: '#f4db7d',
                    light: '#f8e5a0',
                    dark: '#f0d15a',
                },
            },
        },
    },

    plugins: [forms],
};
