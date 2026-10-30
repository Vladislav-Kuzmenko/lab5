@extends('layouts.app')

@section('title', $blog->getTranslatedAttribute('title', $lang))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="mb-3">
                <a href="{{ route('blog.index', ['lang' => $lang]) }}" class="btn btn-outline-secondary btn-sm">← Назад до карток</a>
                <div class="btn-group float-end" role="group">
                    <a href="{{ route('blog.show', [$blog, 'lang' => 'uk']) }}" class="btn btn-sm {{ $lang == 'uk' ? 'btn-primary' : 'btn-outline-primary' }}">UA</a>
                    <a href="{{ route('blog.show', [$blog, 'lang' => 'en']) }}" class="btn btn-sm {{ $lang == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">EN</a>
                </div>
            </div>

            <article class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary fs-6">{{ $blog->category?->category_name ?? 'Без категорії' }}</span>
                    <span class="text-muted">{{ $blog->dt_created->format('d.m.Y H:i') }}</span>
                </div>
                <h1 class="mb-3">{{ $blog->getTranslatedAttribute('title', $lang) }}</h1>
                <p class="lead text-secondary">{{ $blog->getTranslatedAttribute('description', $lang) }}</p>
                <hr>
                <div class="fs-5">
                    {!! nl2br(e($blog->getTranslatedAttribute('text', $lang))) !!}
                </div>
                <hr>
                <small class="text-muted">Автор: {{ $blog->author?->name ?? 'Редакція' }}</small>
            </article>
        </div>
    </div>
@endsection
