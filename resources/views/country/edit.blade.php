@extends('layouts.app')

@section('title', 'Редагування країни')

@section('content')
    <h1>Редагування країни</h1>
    <form method="POST" action="{{ route('country.update', $country) }}">
        @csrf
        @method('PUT')
        @include('country._form')
        <br>
        <button type="submit">Зберегти зміни</button>
    </form>
@endsection
