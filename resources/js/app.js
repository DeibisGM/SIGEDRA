import './bootstrap';
import './sidebar.js';
import 'flowbite';
import { initDatepickerFix, addDatepickerStyles } from './datepicker-fix.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', function () {
    // Aplicar estilos CSS inmediatamente
    addDatepickerStyles();

    // Inicializar el fix del datepicker
    initDatepickerFix();

    // El resto de tu lógica
    if (document.getElementById('attendanceChart')) {
        import('./report-charts.js')
            .then(module => {
                const initCharts = module.default;
                initCharts();
            })
            .catch(err => console.error('Chart loading failed:', err));
    }
});

// Reaplica el fix en navegación de Livewire
document.addEventListener('livewire:navigated', () => {
    addDatepickerStyles();
    initDatepickerFix();
});