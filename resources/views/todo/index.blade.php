@extends('layouts.app')
@section('hero')
<div class="text-2xl font-normal sm:text-3xl md:text-4xl lg:font-light lg:text-6xl">
    {{ __('Apa Rencanamu Hari Ini ?') }}
</div>
<div class="text-xl font-medium my-7">
    <div class="form-control">
        <div class="justify-center input-group">
            <input type="text" placeholder="Tulis Disini …" class="w-full truncate transition-all duration-300 ease-in-out text-slate-700 bg-teal-400/50 input placeholder:text-slate-500 focus:outline-none focus:ring focus:ring-teal-600/20 focus:border-teal-500" />
            <button class="text-white bg-teal-700 border-teal-700 btn btn-square hover:bg-teal-900 hover:border-teal-900">
                <i class="w-5" data-feather="plus"></i>
            </button>
        </div>
    </div>
</div>
<a href="#" class="text-white bg-teal-500 border-none btn hover:bg-teal-600">{{ __('History List') }}</a>
@endsection

@section('content')
<x-blank>{{ __('Belum ada rencana.') }}</x-blank>

{{-- <div class="mb-4 transition-all duration-300 ease-in-out bg-white border-4 rounded-none border-teal-400/50 card hover:border-teal-400">
    <div class="py-3 card-body">
        <div class="flex items-center justify-between">
            <div>Todo List 1</div>
            <div>
                <button class="text-red-600 bg-red-100 border-none btn hover:bg-red-200"><i class="w-5" data-feather="trash-2"></i></button>
                <button class="text-green-600 bg-green-100 border-none btn hover:bg-green-200"><i class="w-5" data-feather="check"></i></button>
            </div>
        </div>
    </div>
</div> --}}
@endsection
