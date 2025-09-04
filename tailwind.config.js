/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

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
                // --- CAMBIO DE ACCESIBILIDAD ---
                // Se ha aumentado el contraste de los colores de texto para mejorar la legibilidad.
                'sigedra-primary': '#2563EB',     // Azul principal, se mantiene igual.
                'sigedra-bg': '#F9FAFB',          // Fondo general, se mantiene igual.
                'sigedra-card': '#FFFFFF',        // Fondo de contenedores, se mantiene igual.
                'sigedra-input': '#F3F4F6',       // Fondo de inputs, se mantiene igual.
                'sigedra-border': '#E5E7EB',      // Color de bordes, se mantiene igual.
                'sigedra-text-dark': '#111827',   // Texto principal (antes #1F2937), ahora más oscuro.
                'sigedra-text-medium': '#374151', // Texto secundario (antes #6B7280), ahora con más contraste.
                'sigedra-text-light': '#6B7280',  // Texto para placeholders (antes #9CA3AF), ahora más visible.
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
