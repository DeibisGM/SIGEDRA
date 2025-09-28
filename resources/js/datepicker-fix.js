/**
 * Solución simple: Forzar que el datepicker use position: absolute en lugar de fixed
 * y que esté dentro del contenedor que hace scroll
 */
export function initDatepickerFix() {
    // Interceptamos la creación de datepickers
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === 1 && node.classList.contains('datepicker-dropdown')) {
                    // SOLUCIÓN SIMPLE: Cambiar de fixed a absolute
                    node.style.position = 'absolute';
                    node.style.zIndex = '1000';

                    // Mover el datepicker dentro del contenedor principal
                    const mainContent = document.getElementById('main-content-area');
                    if (mainContent && node.parentNode === document.body) {
                        mainContent.appendChild(node);

                        // Recalcular posición relativa al nuevo padre
                        const input = document.querySelector('input[datepicker]:focus') ||
                            document.querySelector('input[datepicker][aria-expanded="true"]');

                        if (input) {
                            // Usar la posición del input dentro de su contenedor padre relativo
                            const inputRect = input.getBoundingClientRect();
                            const containerRect = mainContent.getBoundingClientRect();

                            // Calcular posición exacta relativa al contenedor con scroll
                            const scrollTop = mainContent.scrollTop;
                            const scrollLeft = mainContent.scrollLeft;

                            // Posición del input relativa al contenedor + el scroll actual
                            const top = (inputRect.bottom - containerRect.top) + scrollTop + 5;
                            const left = (inputRect.left - containerRect.left) + scrollLeft - 16;

                            node.style.top = `${top}px`;
                            node.style.left = `${left}px`;

                            // También asegurar que el ancho mínimo sea el del input
                            node.style.minWidth = `${input.offsetWidth}px`;
                        }
                    }
                }
            });
        });
    });

    observer.observe(document.body, { childList: true });
}

// Alternativa aún más simple: CSS override
export function addDatepickerStyles() {
    const style = document.createElement('style');
    style.textContent = `
        .datepicker-dropdown {
            position: absolute !important;
            z-index: 1000 !important;
        }

        /* Asegurar que el contenedor principal tenga position relative */
        #main-content-area {
            position: relative !important;
        }
    `;
    document.head.appendChild(style);
}