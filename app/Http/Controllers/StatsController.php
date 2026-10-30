<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    // Case 1: Зведена статистика за сторінками або IP
    public function pages(Request $request)
    {
        $type = $request->query('type', 'page');

        if (!in_array($type, ['page', 'ip'], true)) {
            abort(400, 'Невідомий тип групування.');
        }

        $rows = Tracker::query()
            ->selectRaw("{$type}, count(*) as hits, max(visited_at) as last_visit")
            ->groupBy($type)
            ->orderByDesc('hits')
            ->get();

        return view('stats.pages', compact('rows', 'type'));
    }

    // Case 2: Детальна статистика
    public function detail(Request $request)
    {
        $type = $request->query('type', 'page');
        $item = $request->query('item');

        if (!in_array($type, ['page', 'ip'], true)) {
            abort(400, 'Невідомий тип фільтрації.');
        }

        $rows = Tracker::query()
            ->when($item, fn ($query, $value) => $query->where($type, $value))
            ->orderByDesc('visited_at')
            ->paginate(15)
            ->withQueryString();

        return view('stats.detail', compact('rows', 'type', 'item'));
    }

    // Індивідуальне завдання: Аналітика переглядів футбольних клубів
    public function clubStats()
    {
        // Отримуємо статистику звернень лише до конкретних сторінок клубів (/clubs/{id})
        $rows = Tracker::query()
            ->selectRaw("page, count(*) as hits, count(distinct ip) as unique_visitors, max(visited_at) as last_visit")
            ->where('page', 'like', 'clubs/%')
            ->where('page', 'not like', 'clubs/create')
            ->groupBy('page')
            ->orderByDesc('hits')
            ->get();

        return view('stats.clubs', compact('rows'));
    }
}
