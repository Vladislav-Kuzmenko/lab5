<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogTranslation;
use App\Models\Category;
use App\Models\Team;
use App\Queries\BlogFilter; // Додано для ЛР7[cite: 26]
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'uk');
        $blogs = Blog::with(['category', 'author', 'translations', 'teams'])
            ->withCount('teams') // кількість клубів у $blog->teams_count
            ->orderByDesc('dt_created')
            ->paginate(6)
            ->withQueryString();

        return view('blog.index', compact('blogs', 'lang'));
    }

    // Оновлений метод admin() для ЛР7[cite: 17, 26]
    public function admin(Request $request, BlogFilter $filter)
    {
        // Валідація вхідних GET-параметрів[cite: 26, 27]
        $input = $request->validate([
            'title'       => ['nullable', 'string', 'max:200'],
            'category_id' => ['nullable', 'integer', 'exists:category,category_id'],
            'team_id'     => ['nullable', 'integer', 'exists:teams,id'], // Перевірка існування клубу[cite: 27]
            'sort'        => ['nullable', 'string', 'max:30'],
        ]);

        // Отримання відфільтрованих та відсортованих новин із збереженням параметрів пагінації[cite: 27, 33]
        $blogs = $filter->apply($input)
            ->paginate(10)
            ->withQueryString();

        return view('blog.admin', [
            'blogs'      => $blogs,
            'categories' => Category::orderBy('category_name')->pluck('category_name', 'category_id'),
            'teams'      => Team::orderBy('name')->pluck('name', 'id'), // Дані для випадаючого списку клубів УПЛ
        ]);
    }

    public function create()
    {
        return view('blog.create', [
            'categories' => Category::orderBy('category_name')->pluck('category_name', 'category_id'),
            'teams' => Team::orderBy('name')->pluck('name', 'id'),
            'selectedTeams' => [],
        ]);
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        // Лише поля таблиці blog: en_* та teams у неї не належать
        $blog = Blog::create(
            Arr::only($data, ['title', 'description', 'text', 'category_id'])
            + ['user_id' => auth()->id()]
        );

        // Зв'язки N:N
        $blog->teams()->sync($data['teams'] ?? []);

        BlogTranslation::create([
            'blog_id' => $blog->blog_id,
            'locale' => 'uk',
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'text' => $data['text'] ?? null,
        ]);

        if (!empty($data['en_title'])) {
            BlogTranslation::create([
                'blog_id' => $blog->blog_id,
                'locale' => 'en',
                'title' => $data['en_title'],
                'description' => $data['en_description'] ?? null,
                'text' => $data['en_text'] ?? null,
            ]);
        }

        return redirect()->route('blog.admin')->with('success', 'Новину створено!');
    }

    public function show(Blog $blog, Request $request)
    {
        $lang = $request->get('lang', 'uk');
        $blog->load(['category', 'author', 'translations', 'teams']);

        return view('blog.show', compact('blog', 'lang'));
    }

    public function edit(Blog $blog)
    {
        $blog->load(['translations', 'teams']);

        return view('blog.edit', [
            'blog' => $blog,
            'en' => $blog->translations->firstWhere('locale', 'en'),
            'categories' => Category::orderBy('category_name')->pluck('category_name', 'category_id'),
            'teams' => Team::orderBy('name')->pluck('name', 'id'),
            'selectedTeams' => $blog->teams->pluck('id')->all(),
        ]);
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        // Оновлюємо основні дані
        $blog->update(Arr::only($data, ['title', 'description', 'text', 'category_id']));

        // Синхронізуємо команди (зайві видаляться, нові додадуться)
        $blog->teams()->sync($data['teams'] ?? []);

        BlogTranslation::updateOrCreate(
            ['blog_id' => $blog->blog_id, 'locale' => 'uk'],
            [
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'text' => $data['text'] ?? null,
            ]
        );

        if (!empty($data['en_title'])) {
            BlogTranslation::updateOrCreate(
                ['blog_id' => $blog->blog_id, 'locale' => 'en'],
                [
                    'title' => $data['en_title'],
                    'description' => $data['en_description'] ?? null,
                    'text' => $data['en_text'] ?? null,
                ]
            );
        }

        return redirect()->route('blog.admin')->with('success', 'Новину оновлено!');
    }

    public function teamsEdit(Blog $blog)
    {
        return view('blog.teams', [
            'blog' => $blog,
            'teams' => Team::orderBy('name')->pluck('name', 'id'),
            'selectedTeams' => $blog->teams()->pluck('teams.id')->all(),
        ]);
    }

    public function teamsStore(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'teams' => ['sometimes', 'array'],
            'teams.*' => ['integer', 'distinct', 'exists:teams,id'],
        ]);

        $blog->teams()->sync($data['teams'] ?? []);

        return redirect()->route('blog.show', $blog)->with('success', 'Зв\'язки клубів оновлено!');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blog.admin')->with('success', 'Запис видалено!');
    }
}
