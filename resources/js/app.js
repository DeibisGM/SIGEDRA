import './bootstrap';
import './sidebar.js';
import 'preline';

import flatpickr from "flatpickr";

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// We don't start Alpine manually. Livewire will handle it.
// Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    flatpickr(".flatpickr", {});

    if (document.getElementById('attendanceChart')) {
        import('./report-charts.js')
            .then(module => {
                const initCharts = module.default;
                initCharts();
            })
            .catch(err => console.error('Chart loading failed:', err));
    }
});