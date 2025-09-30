/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';

// Definir grayscale primero
const grayscale = {
    '0': '#FFFFFF',
    '25': '#FAFAFA',
    '50': '#fafafa',
    '100': '#f2f2f2',
    '150': '#e6e6e6',
    '200': '#d4d4d4',
    '300': '#b5b5b5',
    '400': '#949494',
    '500': '#787878',
    '600': '#5c5c5c',
    '700': '#404040',
    '800': '#292929',
    '900': '#121212',
    '950': '#000100',
};

export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'sigedra-primary': '#195a4c',
                'sigedra-primary-dark': '#13323D',
                'sigedra-secondary': '#6cbc5f',
                'sigedra-accent': '#34A853',
                'sigedra-error': '#D9534F',
                'sigedra-warning': '#F0AD4E',

                'sigedra-bg': grayscale['0'],
                'sigedra-medium-bg': grayscale['50'],
                'sigedra-light-bg': grayscale['25'],
                'sigedra-light-colored-bg': '#f5fef3',
                'sigedra-components-bg': grayscale['50'],

                'sigedra-input': '#ff0000',
                'sigedra-border': '#ababab',

                'grayscale': grayscale,

                // Colores de texto REFERENCIANDO grayscale
                'sigedra-text-dark': grayscale['900'],
                'sigedra-text-medium': grayscale['700'],
                'sigedra-text-light': grayscale['500'],
            },
            fontSize: {
                'sm': '0.875rem',
                'base': '1rem',
                'lg': '1.125rem',
                'xl': '1.25rem',
                '2xl': '1.5rem',
                '3xl': '1.875rem',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('flowbite/plugin')
    ],
};
