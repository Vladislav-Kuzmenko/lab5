@extends('layouts.app')

@section('title', 'Адміністрування блогу')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Адміністрування публікацій</h1>
        <div>
            <a href="{{ route('blog.index') }}" class="btn btn-secondary me-2">До карток</a>
            <a href="{{ route('blog.create') }}" class="btn btn-success">+ Додати новий запис</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Заголовок (UA)</th>
            <th>Категорія</th>
            <th>Створено</th>
            <th width="180">Дії</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($blogs as $i => $blog)
            <tr>
                <td>{{ $blogs->firstItem() + $i }}</td>
                <td>
                    <a href="{{ route('blog.show', $blog) }}" class="fw-bold text-decoration-none">
                        {{ $blog->title }}
                    </a>
                </td>
                <td><span class="badge bg-info text-dark">{{ $blog->category?->category_name ?? 'Без категорії' }}</span></td>
                <td>{{ $blog->dt_created->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('blog.edit', $blog) }}" class="btn btn-sm btn-warning">Редагувати</a>
                    <form method="POST" action="{{ route('blog.destroy', $blog) }}" class="d-inline" onsubmit="return confirm('Видалити?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Видалити</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Записів немає.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $blogs->links() }}
    </div>
@endsection
