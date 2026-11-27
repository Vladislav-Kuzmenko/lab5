@extends('layouts.app')

@section('content')
    <h1>Кабінет адміністратора</h1>
    <p>Записів у блозі: {{ $total }}</p>
    <p>Авторів: {{ $authors }}</p>
    <a href="{{ route('blog.admin') }}">Керувати записами</a>
@endsection
