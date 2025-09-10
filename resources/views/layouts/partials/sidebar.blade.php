<div id="application-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-sigedra-border pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
    <div class="px-6">
        <a class="flex-none text-xl font-semibold text-sigedra-secondary" href="#" aria-label="Brand">SIGEDRA</a>
    </div>

    <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
        <ul class="space-y-1.5">
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-slate-700 rounded-lg hover:bg-gray-100" href="#">
                    Inicio
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100" href="{{ route('attendance.index') }}">
                    Asistencia
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100" href="#">
                    Reportes
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100" href="#">
                    Estudiantes
                </a>
            </li>
        </ul>
    </nav>
</div>
