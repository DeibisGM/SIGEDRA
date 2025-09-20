import '../../node_modules/@phosphor-icons/web/src/regular/style.css';
import '../../node_modules/@phosphor-icons/web/src/fill/style.css';

import './bootstrap';
import './sidebar.js';
import 'preline';

import flatpickr from "flatpickr";

import Alpine from 'alpinejs';
window.Alpine = Alpine;

Alpine.start();

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