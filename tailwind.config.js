/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/preline/dist/*.js', // Añade esta línea
    ],
    theme: {
        extend: {
            colors: {
                primary: '#1D4ED8',     // azul principal
                secondary: '#F59E0B',   // naranja
                success: '#10B981',     // verde
                danger: '#EF4444',      // rojo
                neutralDark: '#1F2937', // gris oscuro
            },
            spacing: {
                '9.5': '2.375rem', // para tu input de PIN
            },
            borderRadius: {
                'md': '0.375rem',
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'), // Asegúrate de que esta línea esté
    ],
}
