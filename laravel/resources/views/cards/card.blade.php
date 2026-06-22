@extends('layouts.main')

@section('title', $work->title . ' — WatchList')

@section('content')

<div class="min-h-screen bg-gray-950 text-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl :mx-auto space-y-8">
        
        @if(session('success'))
            <div class="bg-emerald-950/50 border border-emerald-500/40 text-emerald-400 rounded-xl p-4 text-sm shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-gray-900 border border-gray-800 rounded-2xl p-6 lg:p-8 shadow-xl">
            
            {{-- Постер и список отслеживания --}}
            <div class="space-y-6">
                <div class="aspect-[2/3] w-full bg-gray-800 rounded-xl overflow-hidden border border-gray-700 shadow-inner relative group">
                    @if($work->poster_url)
                        <img src="{{ $work->poster_url }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-fu ll flex flex-col items-center justify-center text-gray-500 space-y-2">
                            <svg class="w-12 h-12 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H4a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs font-medium">Нет обложки</span>
                        </div>
                    @endif
                </div>

                {{-- Блок добавления в Watchlist --}}
                <div class="bg-gray-800/50 border border-gray-700/60 rounded-xl p-4 space-y-3">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ваш список отслеживания</h3>
                    
                    @auth
                        <form action="{{ route('watchlist.update', $work->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <div class="relative">
                                <select name="status" class="w-full bg-gray-950 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-indigo-500 appearance-none cursor-pointer">
                                    <option value="" {{ is_null($currentStatus) ? 'selected' : '' }}>-- Не отслеживается --</option>
                                    <option value="wanted" {{ $currentStatus === 'wanted' ? 'selected' : '' }}>
                                        {{ $work->type === 'book' ? 'Хочу прочитать' : 'Хочу посмотреть' }}
                                    </option>
                                    <option value="watched" {{ $currentStatus === 'watched' ? 'selected' : '' }}>
                                        {{ $work->type === 'book' ? 'Прочитано' : 'Просмотрено' }}
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm py-2 rounded-lg transition shadow-sm active:scale-[0.98]">
                                Обновить статус
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-gray-400 leading-relaxed">
                            <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Войдите</a>, чтобы добавить это произведение в свой список отслеживания.
                        </p>
                    @endauth
                </div>
            </div>

            {{-- Инфоблок --}}
            <div class="md:col-span-2 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 text-xs font-semibold uppercase tracking-wider">
                        <span class="px-2.5 py-1 bg-indigo-950/80 text-indigo-400 border border-indigo-900 rounded-md">
                            @switch($work->type)
                                @case('movie') Фильм @break
                                @case('series') Сериал @break
                                @case('game') Игра @break
                                @case('book') Книга @break
                            @endswitch
                        </span>
                        @if($work->genre)
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-400">{{ $work->genre }}</span>
                        @endif
                        <span class="text-gray-400">•</span>
                        <span class="text-gray-300">{{ $work->release_year }} год</span>
                    </div>

                    <h1 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                        {{ $work->title }}
                    </h1>

                    @if($work->author)
                        <p class="text-sm text-gray-400">
                            <span class="font-medium text-gray-500">
                                {{ $work->type === 'book' ? 'Автор:' : ($work->type === 'game' ? 'Разработчик:' : 'Режиссер:') }}
                            </span> 
                            <span class="text-gray-200 ml-1">{{ $work->author }}</span>
                        </p>
                    @endif

                    <div class="border-t border-gray-800 my-4"></div>

                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Синопсис / Описание</h3>
                        <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-line">
                            {{ $work->description ?? 'Описание к данному произведению пока отсутствует.' }}
                        </p>
                    </div>
                </div>

                {{-- Рейтинг --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-gray-800 items-center">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-14 h-14 rounded-xl {{ $averageRating ? 'bg-indigo-950 border border-indigo-500/40' : 'bg-gray-800' }}">
                            <span class="text-xl font-bold {{ $averageRating ? 'text-indigo-400' : 'text-gray-500' }}">
                                {{ $averageRating ?? '—' }}
                            </span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Рейтинг</div>
                            <div class="text-xs text-gray-400">
                                @if($averageRating)
                                    На основе {{ $work->reviews->count() }} {{ trans_choice('отзыва|отзывов|отзывов', $work->reviews->count(), [], 'ru') }}
                                @else
                                    Оценок еще нет
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Оставить отзыв --}}
        <div id="review-form-section" class="bg-gray-900 border border-gray-800 rounded-2xl p-6 lg:p-8 shadow-xl space-y-4">
            <h2 class="text-xl font-bold text-white tracking-tight">Написать рецензию</h2>
            
            @auth
                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="work_id" value="{{ $work->id }}">

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div class="space-y-2">
                            <label for="rating" class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Ваша оценка (1-10)</label>
                            <input type="number" 
                                name="rating" 
                                id="rating" 
                                min="1" 
                                max="10" 
                                required 
                                placeholder="Например: 8"
                                value="{{ old('rating') }}" 
                                class="w-full bg-gray-900 border @error('rating') border-red-500 @else border-gray-700 @enderror rounded-lg px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-indigo-500 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            @error('rating')
                                <p class="text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="text" class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Текст отзыва / Рецензия</label>
                        <textarea name="text" id="text" rows="4" required placeholder="Поделитесь вашими впечатлениями от этого произведения..." class="w-full bg-gray-900 border @error('text') border-red-500 @else border-gray-700 @enderror rounded-xl px-4 py-3 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 leading-relaxed">{{ old('text') }}</textarea>
                        @error('text')
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-right">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-md active:scale-[0.98]">
                            Опубликовать отзыв
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-700">
                    <p class="text-sm text-gray-400">
                        Только зарегистрированные пользователи могут оставлять рецензии. 
                        Пожалуйста, <a href="{{ route('login') }}" class="text-indigo-400 hover:underline font-medium">войдите в аккаунт</a> или <a href="{{ route('register') }}" class="text-indigo-400 hover:underline font-medium">зарегистрируйтесь</a>.
                    </p>
                </div>
            @endauth
        </div>

        {{-- Все отзывы --}}
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-white tracking-tight flex items-center space-x-2">
                <span>Отзывы пользователей</span>
                <span class="text-sm font-medium text-gray-500 bg-gray-900 border border-gray-800 px-2.5 py-0.5 rounded-full">
                    {{ $work->reviews->count() }}
                </span>
            </h2>

            @if($work->reviews->isEmpty())
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 text-center text-sm text-gray-400 space-y-2 shadow-xl">
                    <p class="font-medium text-gray-300">К этому произведению еще никто не оставил отзыв.</p>
                    <p class="text-xs text-gray-500">Будьте первым! Поделитесь своим мнением выше.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($work->reviews as $review)
                        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 lg:p-6 space-y-3 shadow-md" id="review-card-{{ $review->id }}">
                            
                            <div class="flex items-center justify-between border-b border-gray-800/60 pb-3 text-xs">
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-gray-200 text-sm">{{ $review->user->name }}</span>
                                    <span class="text-gray-600">•</span>
                                    <span class="text-gray-400">{{ $review->created_at->locale('ru')->diffForHumans() }}</span>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    @can('update', $review)
                                            <div class="flex items-center gap-x-4 text-gray-500 leading-none">
                                                <button onclick="toggleEditForm({{ $review->id }})" class="hover:text-indigo-400 transition font-medium block align-middle">
                                                    Редактировать
                                                </button>
                                                
                                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот отзыв?');" class="contents">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="hover:text-red-400 transition font-medium block align-middle">
                                                        Удалить
                                                    </button>
                                                </form>
                                            </div>
                                    @endcan

                                    <div class="flex items-center space-x-1.5 bg-indigo-950/60 border border-indigo-900 text-indigo-400 font-bold px-2.5 py-1 rounded-lg">
                                        <svg class="w-3.5 h-3.5 text-indigo-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span id="review-rating-display-{{ $review->id }}">{{ $review->rating }} / 10</span>
                                    </div>
                                </div>
                            </div>

                            <div id="review-text-display-{{ $review->id }}">
                                <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-line">
                                    {{ $review->text }}
                                </p>
                            </div>

                            @can('update', $review)
                                <form id="review-edit-form-{{ $review->id }}" action="{{ route('reviews.update', $review->id) }}" method="POST" class="hidden space-y-3 pt-2">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="w-24">
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Оценка</label>
                                        <input type="number" name="rating" min="1" max="10" required value="{{ $review->rating }}" 
                                            class="w-full bg-gray-950 border border-gray-700 rounded-lg px-2 py-1 text-sm text-gray-200 focus:outline-none focus:border-indigo-500">
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Текст отзыва</label>
                                        <textarea name="text" rows="3" required class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-indigo-500 leading-relaxed">{{ $review->text }}</textarea>
                                    </div>

                                    <div class="flex items-center space-x-2 justify-end text-xs">
                                        <button type="button" onclick="toggleEditForm({{ $review->id }})" class="bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1.5 rounded-lg transition">
                                            Отмена
                                        </button>
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-3 py-1.5 rounded-lg transition shadow-sm">
                                            Сохранить
                                        </button>
                                    </div>
                                </form>
                            @endcan

                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

{{-- Скрипт для формы редактирования --}}
<script>
    function toggleEditForm(reviewId) {
        const textDisplay = document.getElementById(`review-text-display-${reviewId}`);
        const editForm = document.getElementById(`review-edit-form-${reviewId}`);
        
        if (editForm.classList.contains('hidden')) {
            editForm.classList.remove('hidden');
            textDisplay.classList.add('hidden');
        } else {
            editForm.classList.add('hidden');
            textDisplay.classList.remove('hidden');
        }
    }
</script>