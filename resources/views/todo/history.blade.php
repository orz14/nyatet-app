@extends('layouts.app')
@section('hero')
<h1 class="text-2xl font-normal sm:text-3xl md:text-4xl lg:font-light lg:text-6xl">
    {{ __('History List') }}
</h1>
<a href="{{ route('todo.index') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7">{{ __('Tulis List') }}</a>
@endsection

@section('content')
@if ($datas->count())
@foreach ($datas as $data)
<div class="mb-4 transition-all duration-300 ease-in-out bg-white border-4 rounded-none border-teal-400/50 card hover:border-teal-400 @if($data->is_done) todo-hijau @else todo-merah @endif">
    <div class="p-4 leading-none card-body">
        <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('l, d F Y') }}</div>
        <div>{{ $data->decrypt($data->content) }}</div>
    </div>
</div>
@endforeach
<div class="mb-4">
    {{ $datas->links() }}
</div>
@else
<x-blank>{{ __('Tidak ada history.') }}</x-blank>
@endif
@endsection
