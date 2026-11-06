@extends('layouts.app')

@section('title', 'Додати клуб')

@section('content')
    <h1>Додати новий клуб</h1>
    <form method="POST" action="{{ route('clubs.store') }}">
        @csrf
        @include('clubs._form')
        <br>
        <button type="submit">Зберегти клуб</button>
    </form>
@endsection
