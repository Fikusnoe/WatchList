<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;

class WatchlistController extends Controller
{
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'nullable|in:wanted,watched',
        ]);

        $user = auth()->user();
        $status = $request->input('status');

        $work = Work::findOrFail($id);

        if (empty($status)) {
            $user->watchlistWorks()->detach($id);
            $message = "«{$work->title}» удалено из вашего списка отслеживания.";
        } else {
            $user->watchlistWorks()->syncWithoutDetaching([
                $id => ['status' => $status]
            ]);

            $statusText = $work->type === 'book'
                ? ($status === 'wanted' ? '«Хочу прочитать»' : '«Прочитано»')
                : ($status === 'wanted' ? '«Хочу посмотреть»' : '«Просмотрено»');

            $message = "«{$work->title}» успешно добавлено в список {$statusText}.";
        }

        return redirect()->back()->with('success', $message);
    }
}