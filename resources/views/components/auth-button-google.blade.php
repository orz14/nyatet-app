@props(['label'])

<div class="w-full max-w-sm mx-auto mb-5">
    <a {!! $attributes->merge(['href' => route('login.provider', 'google'), 'class' => 'text-white bg-red-700 border-none hover:bg-red-600 btn btn-block', 'role' => 'button', 'aria-label' => $label ?? 'Tombol']) !!}>
        <svg width="20" height="20" fill="currentColor" class="mr-2 max-[241px]:mr-0" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
            <path d="M896 786h725q12 67 12 128 0 217-91 387.5t-259.5 266.5-386.5 96q-157 0-299-60.5t-245-163.5-163.5-245-60.5-299 60.5-299 163.5-245 245-163.5 299-60.5q300 0 515 201l-209 201q-123-119-306-119-129 0-238.5 65t-173.5 176.5-64 243.5 64 243.5 173.5 176.5 238.5 65q87 0 160-24t120-60 82-82 51.5-87 22.5-78h-436v-264z">
            </path>
        </svg>
        
        <span class="max-[241px]:hidden">
            {{ $label ?? 'Tombol' }}
        </span>
    </a>
</div>
