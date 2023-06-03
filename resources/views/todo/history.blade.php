@extends('layouts.app')
@section('hero')
    <x-hero-title>{{ __('History List') }}</x-hero-title>

    {{-- Session Status --}}
    <x-session-status />

    <a href="{{ route('todo.index') }}" class="text-white bg-teal-500 border-none btn hover:bg-teal-600 mt-7">{{ __('Tulis List') }}</a>
@endsection

@section('content')
    @if ($datas->count())

        @foreach ($datas as $data)

            <p class="pb-2 text-2xl antialiased font-bold leading-8 tracking-wide underline">{{\Carbon\Carbon::parse($data->date)->translatedFormat('l, d F Y')}}</p>
            @if(!empty($data->childs))
                @foreach($data->childs as $item)
                    <div class="mb-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-md card hover:shadow-lg @if($item->is_done) todo-hijau @else todo-merah @endif">
                        <div class="px-3 py-2 leading-none card-body">
                            <div class="flex items-center justify-between">
                                <div class="pr-2">
                                    <div class="text-xs font-bold">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</div>
                                    <div>{{ $item->decrypt($item->content) }}</div>
                                </div>
                                <div class="text-right">
                                    <x-todo-button x-data x-on:click="modal_delete_open('{{ route('todo.destroy', $item->slug) }}')" class="text-red-600 bg-red-100 hover:bg-red-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-6 md:w-6" viewBox="0 0 24 24"><g fill="currentColor"><path fill-rule="evenodd" d="M10.31 2.25h3.38c.217 0 .406 0 .584.028a2.25 2.25 0 0 1 1.64 1.183c.084.16.143.339.212.544l.111.335a1.25 1.25 0 0 0 1.263.91h3a.75.75 0 0 1 0 1.5h-17a.75.75 0 0 1 0-1.5h3.09a1.25 1.25 0 0 0 1.173-.91l.112-.335c.068-.205.127-.384.21-.544a2.25 2.25 0 0 1 1.641-1.183c.178-.028.367-.028.583-.028Zm-1.302 3a2.757 2.757 0 0 0 .175-.428l.1-.3c.091-.273.112-.328.133-.368a.75.75 0 0 1 .547-.395a3.2 3.2 0 0 1 .392-.009h3.29c.288 0 .348.002.392.01a.75.75 0 0 1 .547.394c.021.04.042.095.133.369l.1.3l.039.112c.039.11.085.214.136.315H9.008Z" clip-rule="evenodd"/><path d="M5.915 8.45a.75.75 0 1 0-1.497.1l.464 6.952c.085 1.282.154 2.318.316 3.132c.169.845.455 1.551 1.047 2.104c.591.554 1.315.793 2.17.904c.822.108 1.86.108 3.146.108h.879c1.285 0 2.324 0 3.146-.108c.854-.111 1.578-.35 2.17-.904c.591-.553.877-1.26 1.046-2.104c.162-.813.23-1.85.316-3.132l.464-6.952a.75.75 0 0 0-1.497-.1l-.46 6.9c-.09 1.347-.154 2.285-.294 2.99c-.137.685-.327 1.047-.6 1.303c-.274.256-.648.422-1.34.512c-.713.093-1.653.095-3.004.095h-.774c-1.35 0-2.29-.002-3.004-.095c-.692-.09-1.066-.256-1.34-.512c-.273-.256-.463-.618-.6-1.302c-.14-.706-.204-1.644-.294-2.992l-.46-6.899Z"/><path d="M9.425 10.254a.75.75 0 0 1 .821.671l.5 5a.75.75 0 0 1-1.492.15l-.5-5a.75.75 0 0 1 .671-.821Zm5.15 0a.75.75 0 0 1 .671.82l-.5 5a.75.75 0 0 1-1.492-.149l.5-5a.75.75 0 0 1 .82-.671Z"/></g></svg>
                                    </x-todo-button>

                                    @if($item->is_done == false)
                                        <form method="POST" action="{{ route('todo.update', $item->slug) }}" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <x-todo-button class="text-green-600 bg-green-100 hover:bg-green-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-6 md:w-6" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19L21 7l-1.41-1.41L9 16.17z"/></svg>
                                            </x-todo-button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


        @endforeach
        <div class="mb-4">
            {{ $datas->links() }}
        </div>
    @else
        <x-blank>{{ __('Tidak ada history.') }}</x-blank>
    @endif
@endsection
