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
                // Paleta de colores ajustada para mayor contraste y armonía
                'sigedra-primary': '#193F4C',      // Un azul más vibrante y accesible
                'sigedra-secondary': '#7AA352',     // Se mantiene, tiene excelente contraste
                'sigedra-accent': '#34A853',       // Un verde más estándar y visible
                'sigedra-error': '#D9534F',        // Rojo con buen contraste
                'sigedra-warning': '#F0AD4E',      // Amarillo/Naranja accesible
                'sigedra-bg': '#F9FAFB',           // Fondo general
                'sigedra-card': '#F2F6E3',         // Fondo para tarjetas y contenedores
                'sigedra-light-colored-bg': '#F7FAF4',
                'sigedra-input': '#F3F4F6',        // Fondo para inputs
                'sigedra-border': '#D1D5DB',       // Borde estándar, ligeramente más oscuro
                'sigedra-border-strong': '#9CA3AF',// Borde para énfasis (ej. cabecera de tabla)

                // Colores de texto con alto contraste
                'sigedra-text-dark': '#1F2937',      // Texto principal, casi negro
                'sigedra-text-medium': '#4B5563',    // Texto secundario, más oscuro que antes
                'sigedra-text-light': '#9CA3AF',     // Para placeholders o texto deshabilitado
            },
            // Escala de tipografía estandarizada para legibilidad
            fontSize: {
                'sm': '0.875rem', // 14px
                'base': '1rem',   // 16px
                'lg': '1.125rem', // 18px
                'xl': '1.25rem',  // 20px
                '2xl': '1.4375rem', // 23px (títulos de sección)
                '3xl': '1.8125rem', // 29px (títulos de página)
                '4xl': '2.125rem',  // 34px
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
