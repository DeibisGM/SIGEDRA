import '../../node_modules/@phosphor-icons/web/src/regular/style.css';
import '../../node_modules/@phosphor-icons/web/src/fill/style.css';

import './bootstrap';
import './sidebar.js';
import 'preline';

import flatpickr from "flatpickr";

import Alpine from 'alpinejs';
import TomSelect from 'tom-select';

window.Alpine = Alpine;

// Inicializa TomSelect de forma reutilizable
window.tomSelect = function (config) {
    return {
        ...config,
        instance: null,
        init() {
            this.instance = new TomSelect(this.$el, config.settings);
            this.$watch(config.wireModel, (value) => {
                if (value !== this.instance.getValue()) {
                    this.instance.setValue(value, true);
                }
            });
        }
    };
};

document.addEventListener('alpine:init', () => {
    Alpine.data('tomSelect', tomSelect);
});

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