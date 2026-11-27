@extends('layouts.app')

@section('title', 'Користувачі системи')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Користувачі системи (Довідник УПЛ)</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
            <tr>
                <th width="50">#</th>
                <th>Ім’я</th>
                <th>Електронна пошта</th>
                <th>Ролі</th>
                <th>Дата реєстрації</th>
                <th width="200">Дії</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $i => $user)
                <tr>
                    <td>{{ $users->firstItem() + $i }}</td>
                    <td class="fw-bold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->implode(', ') ?: '-' }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : '—' }}</td>
                    <td>
                        @can('update', $user)
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Редагувати</a>
                        @endcan

                        @can('delete', $user)
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Видалити?')">Видалити</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Користувачів поки немає.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $users->links() }}
    </div>
@endsection
