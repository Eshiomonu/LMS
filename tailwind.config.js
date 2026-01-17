import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#e7f0f4',
                    100: '#cfeaf1',
                    200: '#9fd5e3',
                    300: '#6fc0d5',
                    400: '#2fa7cc',
                    500: '#0087c0',
                    DEFAULT: '#006ea9',
                    600: '#006ea9',
                    700: '#005887',
                    800: '#00415f',
                    900: '#003048'
                }
            },
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
    plugins: [],
};
