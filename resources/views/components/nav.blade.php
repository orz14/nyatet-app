<nav class="nav">
    <div class="container">
        <div class="brand">
            <x-icon class="w-auto h-8 pointer-events-none select-none sm:hidden" />
            <x-logo class="hidden w-auto h-8 pointer-events-none select-none sm:block" />
        </div>

        <div class="menutet">
            <a href="{{ route('todo.index') }}" class="menu-item {{ Request::is('todo*') ? 'menu-item-active' : '' }}">{{ __('Todo List') }}</a>
            <a href="#" class="menu-item {{ Request::is('note*') ? 'menu-item-active' : '' }}">{{ __('Note') }}</a>
        </div>
        
        <div class="ctas">
            <div class="dropdown dropdown-bottom dropdown-end">
                <label tabindex="0" class="p-3 m-0 text-base font-bold text-black normal-case bg-teal-100 border-none rounded-full btn hover:bg-teal-100/50">
                    <i data-feather="user"></i>
                </label>
                <ul tabindex="0" class="p-2 bg-white shadow dropdown-content menu rounded-box w-52">
                    <li><a href="{{ route('profile.edit') }}" class="hover:bg-teal-100/60 active:text-black active:bg-teal-100/60">{{ __('Profil') }}</a></li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li>
                            <button type="submit" class="hover:bg-red-100/80 active:text-black active:bg-red-100/80">{{ __('Logout') }}</button>
                        </li>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>
