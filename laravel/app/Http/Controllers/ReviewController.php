<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_id' => 'required|exists:works,id',
            'rating'  => 'required|integer|min:1|max:10',
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

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'text'   => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'text'   => $validated['text'],
        ]);

        $payload = [
            'event'      => 'review_updated',
            'id'         => $review->id,
            'rating'     => $review->rating,
            'text'       => $review->text,
            'work_id'    => $review->work_id
        ];
        Redis::publish('reviews_channel', json_encode($payload));

        return redirect()->back()->with('success', 'Отзыв успешно обновлен!');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $reviewId = $review->id;
        $workId = $review->work_id;

        $review->delete();

        $payload = [
            'event'      => 'review_deleted',
            'id'         => $reviewId,
            'work_id'    => $workId
        ];
        Redis::publish('reviews_channel', json_encode($payload));

        return redirect()->back()->with('success', 'Отзыв успешно удален!');
    }
}