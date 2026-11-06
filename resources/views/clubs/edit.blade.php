@extends('layouts.app')

@section('title', 'Редагування клубу')

@section('content')
    <h1>Редагувати клуб: {{ $club->name }}</h1>
    <form method="POST" action="{{ route('clubs.update', $club) }}">
        @csrf
        @method('PUT')
        @include('clubs._form')
        <br>
        <button type="submit">Зберегти зміни</button>
    </form>
@endsection
