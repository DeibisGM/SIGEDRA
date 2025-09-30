import Datepicker from 'vanillajs-datepicker/Datepicker';
import es from 'vanillajs-datepicker/locales/es';
import 'vanillajs-datepicker/css/datepicker.min.css';

export function initDatepickers() {

    Object.assign(Datepicker.locales, es);

    const datepickerElements = document.querySelectorAll('.custom-datepicker');

    datepickerElements.forEach(element => {

        if (element.datepicker) {
            return;
        }

        const datepicker = new Datepicker(element, {

            buttons: true,
            autohide: true,
            format: 'yyyy-mm-dd',
            language: 'es',
            todayBtn: true,
            clearBtn: true,

            container: '#main-content-area',
        });

        element.addEventListener('changeDate', function (e) {

            element.dispatchEvent(new Event('input'));
        });
    });
}
