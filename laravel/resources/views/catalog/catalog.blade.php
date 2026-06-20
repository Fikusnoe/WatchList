@extends('layouts.main')

@section('title', 'Каталог всех произведений — WatchList')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">

    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
            Каталог всех произведений
        </h1>
        <p class="text-lg text-gray-400">
            Выберите интересующий вас раздел, чтобы перейти к полному списку карточек с возможностью быстрого поиска и точечной фильтрации по жанрам.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
        
        <a href="{{ route('catalog.movies') }}" class="group bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col justify-between hover:border-indigo-500 hover:bg-gray-800/60 transition shadow-md h-52">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-white group-hover:text-indigo-400 transition">
                    Фильмы
                </h2>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Полный список кинокартин, добавленных в базу данных.
                </p>
            </div>
            <div class="text-sm font-medium text-white flex items-center space-x-1 pt-4">
                <span>Открыть раздел ></span>
            </div>
        </a>

        <a href="{{ route('catalog.series') }}" class="group bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col justify-between hover:border-indigo-500 hover:bg-gray-800/60 transition shadow-md h-52">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-white group-hover:text-indigo-400 transition">
                    Сериалы
                </h2>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Многосерийные проекты и телевизионные шоу.
                </p>
            </div>
            <div class="text-sm font-medium text-white flex items-center space-x-1 pt-4">
                <span>Открыть раздел ></span>
            </div>
        </a>

        <a href="{{ route('catalog.games') }}" class="group bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col justify-between hover:border-indigo-500 hover:bg-gray-800/60 transition shadow-md h-52">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-white group-hover:text-indigo-400 transition">
                    Игры
                </h2>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Интерактивные развлечения различных жанров и платформ.
                </p>
            </div>
            <div class="text-sm font-medium text-white flex items-center space-x-1 pt-4">
                <span>Открыть раздел ></span>
            </div>
        </a>

        <a href="{{ route('catalog.books') }}" class="group bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col justify-between hover:border-indigo-500 hover:bg-gray-800/60 transition shadow-md h-52">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-white group-hover:text-indigo-400 transition">
                    Книги
                </h2>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Художественная литература и печатные издания.
                </p>
            </div>
            <div class="text-sm font-medium text-white flex items-center space-x-1 pt-4">
                <span>Открыть раздел ></span>
            </div>
        </a>

    </div>
</div>
@endsection