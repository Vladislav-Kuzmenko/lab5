<?php

namespace App\Queries;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;

class BlogFilter
{
    // Дозволені поля для сортування (Білий список)[cite: 21, 24]
    private const SORTABLE = [
        'title'        => 'blog.title',
        'categoryName' => 'category.category_name', // Дані з пов'язаної таблиці[cite: 33]
        'created'      => 'blog.dt_created', // Або 'created_at', залежно від ваших міграцій
        'teamsCount'   => 'teams_count',     // Кількість пов'язаних записів (Інд. завдання)[cite: 33]
    ];

    public function apply(array $input): Builder
    {
        // Базовий запит з eager loading та підрахунком клубів[cite: 20, 33]
        $query = Blog::query()
            ->with(['category', 'teams']) // Вирішення проблеми N+1[cite: 20]
            ->withCount('teams')          // Підрахунок кількості клубів для сортування[cite: 33]
            ->leftJoin('category', 'blog.category_id', '=', 'category.category_id') // JOIN для сортування за назвою[cite: 19, 24]
            ->select('blog.*'); // Уникнення конфлікту колонок[cite: 20, 24]

        // Фільтрація за заголовком[cite: 24]
        $query->when(
            $input['title'] ?? null,
            fn (Builder $q, $value) => $q->where('blog.title', 'like', "%{$value}%")
        );

        // Фільтрація за назвою категорії (текстовий пошук)[cite: 25]
        $query->when(
            $input['categoryName'] ?? null,
            fn (Builder $q, $value) => $q->where('category.category_name', 'like', "%{$value}%")
        );

        // Фільтрація за вибраною категорією[cite: 25]
        $query->when(
            $input['category_id'] ?? null,
            fn (Builder $q, $value) => $q->where('blog.category_id', $value)
        );

        // Фільтрація за футбольним клубом (зв'язок N:N)[cite: 25, 33]
        $query->when(
            $input['team_id'] ?? null,
            fn (Builder $q, $value) => $q->whereHas(
                'teams',
                fn (Builder $related) => $related->whereKey($value)
            )
        );

        return $this->sort($query, $input['sort'] ?? null);
    }

    private function sort(Builder $query, ?string $sort): Builder
    {
        $desc = str_starts_with($sort ?? '', '-');
        $field = $desc ? substr($sort, 1) : $sort;

        // Сортування за замовчуванням[cite: 26]
        if (!isset(self::SORTABLE[$field])) {
            return $query->orderByDesc('blog.dt_created')
                ->orderByDesc('blog.blog_id'); // Виправлено на blog_id[cite: 18, 37]
        }

        return $query
            ->orderBy(self::SORTABLE[$field], $desc ? 'desc' : 'asc')
            ->orderByDesc('blog.blog_id'); // Виправлено на blog_id[cite: 18, 37]
    }
}
