@extends('layouts.app')

@section('title', 'Додати країну')

@section('content')
    <h1>Додати країну</h1>
    <form method="POST" action="{{ route('country.store') }}">
        @csrf
        @include('country._form')
        <br>
        <button type="submit">Зберегти</button>
    </form>
@endsection
