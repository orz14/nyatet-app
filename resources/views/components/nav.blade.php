<nav class="nav">
    <div class="container">
        <div class="brand">
            <a href="{{ config('app.url') }}">
                <x-logo class="w-auto h-7 pointer-events-none select-none sm:h-8" />
            </a>
        </div>
        
        <div class="menutet">
            <a href="{{ route('todo.index') }}" class="menu-item {{ Request::is('todo*') ? 'menu-item-active' : '' }}">{{ __('Todo List') }}</a>
            <a href="{{ route('note.index') }}" class="menu-item {{ Request::is('note*') ? 'menu-item-active' : '' }}">{{ __('Note') }}</a>
        </div>
        
        <div class="ctas">
            <div class="dropdown dropdown-bottom dropdown-end">
                <label tabindex="0" class="w-12 h-12 p-1 m-0 overflow-hidden text-base font-bold text-black normal-case bg-teal-100 border-none rounded-full orz-pointer btn hover:bg-teal-100/50">
                    @if (auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="object-cover rounded-full">
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#0f766e" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    @endif
                </label>
                <ul tabindex="0" class="p-2 bg-white shadow dropdown-content menu rounded-box w-52">
                    @can('admin')
                    <li class="orz-pointer">
                        <a href="{{ config('app.url') }}/log" class="hover:bg-teal-100/60 active:text-black active:bg-teal-100/60" target="_blank">{{ __('Log') }}</a>
                    </li>
                    @endcan
                    <li class="orz-pointer">
                        <a href="{{ route('profile.edit') }}" class="hover:bg-teal-100/60 active:text-black active:bg-teal-100/60">{{ __('Profil') }}</a>
                    </li>
                    <li class="orz-pointer">
                        <button x-data x-on:click="$store.modal.logout = true" type="button" id="button-logout-open" class="hover:bg-red-100/80 active:text-black active:bg-red-100/80">{{ __('Logout') }}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
