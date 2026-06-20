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
                
                <nav class="md:flex items-center space-x-6">
                    <a href="{{ route('catalog.index') }}" class="text-gray-300 hover:text-white transition font-medium {{ request()->routeIs('catalog.*') ? 'text-indigo-400 border-b-2 border-indigo-400' : '' }}">
                        Каталоги
                    </a>

                    <a href="#activity-feed" class="text-gray-300 hover:text-white transition font-medium">
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