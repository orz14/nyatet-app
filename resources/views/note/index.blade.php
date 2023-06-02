@extends('layouts.app')
@section('hero')
<x-hero-title>{{ __('Catatan') }}</x-hero-title>

{{-- Session Status --}}
<x-session-status />

<a href="{{ route('note.create') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7">{{ __('Tambahkan Catatan') }}</a>
@endsection

@section('content')
@if ($datas->count())
@foreach ($datas as $data)
<div class="mb-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-md border-l-8 border-teal-400/50 card hover:border-teal-400 hover:shadow-lg @isset($data->password) note-locked @endisset">
    <div class="px-3 py-2 leading-none card-body">
        <a @isset($data->password) x-data x-on:click="modal_unlock_open('{{ route('note.unlock', $data->slug) }}')" @else href="{{ route('note.edit', $data->slug) }}" @endisset class="flex items-center justify-between">
            <div class="pr-2 cursor-pointer">
                <div class="font-bold">{{ isset($data->title) ? $data->decrypt($data->title) : 'Tanpa Judul' }}</div>
                <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('l, d F Y H:i') }}</div>
            </div>
            <div class="text-right">
                @if (!isset($data->password))
                <x-todo-button x-data x-on:click="modal_delete_open('{{ route('note.destroy', $data->slug) }}')" class="text-red-600 bg-red-100 hover:bg-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-6 md:w-6" viewBox="0 0 24 24"><g fill="currentColor"><path fill-rule="evenodd" d="M10.31 2.25h3.38c.217 0 .406 0 .584.028a2.25 2.25 0 0 1 1.64 1.183c.084.16.143.339.212.544l.111.335a1.25 1.25 0 0 0 1.263.91h3a.75.75 0 0 1 0 1.5h-17a.75.75 0 0 1 0-1.5h3.09a1.25 1.25 0 0 0 1.173-.91l.112-.335c.068-.205.127-.384.21-.544a2.25 2.25 0 0 1 1.641-1.183c.178-.028.367-.028.583-.028Zm-1.302 3a2.757 2.757 0 0 0 .175-.428l.1-.3c.091-.273.112-.328.133-.368a.75.75 0 0 1 .547-.395a3.2 3.2 0 0 1 .392-.009h3.29c.288 0 .348.002.392.01a.75.75 0 0 1 .547.394c.021.04.042.095.133.369l.1.3l.039.112c.039.11.085.214.136.315H9.008Z" clip-rule="evenodd"/><path d="M5.915 8.45a.75.75 0 1 0-1.497.1l.464 6.952c.085 1.282.154 2.318.316 3.132c.169.845.455 1.551 1.047 2.104c.591.554 1.315.793 2.17.904c.822.108 1.86.108 3.146.108h.879c1.285 0 2.324 0 3.146-.108c.854-.111 1.578-.35 2.17-.904c.591-.553.877-1.26 1.046-2.104c.162-.813.23-1.85.316-3.132l.464-6.952a.75.75 0 0 0-1.497-.1l-.46 6.9c-.09 1.347-.154 2.285-.294 2.99c-.137.685-.327 1.047-.6 1.303c-.274.256-.648.422-1.34.512c-.713.093-1.653.095-3.004.095h-.774c-1.35 0-2.29-.002-3.004-.095c-.692-.09-1.066-.256-1.34-.512c-.273-.256-.463-.618-.6-1.302c-.14-.706-.204-1.644-.294-2.992l-.46-6.899Z"/><path d="M9.425 10.254a.75.75 0 0 1 .821.671l.5 5a.75.75 0 0 1-1.492.15l-.5-5a.75.75 0 0 1 .671-.821Zm5.15 0a.75.75 0 0 1 .671.82l-.5 5a.75.75 0 0 1-1.492-.149l.5-5a.75.75 0 0 1 .82-.671Z"/></g></svg>
                </x-todo-button>
                @endif
                
                @isset($data->password)
                <x-todo-button x-data x-on:click="modal_unlock_open('{{ route('note.unlock', $data->slug) }}')" class="text-amber-800 bg-amber-300 hover:bg-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-6 md:w-6" viewBox="0 0 24 24"><g fill="currentColor"><path d="M9 16a1 1 0 1 1-2 0a1 1 0 0 1 2 0Zm4 0a1 1 0 1 1-2 0a1 1 0 0 1 2 0Zm3 1a1 1 0 1 0 0-2a1 1 0 0 0 0 2Z"/><path fill-rule="evenodd" d="M5.25 8v1.303c-.227.016-.44.036-.642.064c-.9.12-1.658.38-2.26.981c-.602.602-.86 1.36-.981 2.26c-.117.867-.117 1.97-.117 3.337v.11c0 1.367 0 2.47.117 3.337c.12.9.38 1.658.981 2.26c.602.602 1.36.86 2.26.982c.867.116 1.97.116 3.337.116h8.11c1.367 0 2.47 0 3.337-.116c.9-.122 1.658-.38 2.26-.982c.602-.602.86-1.36.982-2.26c.116-.867.116-1.97.116-3.337v-.11c0-1.367 0-2.47-.116-3.337c-.122-.9-.38-1.658-.982-2.26c-.602-.602-1.36-.86-2.26-.981a10.215 10.215 0 0 0-.642-.064V8a6.75 6.75 0 0 0-13.5 0ZM12 2.75A5.25 5.25 0 0 0 6.75 8v1.253c.373-.003.772-.003 1.195-.003h8.11c.423 0 .822 0 1.195.003V8c0-2.9-2.35-5.25-5.25-5.25Zm-7.192 8.103c-.734.099-1.122.28-1.399.556c-.277.277-.457.665-.556 1.4c-.101.755-.103 1.756-.103 3.191c0 1.435.002 2.436.103 3.192c.099.734.28 1.122.556 1.399c.277.277.665.457 1.4.556c.754.101 1.756.103 3.191.103h8c1.435 0 2.436-.002 3.192-.103c.734-.099 1.122-.28 1.399-.556c.277-.277.457-.665.556-1.4c.101-.755.103-1.756.103-3.191c0-1.435-.002-2.437-.103-3.192c-.099-.734-.28-1.122-.556-1.399c-.277-.277-.665-.457-1.4-.556c-.755-.101-1.756-.103-3.191-.103H8c-1.435 0-2.437.002-3.192.103Z" clip-rule="evenodd"/></g></svg>
                </x-todo-button>
                @else
                <x-todo-button x-data x-on:click="modal_lock_open('{{ route('note.lock', $data->slug) }}')" class="text-amber-600 bg-amber-100 hover:bg-amber-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-6 md:w-6" viewBox="0 0 24 24"><g fill="currentColor"><path d="M8 17a1 1 0 1 0 0-2a1 1 0 0 0 0 2Zm4 0a1 1 0 1 0 0-2a1 1 0 0 0 0 2Zm5-1a1 1 0 1 1-2 0a1 1 0 0 1 2 0Z"/><path fill-rule="evenodd" d="M6.75 8a5.25 5.25 0 0 1 10.335-1.313a.75.75 0 0 0 1.452-.374A6.75 6.75 0 0 0 5.25 8v1.303c-.227.016-.44.036-.642.064c-.9.12-1.658.38-2.26.981c-.602.602-.86 1.36-.981 2.26c-.117.867-.117 1.97-.117 3.337v.11c0 1.367 0 2.47.117 3.337c.12.9.38 1.658.981 2.26c.602.602 1.36.86 2.26.982c.867.116 1.97.116 3.337.116h8.11c1.367 0 2.47 0 3.337-.116c.9-.122 1.658-.38 2.26-.982c.602-.602.86-1.36.982-2.26c.116-.867.116-1.97.116-3.337v-.11c0-1.367 0-2.47-.116-3.337c-.122-.9-.38-1.658-.982-2.26c-.602-.602-1.36-.86-2.26-.981c-.867-.117-1.97-.117-3.337-.117h-8.11c-.423 0-.821 0-1.195.003V8Zm-1.942 2.853c-.734.099-1.122.28-1.399.556c-.277.277-.457.665-.556 1.4c-.101.755-.103 1.756-.103 3.191c0 1.435.002 2.436.103 3.192c.099.734.28 1.122.556 1.399c.277.277.665.457 1.4.556c.754.101 1.756.103 3.191.103h8c1.435 0 2.436-.002 3.192-.103c.734-.099 1.122-.28 1.399-.556c.277-.277.457-.665.556-1.4c.101-.755.103-1.756.103-3.191c0-1.435-.002-2.437-.103-3.192c-.099-.734-.28-1.122-.556-1.399c-.277-.277-.665-.457-1.4-.556c-.755-.101-1.756-.103-3.191-.103H8c-1.435 0-2.437.002-3.192.103Z" clip-rule="evenodd"/></g></svg>
                </x-todo-button>
                @endisset
            </div>
        </a>
    </div>
</div>
@endforeach
<div class="mb-4">
    {{ $datas->links() }}
</div>
@else
<x-blank>{{ __('Tidak ada catatan.') }}</x-blank>
@endif
@endsection
