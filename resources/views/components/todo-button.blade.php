<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-2 py-1.5 rounded-lg inline-block transition-all duration-300 ease-in-out my-1']) }}>
    {{ $slot }}
</button>
