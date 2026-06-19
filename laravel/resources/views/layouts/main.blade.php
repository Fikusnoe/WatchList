<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WatchList')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col m-0 p-0 font-sans">

    <header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-400 hover:text-indigo-300 transition text-white">
                    WatchList
                </a>
                
                <nav class="hidden md:flex items-center space-x-6">
                    <div class="relative group">
                        <button class="text-gray-300 hover:text-white transition flex items-center space-x-1">
                            <span>Каталоги</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-md shadow-lg py-1 hidden group-hover:block hover:block">
                            <a href="{{ route('works.movies') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Фильмы</a>
                            <a href="{{ route('works.series') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Сериалы</a>
                            <a href="{{ route('works.games') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Игры</a>
                            <a href="{{ route('works.books') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Книги</a>
                        </div>
                    </div>

                    <a href="#activity-feed" class="text-gray-300 hover:text-white transition">
                        Лента активности
                    </a>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                @guest
                    <a href="/login" class="text-gray-300 hover:text-white transition text-sm font-medium">
                        Вход
                    </a>
                    <a href="/register" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-md text-sm font-medium transition shadow-sm">
                        Регистрация
                    </a>
                @endguest

                @auth
                    <a href="/profile" class="flex items-center space-x-2 bg-gray-700 px-4 py-2 rounded-md transition text-sm font-medium border border-white text-white">
                        <span>Профиль</span>
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-800 border-t border-gray-700 py-6 text-center text-sm text-gray-400">
        <p>&copy; {{ date('Y') }} WatchList</p>
    </footer>

</body>
</html>