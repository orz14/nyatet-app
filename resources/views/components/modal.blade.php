<div x-data x-show="{{ $modal }}" x-transition:enter="ease-out duration-300" x-transition:leave="ease-in duration-200" id="{{ $dialog }}" class="relative z-10 invisible" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div x-show="{{ $modal }}" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-teal-900/80"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div x-show="{{ $modal }}" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full overflow-hidden text-left transition-all transform bg-white shadow-xl rounded-2xl sm:my-8 sm:max-w-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
