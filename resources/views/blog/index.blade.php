@extends('layouts.app')

@section('title', 'Новини УПЛ')

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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Новини та публікації UPL</h1>
        <div>
            <a href="{{ route('blog.admin') }}" class="btn btn-outline-secondary me-2">Панель адміністрування</a>
            <div class="btn-group" role="group">
                <a href="{{ route('blog.index', ['lang' => 'uk']) }}" class="btn btn-sm {{ $lang == 'uk' ? 'btn-primary' : 'btn-outline-primary' }}">🇺🇦 UA</a>
                <a href="{{ route('blog.index', ['lang' => 'en']) }}" class="btn btn-sm {{ $lang == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">🇬🇧 EN</a>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
        @forelse ($blogs as $blog)
            <div class="col">
                @include('blog._item', ['blog' => $blog, 'lang' => $lang])
            </div>
        @empty
            <div class="col-12"><p class="text-center text-muted">Записів поки немає.</p></div>
        @endforelse
    </div>

    <div class="pagination-stack">
        {{ $blogs->links() }}
    </div>
@endsection
