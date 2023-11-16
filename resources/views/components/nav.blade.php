<nav class="nav">
    <div class="container">
        <div class="brand">
            <a href="{{ config('app.url') }}" wire:navigate.hover>
                <x-logo class="w-auto pointer-events-none select-none h-7 sm:h-8" />
            </a>
        </div>
        
        <div class="menutet">
            <a href="{{ route('todo.index') }}" class="menu-item {{ Request::is('todo*') ? 'menu-item-active' : '' }}" wire:navigate.hover>{{ __('Todo List') }}</a>
            <a href="{{ route('note.index') }}" class="menu-item {{ Request::is('note*') ? 'menu-item-active' : '' }}" wire:navigate.hover>{{ __('Note') }}</a>
        </div>
        
        <div class="ctas">
            <div class="dropdown dropdown-bottom dropdown-end">
                <label tabindex="0" class="w-12 h-12 p-1 m-0 overflow-hidden text-base font-bold text-black normal-case bg-teal-100 border-none rounded-full btn hover:bg-teal-100/50">
                    @if (auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="object-cover rounded-full">
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#0f766e" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    @endif
                </label>
                <ul tabindex="0" class="p-2 bg-white shadow dropdown-content menu rounded-box w-52">
                    @can('admin')
                    <li>
                        <a href="{{ config('app.url') }}/log" class="hover:bg-teal-100/60 active:text-black active:bg-teal-100/60" target="_blank">
                            <span class="flex items-center gap-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                {{ __('Log') }}
                            </span>
                        </a>
                    </li>
                    @endcan
                    <li>
                        <a href="https://github.com/orz14/nyatet-app" class="hover:bg-teal-100/60 active:text-black active:bg-teal-100/60" target="_blank">
                            <span class="flex items-center gap-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 md:w-5 md:h-5">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                {{ __('Source Code') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="hover:bg-teal-100/60 active:text-black active:bg-teal-100/60" wire:navigate.hover>
                            <span class="flex items-center gap-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                {{ __('Profil') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <button x-data x-on:click="$store.modal.logout = true" type="button" id="button-logout-open" class="hover:bg-red-100/80 active:text-black active:bg-red-100/80">
                            <span class="flex items-center gap-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                {{ __('Logout') }}
                            </span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
