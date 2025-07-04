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
                    DEFAULT: '#1a2238',
                    light: '#2a3248',
                    dark: '#0a1228',
                },
                secondary: {
                    DEFAULT: '#9daaf2',
                    light: '#b8c4f7',
                    dark: '#7889ed',
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
