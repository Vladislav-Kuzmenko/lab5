<?php

namespace App\Http\Controllers;

use App\Models\FootballClub;
use App\Http\Requests\FootballClubRequest;
use Illuminate\Http\Request;

class FootballClubController extends Controller
{
    // 1. Список клубів + Пошук/Фільтрація за містом + Пагінація
    public function index(Request $request)
    {
        $query = FootballClub::query();

        // Фільтрація за містом
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        $clubs = $query->orderBy('points', 'desc')
            ->paginate(5)
            ->appends($request->query());

        return view('clubs.index', compact('clubs'));
    }

    // 2. Форма створення
    public function create()
    {
        return view('clubs.create');
    }

    // 3. Збереження нового клубу
    public function store(FootballClubRequest $request)
    {
        FootballClub::create($request->validated());

        return redirect()->route('clubs.index');
    }

    // 4. Перегляд одного клубу
    public function show(FootballClub $club)
    {
        return view('clubs.show', compact('club'));
    }

    // 5. Форма редагування
    public function edit(FootballClub $club)
    {
        return view('clubs.edit', compact('club'));
    }

    // 6. Оновлення даних
    public function update(FootballClubRequest $request, FootballClub $club)
    {
        $club->update($request->validated());

        return redirect()->route('clubs.index');
    }

    // 7. Видалення
    public function destroy(FootballClub $club)
    {
        $club->delete();

        return redirect()->route('clubs.index');
    }
}
