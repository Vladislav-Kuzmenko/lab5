<?php

namespace App\Queries;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;

class BlogFilter
{
    // Дозволені поля для сортування
    private const SORTABLE = [
        'title'        => 'blog.title',
        'categoryName' => 'category.category_name',
        'created'      => 'blog.dt_created',
        'teamsCount'   => 'teams_count',
    ];

    public function apply(array $input): Builder
    {
        // Базовий запит з eager loading та підрахунком клубів
        $query = Blog::query()
            ->with(['category', 'teams'])
            ->withCount('teams')
            ->leftJoin('category', 'blog.category_id', '=', 'category.category_id')
            ->select('blog.*');

        // Фільтрація за заголовком
        $query->when(
            $input['title'] ?? null,
            fn (Builder $q, $value) => $q->where('blog.title', 'like', "%{$value}%")
        );

        // Фільтрація за назвою категорії
        $query->when(
            $input['categoryName'] ?? null,
            fn (Builder $q, $value) => $q->where('category.category_name', 'like', "%{$value}%")
        );

        // Фільтрація за вибраною категорією
        $query->when(
            $input['category_id'] ?? null,
            fn (Builder $q, $value) => $q->where('blog.category_id', $value)
        );

        // Фільтрація за футбольним клубом (зв'язок N:N)
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

        // Сортування за замовчуванням
        if (!isset(self::SORTABLE[$field])) {
            return $query->orderByDesc('blog.dt_created')
                ->orderByDesc('blog.blog_id');
        }

        return $query
            ->orderBy(self::SORTABLE[$field], $desc ? 'desc' : 'asc')
            ->orderByDesc('blog.blog_id');
    }
}
