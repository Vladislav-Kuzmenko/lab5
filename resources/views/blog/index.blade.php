@extends('layouts.app')

@section('title', 'Новини УПЛ')

@section('content')
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

    <div class="d-flex justify-content-center">
        {{ $blogs->links() }}
    </div>
@endsection
