<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkController extends Controller
{
    /* Главная страница */
    public function index(): View
    {
        return view('home');
    }

    /* Страница "Фильмы" */
    public function movies(): View
    {
        $works = Work::where('type', 'movie')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Фильмы',
            'currentType' => 'movie'
        ]);
    }

    /* Страница "Сериалы" */
    public function series(): View
    {
        $works = Work::where('type', 'series')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Сериалы',
            'currentType' => 'series'
        ]);
    }

    /* Страница "Игры" */
    public function games(): View
    {
        $works = Work::where('type', 'game')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Игры',
            'currentType' => 'game'
        ]);
    }

    /* Страница "Книги" */
    public function books(): View
    {
        $works = Work::where('type', 'book')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Книги',
            'currentType' => 'book'
        ]);
    }

    /* Главная страница каталога */
    public function catalogIndex()
    {
        return view('catalog.catalog');
    }

    /* Подраздел каталога: Фильмы */
    public function catalogMovies(Request $request)
    {
        return $this->getFilteredCatalog($request, 'movie', 'Каталог фильмов');
    }

    /* Подраздел каталога: Сериалы */
    public function catalogSeries(Request $request)
    {
        return $this->getFilteredCatalog($request, 'series', 'Каталог сериалов');
    }

    /* Подраздел каталога: Игры */
    public function catalogGames(Request $request)
    {
        return $this->getFilteredCatalog($request, 'game', 'Каталог игр');
    }

    /* Подраздел каталога: Книги */
    public function catalogBooks(Request $request)
    {
        return $this->getFilteredCatalog($request, 'book', 'Каталог книг');
    }

    private function getFilteredCatalog(Request $request, string $type, string $title)
    {
        $query = Work::where('type', $type);

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        $genres = Work::where('type', $type)
            ->whereNotNull('genre')
            ->distinct()
            ->pluck('genre');

        $works = $query->paginate(12);

        return view('catalog.themedCatalog', [
            'works' => $works,
            'genres' => $genres,
            'title' => $title,
            'currentType' => $type
        ]);
    }
}