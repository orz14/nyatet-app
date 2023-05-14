<div {{ $attributes->merge(['class' => 'mb-4 bg-white border-4 rounded-none border-teal-400/50 card']) }}>
    <div class="card-body">
        <div class="text-center">
            <span>{{ $slot }}</span>
        </div>
    </div>
</div>
