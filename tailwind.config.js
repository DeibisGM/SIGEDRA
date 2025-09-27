/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/preline/dist/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'sigedra-primary': '#193F4C',
                'sigedra-primary-dark': '#13323D',
                'sigedra-secondary': '#7AA352',
                'sigedra-accent': '#34A853',
                'sigedra-error': '#D9534F',
                'sigedra-warning': '#F0AD4E',
                'sigedra-bg': '#F9FAFB',
                'sigedra-card': '#FFFFFF',
                'sigedra-light-colored-bg': '#F7FAF4',
                'sigedra-input': '#F3F4F6',
                'sigedra-border': '#E5E7EB',

                // Colores de texto
                'sigedra-text-dark': '#1F2937',
                'sigedra-text-medium': '#4B5563',
                'sigedra-text-light': '#9CA3AF',
            },
            fontSize: {
                'sm': '0.875rem', // 14px
                'base': '1rem',   // 16px
                'lg': '1.125rem', // 18px
                'xl': '1.25rem',  // 20px
                '2xl': '1.5rem', // 24px
                '3xl': '1.875rem', // 30px
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
