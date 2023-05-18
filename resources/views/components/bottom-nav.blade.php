<nav class="md:hidden">
    <div class="!text-white !bg-teal-500 btm-nav">
        <a href="{{ route('todo.index') }}" class="{{ Request::is('todo*') ? 'active' : '' }}">
            <i class="w-5 h-5" data-feather="check-square"></i>
            <span class="btm-nav-label">Todo List</span>
        </a>
        <a href="{{ route('note.index') }}" class="{{ Request::is('note*') ? 'active' : '' }}">
            <i class="w-5 h-5" data-feather="file-text"></i>
            <span class="btm-nav-label">Note</span>
        </a>
    </div>
</nav>
