@extends('layouts.main')

@section('title', $title . ' — WatchList')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

    <div class="space-y-2">
        <nav class="text-xs text-gray-400 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Главная</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-indigo-400 transition">Каталог</a>
            <span>/</span>
            <span class="text-gray-200">{{ $title }}</span>
        </nav>
        <h1 class="text-3xl font-extrabold tracking-tight text-white">
            {{ $title }}
        </h1>
    </div>

    <form method="GET" action="{{ url()->current() }}" class="bg-gray-800 border border-gray-700 rounded-xl p-6 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        
        <div class="space-y-2">
            <label for="search" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Поиск по названию</label>
            <input 
                type="text" 
                id="search" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Введите название..." 
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition"
            >
        </div>

        <div class="space-y-2">
            <label for="genre" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Жанр</label>
            <select 
                id="genre" 
                name="genre" 
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 transition appearance-none"
            >
                <option value="">Все жанры</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre }}" {{ request('genre') === $genre ? 'selected' : '' }}>
                        {{ $genre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex space-x-3">
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm px-4 py-2 rounded-lg transition shadow-sm text-center">
                Применить
            </button>
            @if(request()->filled('search') || request()->filled('genre'))
                <a href="{{ url()->current() }}" class="bg-gray-700 hover:bg-gray-600 text-gray-200 font-medium text-sm px-4 py-2 rounded-lg transition text-center flex items-center justify-center">
                    Сбросить
                </a>
            @endif
        </div>
    </form>

    @if($works->isEmpty())
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-12 text-center text-gray-400">
            <p class="text-lg font-medium">Произведения не найдены</p>
            <p class="text-sm text-gray-500 mt-1">Попробуйте изменить параметры фильтрации или поисковый запрос.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($works as $work)
                <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-md flex flex-col justify-between hover:border-gray-500 transition group">
                    
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between text-xs font-semibold tracking-wider text-gray-400 uppercase">
                            <span class="bg-gray-900 px-2.5 py-1 rounded border border-gray-700">
                                @if($work->type === 'movie') Фильм
                                @elseif($work->type === 'series') Сериал
                                @elseif($work->type === 'game') Игра
                                @else Книга
                                @endif
                            </span>
                            <span class="text-indigo-400">
                                {{ $work->release_year }}
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

                    <div class="px-5 py-4 bg-gray-900/40 border-t border-gray-700/50 flex items-center justify-between text-sm">
                        <span class="text-gray-400 truncate max-w-[150px]" title="{{ $work->genre }}">
                            {{ $work->genre }}
                        </span>
                        
                        <button class="text-xs font-semibold text-white transition unique-add-to-list-btn">
                            В список
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-12 pt-6 border-t border-gray-800">
            {{ $works->appends(request()->query())->links() }}
        </div>
    @endif

</div>
@endsection