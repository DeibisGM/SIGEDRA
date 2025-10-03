import './bootstrap';
import './sidebar.js';

import Alpine from 'alpinejs';
import { initDatepickers } from './custom-datepicker.js';

window.Alpine = Alpine;
window.initDatepickers = initDatepickers;

document.addEventListener('DOMContentLoaded', function () {
    initDatepickers();

    if (document.getElementById('attendanceChart')) {
        import('./report-charts.js')
            .then(module => {
                const initCharts = module.default;
                initCharts();
            })
            .catch(err => console.error('Chart loading failed:', err));
    }
});

document.addEventListener('livewire:navigated', () => {
    initDatepickers();
});
