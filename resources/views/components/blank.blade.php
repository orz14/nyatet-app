<div {!! $attributes->merge(['class' => 'mb-4 bg-white rounded-lg shadow-md card']) !!}>
    <div class="card-body">
        <div class="text-center">
            <span>{{ $slot }}</span>
        </div>
    </div>
</div>
