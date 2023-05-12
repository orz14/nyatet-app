<div class="w-full max-w-sm mx-auto mb-5">
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-white bg-teal-700 border-none hover:bg-teal-600 btn btn-block']) }}>
        {{ $slot }}
    </button>
</div>
