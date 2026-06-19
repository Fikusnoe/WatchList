<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkController extends Controller
{
    /**
     * Главная страница
     */
    public function index(): View
    {
        return view('home');
    }

    /**
     * Страница "Фильмы"
     */
    public function movies(): View
    {
        $works = Work::where('type', 'movie')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Фильмы',
            'currentType' => 'movie'
        ]);
    }

    /**
     * Страница "Сериалы"
     */
    public function series(): View
    {
        $works = Work::where('type', 'series')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Сериалы',
            'currentType' => 'series'
        ]);
    }

    /**
     * Страница "Игры"
     */
    public function games(): View
    {
        $works = Work::where('type', 'game')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Игры',
            'currentType' => 'game'
        ]);
    }

    /**
     * Страница "Книги"
     */
    public function books(): View
    {
        $works = Work::where('type', 'book')->orderBy('release_year', 'desc')->paginate(10);
        
        return view('themes.catalog', [
            'works' => $works,
            'title' => 'Книги',
            'currentType' => 'book'
        ]);
    }
}