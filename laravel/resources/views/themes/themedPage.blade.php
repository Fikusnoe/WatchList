@extends('layouts.main')

@section('title', $title . ' — WatchList')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

    <div class="space-y-2 border-b border-gray-800 pb-6">
        <nav class="text-xs text-gray-400 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Главная</a>
            <span>/</span>
            <span class="text-gray-200">{{ $title }}</span>
        </nav>
        <h1 class="text-4xl font-extrabold tracking-tight text-white">
            {{ $title }}
        </h1>
    </div>

    <div class="space-y-4">
        <h2 class="text-xl font-bold text-white tracking-tight">Недавние отзывы</h2>
        @if($recentReviews->isEmpty())
            <div class="bg-gray-800/40 border border-gray-700/60 rounded-xl p-6 text-center text-sm text-gray-400">
                Отзывов нет...
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($recentReviews as $review)
                    <a href="#" class="group relative aspect-[2/3] bg-gray-800 border border-gray-700 rounded-lg overflow-hidden shadow-sm hover:border-indigo-500 transition">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent opacity-80 z-10"></div>
                        <div class="absolute inset-0 flex flex-col justify-end p-3 z-20">
                            <p class="text-xs font-bold text-white line-clamp-2 group-hover:text-indigo-300 transition">
                                {{ $review->work->title }}
                            </p>
                            <span class="text-[10px] text-gray-400 mt-1">Оценка: {{ $review->rating }}/10</span>
                        </div>
                        <div class="w-full h-full bg-gray-700/40 flex items-center justify-center text-xs text-gray-500 italic">
                            Обложка
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-2 space-y-12">
            
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-white tracking-tight">Популярные произведения сегодня</h2>
                @if($popularWorksToday->isEmpty())
                    <div class="bg-gray-800/40 border border-gray-700/60 rounded-xl p-6 text-center text-sm text-gray-400">
                        Нет данных о популярных произведениях на сегодня.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($popularWorksToday as $work)
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 flex flex-col justify-between shadow-sm hover:border-gray-600 transition">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-gray-400 uppercase">
                                        <span class="text-indigo-400">{{ $work->genre }}</span>
                                        <span>{{ $work->release_year }} г.</span>
                                    </div>
                                    <h3 class="text-base font-bold text-white line-clamp-1">
                                        {{ $work->title }}
                                    </h3>
                                    <p class="text-xs text-gray-400 line-clamp-2">
                                        {{ $work->description }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-700/50 text-xs">
                                    <span class="text-gray-500">Просмотров: {{ $work->views_count ?? 0 }}</span>
                                    <button class="text-indigo-400 hover:text-indigo-300 font-medium unique-add-to-list-btn">В список</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-bold text-white tracking-tight">Популярные отзывы на этой неделе</h2>
                @if($popularReviewsWeek->isEmpty())
                    <div class="bg-gray-800/40 border border-gray-700/60 rounded-xl p-6 text-center text-sm text-gray-400">
                        На этой неделе ещё ничего не оценили...
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($popularReviewsWeek as $review)
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 space-y-3 shadow-sm">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold text-gray-200">{{ $review->user->name }}</span>
                                        <span class="text-gray-500">•</span>
                                        <span class="text-gray-400">к произведению <span class="text-indigo-400 font-medium">{{ $review->work->title }}</span></span>
                                    </div>
                                    <div class="flex items-center space-x-1 text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">
                                        <span class="font-bold text-xs">{{ $review->rating }}</span>
                                        <span class="text-[10px] text-amber-500/80">/10</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-300 leading-relaxed">
                                    {{ $review->text }}
                                </p>
                                <div class="text-[11px] text-gray-500 pt-1">
                                    {{ $review->created_at->locale('ru')->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <div class="space-y-4 lg:sticky lg:top-20">
            
            <div class="flex flex-col sm:flex-row lg:flex-col sm:items-center lg:items-start justify-between gap-2">
                <h2 class="text-xl font-bold text-white tracking-tight">Лента активности</h2>
                <a href="#activity-feed" class="inline-flex items-center text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition group border border-indigo-500/30 hover:border-indigo-500/60 bg-indigo-500/5 px-3 py-1.5 rounded-lg">
                    <span>Полная лента активности</span>
                    <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div 
                id="realtime-reviews-island" 
                data-type="{{ $currentType }}"
                class="bg-gray-800 border border-gray-700 rounded-xl p-4 min-h-[450px] shadow-md"
            >
                <div class="flex flex-col items-center justify-center h-[400px] text-gray-500 text-sm space-y-2">
                    <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Подключение к серверу обновлений...</span>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection