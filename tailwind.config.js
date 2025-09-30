/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';

// Definir grayscale primero
const grayscale = {
    '0': '#FFFFFF',      // Blanco puro
    '25': '#FAFAFA',
    '50': '#F2FAF5',      // Tono original '0'
    '100': '#E1F3EE',     // Tono original '50'
    '150': '#D4E6E0',
    '200': '#BFD3CD',     // Tono original '100'
    '300': '#9DB4AD',     // Tono original '200'
    '400': '#7D958E',     // Tono original '300'
    '500': '#5E7871',     // Tono original '400'
    '600': '#405C54',     // Tono original '500'
    '700': '#234139',     // Tono original '600'
    '800': '#052821',     // Tono original '700'
    '900': '#00110A',     // Tono original '800'
    '950': '#000100',     // Tono original '900'
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
