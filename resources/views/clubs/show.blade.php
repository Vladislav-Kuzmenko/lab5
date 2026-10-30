@extends('layouts.app')

@section('title', $club->name)

@section('content')
    <h1>{{ $club->name }}</h1>
    <p><strong>Місто:</strong> {{ $club->city }}</p>
    <p><strong>Стадіон:</strong> {{ $club->stadium }}</p>
    <p><strong>Рік заснування:</strong> {{ $club->founded_year }}</p>
    <p><strong>Головний тренер:</strong> {{ $club->head_coach }}</p>

    <p><a href="{{ route('clubs.edit', $club) }}">Редагувати</a></p>

    <form method="POST" action="{{ route('clubs.destroy', $club) }}">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Видалити клуб?')">Видалити</button>
    </form>

    <br>
    <p><a href="{{ route('clubs.index') }}">Повернутися до списку</a></p>
@endsection
