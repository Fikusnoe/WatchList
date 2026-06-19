@extends('layouts.main')

@section('title', 'Главная страница — WatchList')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

    <div class="bg-gradient-to-r from-indigo-900 to-slate-800 rounded-2xl p-8 md:p-12 shadow-xl text-center md:text-left flex flex-col md:flex-row items-center justify-between border border-indigo-500/20">
        <div class="max-w-2xl space-y-4">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white">
                Твой персональный онлайн дневник.
            </h1>
            <p class="text-lg text-white">
                Сохраняй, делись, изучай.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <a href="{{ route('works.movies') }}" class="group relative bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:border-indigo-500/50 transition duration-300 p-6 flex flex-col justify-between min-h-[160px]">
                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-white mt-4">Фильмы</h3>
                    <p class="text-sm text-gray-400">Шедевры мирового кинематографа и новинки проката</p>
                </div>
                <span class="text-xs font-semibold text-white flex items-center space-x-1 mt-4">
                    <span>Открыть категорию ></span>
                </span>
            </a>

            <a href="{{ route('works.series') }}" class="group relative bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:border-indigo-500/50 transition duration-300 p-6 flex flex-col justify-between min-h-[160px]">
                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-white mt-4">Сериалы</h3>
                    <p class="text-sm text-gray-400">Многосерийные шоу, многосезонные драмы и ситкомы</p>
                </div>
                <span class="text-xs font-semibold text-white flex items-center space-x-1 mt-4">
                    <span>Открыть категорию ></span>
                </span>
            </a>

            <a href="{{ route('works.games') }}" class="group relative bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:border-indigo-500/50 transition duration-300 p-6 flex flex-col justify-between min-h-[160px]">
                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-white mt-4">Игры</h3>
                    <p class="text-sm text-gray-400">Компьютерные релизы, консольные эксклюзивы и инди</p>
                </div>
                <span class="text-xs font-semibold text-white flex items-center space-x-1 mt-4">
                    <span>Открыть категорию ></span>
                </span>
            </a>

            <a href="{{ route('works.books') }}" class="group relative bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:border-indigo-500/50 transition duration-300 p-6 flex flex-col justify-between min-h-[160px]">
                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-white mt-4">Книги</h3>
                    <p class="text-sm text-gray-400">Художественные бестселлеры, научная литература и биографии</p>
                </div>
                <span class="text-xs font-semibold text-white flex items-center space-x-1 mt-4">
                    <span>Открыть категорию ></span>
                </span>
            </a>

        </div>
    </div>

    <div id="activity-feed" class="space-y-6 pt-8 border-t border-gray-800">
        <h2 class="text-2xl font-bold tracking-tight text-white flex items-center space-x-2">
            <span>Лента отзывов в реальном времени</span>
        </h2>
        
        <div id="activity-feed-root">
            <div class="bg-gray-800/40 border border-gray-700/50 rounded-xl p-8 text-center text-gray-400">
                <p class="text-sm">Тут будут подтягиваться отзывы через FastAPI</p>
            </div>
        </div>
    </div>

</div>
@endsection