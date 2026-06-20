@extends('layouts.main')

@section('title', $title . ' — WatchList')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

    <div class="space-y-2">
        <nav class="text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Главная</a>
            <span class="mx-2">/</span>
            <span class="text-gray-200">{{ $title }}</span>
        </nav>
        <h1 class="text-3xl font-extrabold tracking-tight text-white flex items-center space-x-3">
            <span>{{ $title }}</span>
            <span class="text-sm font-normal text-gray-400 bg-gray-800 px-3 py-1 rounded-full border border-gray-700">
                Всего: {{ $works->total() }}
            </span>
        </h1>
    </div>

    @if($works->isEmpty())
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-12 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-lg font-medium">В этой категории пока нет произведений.</p>
            <p class="text-sm text-gray-500 mt-1">Запустите сидеры или добавьте записи вручную.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($works as $work)
                <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-md flex flex-col justify-between hover:border-gray-600 transition group">
                    
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between text-xs font-semibold tracking-wider text-gray-400 uppercase">
                            <span class="flex items-center space-x-1 bg-gray-900 px-2.5 py-1 rounded-md border border-gray-700">
                                @if($work->type === 'movie') Фильм
                                @elseif($work->type === 'series') Сериал
                                @elseif($work->type === 'game') Игра
                                @else Книга
                                @endif
                            </span>
                            <span class="text-indigo-400 font-bold">
                                {{ $work->release_year }} г.
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-white group-hover:text-indigo-400 transition line-clamp-2" title="{{ $work->title }}">
                            {{ $work->title }}
                        </h3>

                        @if($work->description)
                            <p class="text-sm text-gray-400 line-clamp-3">
                                {{ $work->description }}
                            </p>
                        @endif
                    </div>

                    <div class="px-5 py-4 bg-gray-900/50 border-t border-gray-700/50 flex items-center justify-between text-sm">
                        <span class="text-gray-400 truncate max-w-[150px]" title="{{ $work->genre }}">
                            {{ $work->genre }}
                        </span>
                        
                        <button class="text-xs font-medium text-white transition flex items-center space-x-1">
                            <span>В список</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-12 pt-6 border-t border-gray-800">
            {{ $works->links() }}
        </div>
    @endif

</div>
@endsection