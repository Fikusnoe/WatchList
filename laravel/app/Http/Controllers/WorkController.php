<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Review;

class WorkController extends Controller
{
    /* Главная страница */
    public function index(): View
    {
        return view('home');
    }

    /* Тематические страницы */
    public function movies(): View
    {
        return $this->getThemedPage('movie', 'Фильмы');
    }

    public function series(): View
    {
        return $this->getThemedPage('series', 'Сериалы');
    }

    public function games(): View
    {
        return $this->getThemedPage('game', 'Игры');
    }

    public function books(): View
    {
        return $this->getThemedPage('book', 'Книги');
    }

    private function getThemedPage(string $type, string $title): View
    {
        $works = Work::where('type', $type)
            ->orderBy('release_year', 'desc')
            ->paginate(10);

        $recentReviews = Review::whereHas('work', function ($query) use ($type) {
            $query->where('type', $type);
        })
        ->with(['user', 'work'])
        ->latest()
        ->take(6)
        ->get();

        $popularWorksToday = Work::where('type', $type)
            ->whereHas('reviews', function ($query) {
                $query->whereDate('created_at', now());
            })
            ->withCount(['reviews' => function ($query) {
                $query->whereDate('created_at', now());
            }])
            ->orderBy('reviews_count', 'desc')
            ->take(6)
            ->get();

        $popularReviewsWeek = Review::whereHas('work', function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->where('created_at', '>=', now()->subDays(7))
            ->with(['user', 'work'])
            ->orderBy('rating', 'desc')
            ->latest()
            ->take(6)
            ->get();

        return view('themes.themedPage', [
            'works'         => $works,
            'recentReviews' => $recentReviews,
            'popularWorksToday' => $popularWorksToday,
            'popularReviewsWeek' => $popularReviewsWeek,
            'title'         => $title,
            'currentType'   => $type
        ]);
    }

    /* Главная страница каталога */
    public function catalogIndex()
    {
        return view('catalog.catalog');
    }

    /* Каталоги */
    public function catalogMovies(Request $request)
    {
        return $this->getFilteredCatalog($request, 'movie', 'Каталог фильмов');
    }

    public function catalogSeries(Request $request)
    {
        return $this->getFilteredCatalog($request, 'series', 'Каталог сериалов');
    }

    public function catalogGames(Request $request)
    {
        return $this->getFilteredCatalog($request, 'game', 'Каталог игр');
    }

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

        $works = $query->paginate(5);

        return view('catalog.themedCatalog', [
            'works' => $works,
            'genres' => $genres,
            'title' => $title,
            'currentType' => $type
        ]);
    }
}