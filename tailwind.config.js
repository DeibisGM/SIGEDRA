/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/preline/dist/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'sigedra-primary': '#88BBC5',
                'sigedra-secundary': '#011A39',
                'sigedra-accent': '#49C388',
                'sigedra-error': '#DB5B4D',
                'sigedra-warning': '#F8D56A',
                'sigedra-bg': '#F9FAFB',
                'sigedra-card': '#FFFFFF',
                'sigedra-input': '#F3F4F6',
                'sigedra-border': '#E5E7EB',
                'sigedra-text-dark': '#111827',
                'sigedra-text-medium': '#374151',
                'sigedra-text-light': '#6B7280',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
