<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogTranslation;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'uk');
        $blogs = Blog::with(['category', 'author', 'translations'])
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
        $categories = Category::orderBy('category_name')->pluck('category_name', 'category_id');
        return view('blog.create', compact('categories'));
    }

    public function store(BlogRequest $request)
    {
        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        BlogTranslation::create([
            'blog_id' => $blog->blog_id,
            'locale' => 'uk',
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
        ]);

        if ($request->filled('en_title')) {
            BlogTranslation::create([
                'blog_id' => $blog->blog_id,
                'locale' => 'en',
                'title' => $request->en_title,
                'description' => $request->en_description,
                'text' => $request->en_text,
            ]);
        }

        return redirect()->route('blog.show', $blog);
    }

    public function show(Blog $blog, Request $request)
    {
        $lang = $request->get('lang', 'uk');
        $blog->load(['category', 'author', 'translations']);
        return view('blog.show', compact('blog', 'lang'));
    }

    public function edit(Blog $blog)
    {
        $blog->load('translations');
        $categories = Category::orderBy('category_name')->pluck('category_name', 'category_id');
        $en = $blog->translations->firstWhere('locale', 'en');

        return view('blog.edit', compact('blog', 'categories', 'en'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->update([
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'category_id' => $request->category_id,
        ]);

        BlogTranslation::updateOrCreate(
            ['blog_id' => $blog->blog_id, 'locale' => 'uk'],
            ['title' => $request->title, 'description' => $request->description, 'text' => $request->text]
        );

        if ($request->filled('en_title')) {
            BlogTranslation::updateOrCreate(
                ['blog_id' => $blog->blog_id, 'locale' => 'en'],
                ['title' => $request->en_title, 'description' => $request->en_description, 'text' => $request->en_text]
            );
        }

        return redirect()->route('blog.admin')->with('success', 'Запис успішно оновлено!');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.admin')->with('success', 'Запис видалено!');
    }
}
