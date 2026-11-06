@extends('layouts.app')

@section('title', 'Редагування запису')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Редагування запису #{{ $blog->blog_id }}</h1>
            <form method="POST" action="{{ route('blog.update', $blog) }}">
                @csrf
                @method('PUT')
                @include('blog._form')
                <button type="submit" class="btn btn-primary mt-3">Оновити</button>
                <a href="{{ route('blog.admin') }}" class="btn btn-secondary mt-3">Скасувати</a>
            </form>
        </div>
    </div>
@endsection
