<nav class="md:hidden">
    <div class="!text-white !bg-teal-500 btm-nav">
        <a href="{{ route('todo.index') }}" class="{{ Request::is('todo*') ? 'active' : '' }}" wire:navigate.hover>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M22 8c0-.55-.45-1-1-1h-7c-.55 0-1 .45-1 1s.45 1 1 1h7c.55 0 1-.45 1-1zm-9 8c0 .55.45 1 1 1h7c.55 0 1-.45 1-1s-.45-1-1-1h-7c-.55 0-1 .45-1 1zM10.47 4.63c.39.39.39 1.02 0 1.41l-4.23 4.25c-.39.39-1.02.39-1.42 0L2.7 8.16a.996.996 0 1 1 1.41-1.41l1.42 1.42l3.54-3.54c.38-.38 1.02-.38 1.4 0zm.01 8.01c.39.39.39 1.02 0 1.41L6.25 18.3c-.39.39-1.02.39-1.42 0L2.7 16.16a.996.996 0 1 1 1.41-1.41l1.42 1.42l3.54-3.54c.38-.38 1.02-.38 1.41.01z" />
            </svg>
            <span class="btm-nav-label">{{ __('Todo List') }}</span>
        </a>
        <a href="{{ route('note.index') }}" class="{{ Request::is('note*') ? 'active' : '' }}" wire:navigate.hover>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 256 256">
                <path fill="currentColor"
                    d="M168 128a8 8 0 0 1-8 8H96a8 8 0 0 1 0-16h64a8 8 0 0 1 8 8Zm-8 24H96a8 8 0 0 0 0 16h64a8 8 0 0 0 0-16Zm56-104v152a32 32 0 0 1-32 32H72a32 32 0 0 1-32-32V48a16 16 0 0 1 16-16h16v-8a8 8 0 0 1 16 0v8h32v-8a8 8 0 0 1 16 0v8h32v-8a8 8 0 0 1 16 0v8h16a16 16 0 0 1 16 16Zm-16 0h-16v8a8 8 0 0 1-16 0v-8h-32v8a8 8 0 0 1-16 0v-8H88v8a8 8 0 0 1-16 0v-8H56v152a16 16 0 0 0 16 16h112a16 16 0 0 0 16-16Z" />
            </svg>
            <span class="btm-nav-label">{{ __('Note') }}</span>
        </a>
        <a href="{{ route('mobile-app.index') }}" class="{{ Request::is('mobile-app*') ? 'active' : '' }}"
            wire:navigate.hover>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
            </svg>
            <span class="btm-nav-label">{{ __('Mobile App') }}</span>
        </a>
    </div>
</nav>
