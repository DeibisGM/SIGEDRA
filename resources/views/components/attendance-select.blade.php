{{-- resources/views/components/attendance-select.blade.php --}}

<div class="relative">
    <select hidden data-hs-select='{
        "placeholder": "Seleccionar estado",
        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 ps-3 pe-10 inline-flex items-center gap-x-2 text-base font-medium rounded-lg border border-sigedra-border bg-white text-sigedra-text-dark shadow-2xs hover:bg-sigedra-light-colored-bg focus:outline-hidden focus:bg-sigedra-light-colored-bg w-full cursor-pointer text-start",
        "dropdownClasses": "mt-2 z-50 w-full bg-white shadow-md rounded-lg",
        "optionClasses": "py-2 px-3 rounded-lg text-base text-sigedra-text-dark hover:bg-sigedra-light-colored-bg focus:outline-hidden focus:bg-sigedra-light-colored-bg cursor-pointer",
        "optionTemplate": "<div class=\"flex justify-between items-center w-full gap-x-3.5\"><span data-title></span><span class=\"hidden hs-selected:block\"><i class=\"ph ph-check text-base text-sigedra-primary\"></i></span></div>"
    }'>
        <option value="">Seleccionar estado</option>
        <option value="presente">Presente</option>
        <option value="tardia">Tardía</option>
        <option value="ausente">Ausente</option>
        <option value="justificado">Justificado</option>
    </select>
    <div class="absolute top-1/2 end-2.5 -translate-y-1/2">
        <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
    </div>
</div>

