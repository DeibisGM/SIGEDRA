<div x-data="{ attendance: '' }" class="inline-flex rounded-lg shadow-sm w-80">
    <button
        type="button"
        @click="attendance = 'presente'; $dispatch('attendance-selected', { value: attendance })"
        :class="{
            'bg-attendance-present text-white': attendance === 'presente',
            'bg-white text-sigedra-text-medium hover:bg-gray-50': attendance !== 'presente',
            'w-32': attendance === 'presente',
            'w-16': attendance !== 'presente' && attendance !== '',
            'w-20': attendance === ''
        }"
        class="flex items-center justify-center gap-2 px-3 py-2 text-base transition-all duration-300 rounded-l-lg border border-gray-200"
    >
        <i class="ph ph-check-circle text-lg"></i>
        <span :class="{ 'sr-only': attendance !== 'presente' }">Presente</span>
    </button>
    <button
        type="button"
        @click="attendance = 'tardia'; $dispatch('attendance-selected', { value: attendance })"
        :class="{
            'bg-attendance-late text-white': attendance === 'tardia',
            'bg-white text-sigedra-text-medium hover:bg-gray-50': attendance !== 'tardia',
            'w-32': attendance === 'tardia',
            'w-16': attendance !== 'tardia' && attendance !== '',
            'w-20': attendance === ''
        }"
        class="flex items-center justify-center gap-2 px-3 py-2 text-base transition-all duration-300 border-y border-l border-gray-200"
    >
        <i class="ph ph-clock text-lg"></i>
        <span :class="{ 'sr-only': attendance !== 'tardia' }">Tardía</span>
    </button>
    <button
        type="button"
        @click="attendance = 'ausente'; $dispatch('attendance-selected', { value: attendance })"
        :class="{
            'bg-attendance-absent text-white': attendance === 'ausente',
            'bg-white text-sigedra-text-medium hover:bg-gray-50': attendance !== 'ausente',
            'w-32': attendance === 'ausente',
            'w-16': attendance !== 'ausente' && attendance !== '',
            'w-20': attendance === ''
        }"
        class="flex items-center justify-center gap-2 px-3 py-2 text-base transition-all duration-300 border-y border-l border-gray-200"
    >
        <i class="ph ph-x-circle text-lg"></i>
        <span :class="{ 'sr-only': attendance !== 'ausente' }">Ausente</span>
    </button>
    <button
        type="button"
        @click="attendance = 'justificado'; $dispatch('attendance-selected', { value: attendance })"
        :class="{
            'bg-attendance-justified text-white': attendance === 'justificado',
            'bg-white text-sigedra-text-medium hover:bg-gray-50': attendance !== 'justificado',
            'w-32': attendance === 'justificado',
            'w-16': attendance !== 'justificado' && attendance !== '',
            'w-20': attendance === ''
        }"
        class="flex items-center justify-center gap-2 px-3 py-2 text-base transition-all duration-300 rounded-r-lg border border-gray-200"
    >
        <i class="ph ph-warning-circle text-lg"></i>
        <span :class="{ 'sr-only': attendance !== 'justificado' }">Justificado</span>
    </button>
</div>
