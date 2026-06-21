<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_id' => 'required|exists:works,id',
            'rating'  => 'required|integer|min:1|max:5',
            'text'    => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'work_id' => $validated['work_id'],
            'rating'  => $validated['rating'],
            'text'    => $validated['text'],
        ]);

        $review->load(['user', 'work']);

        $payload = [
            'id'         => $review->id,
            'username'   => $review->user->name,
            'work_title' => $review->work->title,
            'type'       => $review->work->type,
            'rating'     => $review->rating,
            'text'       => $review->text,
            'created_at' => $review->created_at->toISOString(),
        ];

        Redis::publish('reviews_channel', json_encode($payload));

        return redirect()->back()->with('success', 'Отзыв успешно опубликован!');
    }
}