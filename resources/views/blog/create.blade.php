@extends('layouts.app')

@section('title', 'Створення запису')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Створення новго запису блогу</h1>
            <form method="POST" action="{{ route('blog.store') }}">
                @csrf
                @include('blog._form')
                <button type="submit" class="btn btn-primary mt-3">Зберегти</button>
                <a href="{{ route('blog.admin') }}" class="btn btn-secondary mt-3">Скасувати</a>
            </form>
        </div>
    </div>
@endsection
