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
      aspro: {
        primary: 'var(--aspro-primary)',
        dark: 'var(--aspro-primary-dark)',
        light: 'var(--aspro-primary-light)',
      },
    },
        },
    },

    plugins: [forms],
};
