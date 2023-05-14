@extends('layouts.app')
@section('content')
<header class="bg-teal-400/30">
    <nav class="nav">
        <div class="container">
            <div class="brand">
                <img src="{{ asset('img/logo/logo-nyatet-app.png') }}" alt="Nyatet App" class="h-8 pointer-events-none select-none w-auto">
            </div>
            <div class="menutet">
                <a href="{{ route('todo.index') }}" class="menu-item menu-item-active">{{ __('Todo List') }}</a>
                <a href="#" class="menu-item">{{ __('Note') }}</a>
            </div>
            <div class="ctas">
                <div class="dropdown dropdown-bottom dropdown-end">
                    <label tabindex="0" class="btn m-0 p-3 rounded-full bg-teal-100 border-none hover:bg-teal-100/50 normal-case text-base text-black font-bold">
                        <i data-feather="user"></i>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-white rounded-box w-52">
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
    <section class="container pt-32 pb-48">
        <div class="text-center">
            <div class="text-6xl font-light">
                {{ __('Todo List') }}
            </div>
            <div class="text-xl font-medium my-5">
                {{ __('Daftar tugas-tugas atau kegiatan yang harus kamu lakukan pada hari ini.') }}
            </div>
            <a href="#" class="btn bg-teal-500 text-white border-none hover:bg-teal-600">{{ __('History List') }}</a>
        </div>
    </section>
</header>

<main class="container -mt-16">
    <div class="card bg-white mb-4 rounded-none border-4 border-teal-100 hover:border-teal-400 transition-all duration-300 ease-in-out">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>Todo List 1</div>
                <div>
                    <button class="btn bg-red-500/70 hover:bg-red-500 border-none text-white"><i data-feather="trash-2"></i></button>
                    <button class="btn bg-green-500/70 hover:bg-green-500 border-none text-white"><i data-feather="check"></i></button>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="container pb-4">
    <div class="bg-teal-400/30 text-center p-5 tracking-widest rounded-lg">
        <span>&copy; {{ date('Y') }} <a href="{{ config('app.url') }}" class="font-bold hover:underline">{{ __('Nyatet App') }}</a> &#183; {{ __('Created by') }} <a href="https://orzproject.my.id" class="font-bold hover:underline" target="_blank">{{ __('ORZCODE') }}</a></span>
    </div>
</footer>
@endsection
