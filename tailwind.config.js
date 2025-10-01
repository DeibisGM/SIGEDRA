/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';

const grayscale = {
    '0': '#FFFFFF',
    '30': '#fcfcfc',
    '60': '#f7f7f7',
    '90': '#E5E5E5',
    '120': '#DCDCDC',
    '150': '#D3D3D3',
    '180': '#CACACA',
    '210': '#C1C1C1',
    '240': '#B9B9B9',
    '270': '#B0B0B0',
    '300': '#A7A7A7',
    '330': '#9E9E9E',
    '360': '#959595',
    '390': '#8D8D8D',
    '420': '#848484',
    '450': '#7B7B7B',
    '480': '#727272',
    '510': '#6A6A6A',
    '540': '#616161',
    '570': '#585858',
    '600': '#4F4F4F',
    '630': '#464646',
    '660': '#3E3E3E',
    '690': '#353535',
    '720': '#2C2C2C',
    '750': '#232323',
    '780': '#1A1A1A',
    '810': '#121212',
    '840': '#090909',
    '870': '#000000'
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
                'sigedra-primary': '#0d3b31',
                'sigedra-primary-dark': '#02140f',
                'sigedra-secondary': '#7CBA60',
                'sigedra-accent': '#00C765',
                'sigedra-error': '#FB584B',
                'sigedra-warning': '#EE9849',

                'sigedra-bg': grayscale['0'],
                'sigedra-medium-bg': grayscale['60'],
                'sigedra-light-bg': grayscale['30'],
                'sigedra-light-colored-bg': '#f5fef3',
                'sigedra-components-bg': grayscale['60'],
                'sigedra-components-hover-bg': grayscale['90'],

                'sigedra-input': '#ff0000',
                'sigedra-border': grayscale['120'],

                'grayscale': grayscale,

                // Colores de texto REFERENCIANDO grayscale
                'sigedra-text-dark': grayscale['810'],
                'sigedra-text-medium': grayscale['780'],
                'sigedra-text-light': grayscale['750'],
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
