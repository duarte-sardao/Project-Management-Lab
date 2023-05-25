const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                bgColor: '#FFFCF9',
                mainBlue: '#578AD6',
                lightBlue: '#B9CEED',
                lighterBlue: '#d5e3f8',
                highlightBlue: '#244D89',
                indigo: '#dbeafe',
                stone: '#fafaf9',
                black: '#0a0a0a',
                skyBlue: '#dbeafe',
                adminMainBlue: '#7BA3DF',
                adminBackground: '#C6D2E3'
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require("daisyui")
    ],
};
