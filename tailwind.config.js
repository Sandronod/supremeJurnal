const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: '#00296b',
                    900: '#00296b',
                    800: '#003f88',
                    700: '#00497b',
                    600: '#00509d',
                    500: '#0063a6',
                    bg: '#edf2fb',
                },
            },
            fontFamily: {
                heading: ['"BPG Nino Mtavruli"', ...defaultTheme.fontFamily.sans],
                sans: ['"DejaVu Sans Condensed"', '"Noto Sans Georgian"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
