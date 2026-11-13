<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogTranslation;
use App\Models\Category;
use App\Models\Team;
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

    public function admin()
    {
        $blogs = Blog::with('category')
            ->orderByDesc('dt_created')
            ->paginate(10);

        return view('blog.admin', compact('blogs'));
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
