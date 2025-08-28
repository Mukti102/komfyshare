import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
         "./node_modules/flowbite/**/*.js", // <--- ini wajib
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#b40d4dff',
                secondary: '#2b2c2fff',
                dark: '#1f1f1fff',
            },
        },
    },

    plugins: [forms,
        require('flowbite/plugin')
    ],
};
