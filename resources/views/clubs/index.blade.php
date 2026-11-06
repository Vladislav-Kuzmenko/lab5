@extends('layouts.app')

@section('title', 'Футбольні клуби УПЛ')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Футбольні клуби УПЛ</h1>
        <a href="{{ route('clubs.create') }}" class="btn btn-primary">+ Додати новий клуб</a>
    </div>

    <!-- Форма фільтрації -->
    <form method="GET" action="{{ route('clubs.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="city" class="form-control" placeholder="Пошук за містом..." value="{{ request('city') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Фільтрувати</button>
            @if(request('city'))
                <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary">Скинути</a>
            @endif
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle border">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Назва</th>
                <th>Місто</th>
                <th>Стадіон</th>
                <th>Рік</th>
                <th>Головний тренер</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($clubs as $i => $club)
                <tr>
                    <td>{{ $clubs->firstItem() + $i }}</td>
                    <td><a href="{{ route('clubs.show', $club) }}" class="fw-bold text-decoration-none">{{ $club->name }}</a></td>
                    <td>{{ $club->city }}</td>
                    <td>{{ $club->stadium }}</td>
                    <td>{{ $club->founded_year }}</td>
                    <td>{{ $club->head_coach }}</td>
                    <td>
                        <a href="{{ route('clubs.edit', $club) }}" class="btn btn-sm btn-outline-primary">Редагувати</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Клубів не знайдено.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $clubs->links() }}
    </div>
@endsection
