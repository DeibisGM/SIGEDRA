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

        // Si el datepicker está dentro de un modal, su contenedor debe ser el body
        // para que se muestre por encima del modal.
        const inModal = element.closest('.fixed.z-50');

        const datepicker = new Datepicker(element, {

            buttons: true,
            autohide: true,
            format: 'yyyy-mm-dd',
            language: 'es',
            todayBtn: true,
            clearBtn: true,
            todayBtnMode: 1, // 1 = select today's date
            offset: 10, // 10px padding

            container: inModal ? null : '#main-content-area',
        });

        element.addEventListener('changeDate', function (e) {

            element.dispatchEvent(new Event('input'));
        });
    });
}
