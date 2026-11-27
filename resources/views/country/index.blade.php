@extends('layouts.app')

@section('content')
    <style>
        /* Пагінація: цифри зверху, текст "Showing..." під ними */
        .pagination-stack nav > div:last-child {
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .pagination-stack nav > div:last-child > div:last-child {
            order: 1;
        }
        .pagination-stack nav > div:last-child > div:first-child {
            order: 2;
            margin-top: .5rem;
        }
        .pagination-stack nav p {
            margin-bottom: 0;
        }
    </style>

    <div class="card p-4 shadow-sm" style="background: #fff; border-radius: 8px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0">Довідник країн</h2>
            <a href="{{ route('country.create') }}" class="btn btn-primary">+ Додати країну</a>
        </div>

        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
            <tr>
                <th scope="col" style="width: 50px;">#</th>
                <th scope="col" style="width: 80px;">Код</th>
                <th scope="col">Назва</th>
                <th scope="col">Населення</th>
                <th scope="col" class="text-end" style="width: 150px;">Дії</th>
            </tr>
            </thead>
            <tbody>
            @forelse($countries as $country)
                <tr>
                    <td>{{ $loop->iteration + ($countries->currentPage() - 1) * $countries->perPage() }}</td>
                    <td><strong>{{ $country->code }}</strong></td>
                    <td>
                        <a href="{{ route('country.show', $country) }}" class="text-decoration-none fw-bold">
                            {{ $country->name }}
                        </a>
                    </td>
                    <td>{{ number_format($country->population, 0, ',', ' ') }}</td>
                    <td class="text-end">
                        <a href="{{ route('country.edit', $country) }}" class="btn btn-sm btn-outline-primary me-1">Редагувати</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Країн не знайдено</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="pagination-stack mt-3">
            {{ $countries->links() }}
        </div>
    </div>
@endsection
