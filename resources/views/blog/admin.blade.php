@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Адміністрування публікацій (Довідник УПЛ)</h2>

        <!-- Форма пошуку та фільтрації[cite: 30, 31, 33] -->
        <form method="GET" action="{{ route('blog.admin') }}" class="mb-4 d-flex gap-3 align-items-end">
            <div>
                <label for="title" class="form-label">Заголовок</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ request('title') }}" placeholder="Пошук...">
            </div>

            <div>
                <label for="category_id" class="form-label">Категорія</label>
                <select id="category_id" name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Усі категорії</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" @selected(request('category_id') == $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="team_id" class="form-label">Футбольний клуб УПЛ</label>
                <select id="team_id" name="team_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Усі клуби</option>
                    @foreach ($teams as $id => $name)
                        <option value="{{ $id }}" @selected(request('team_id') == $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Збереження поточного сортування при пошуку[cite: 31] -->
            <input type="hidden" name="sort" value="{{ request('sort') }}">

            <div>
                <button type="submit" class="btn btn-primary">Знайти</button>
                <a href="{{ route('blog.admin') }}" class="btn btn-secondary">Скинути</a>
            </div>
        </form>

        <!-- Таблиця результатів[cite: 28, 29] -->
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <!-- Сортування за заголовком -->
                @php
                    $currentSort = request('sort');
                    $sortTitle = $currentSort === 'title' ? '-title' : 'title';
                    $sortCat = $currentSort === 'categoryName' ? '-categoryName' : 'categoryName';
                    $sortCount = $currentSort === 'teamsCount' ? '-teamsCount' : 'teamsCount';
                @endphp
                <th>
                    <a href="{{ route('blog.admin', array_merge(request()->except('sort', 'page'), ['sort' => $sortTitle])) }}">
                        Заголовок @if($currentSort === 'title') ↑ @elseif($currentSort === '-title') ↓ @endif
                    </a>
                </th>

                <!-- Сортування за пов'язаною таблицею (Категорія)[cite: 29, 33] -->
                <th>
                    <a href="{{ route('blog.admin', array_merge(request()->except('sort', 'page'), ['sort' => $sortCat])) }}">
                        Категорія @if($currentSort === 'categoryName') ↑ @elseif($currentSort === '-categoryName') ↓ @endif
                    </a>
                </th>

                <th>Клуби УПЛ (Зв'язок)</th>

                <!-- Сортування за агрегованою кількістю (Інд. завдання)[cite: 33] -->
                <th>
                    <a href="{{ route('blog.admin', array_merge(request()->except('sort', 'page'), ['sort' => $sortCount])) }}">
                        Кількість клубів @if($currentSort === 'teamsCount') ↑ @elseif($currentSort === '-teamsCount') ↓ @endif
                    </a>
                </th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($blogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->category?->category_name ?? '—' }}</td> <!-- Виведення пов'язаних даних[cite: 28] -->
                    <td>
                        @forelse ($blog->teams as $team)
                            <span class="badge bg-success">{{ $team->name }}</span>
                        @empty
                            <span class="text-muted">Немає</span>
                        @endforelse
                    </td>
                    <td class="text-center">{{ $blog->teams_count }}</td> <!-- Результат withCount()[cite: 33] -->
                    <td>
                        <a href="{{ route('blog.edit', $blog->blog_id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Новин не знайдено</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Пагінація[cite: 27] -->
        <div class="mt-3">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection
