@extends('layouts.app')

@section('content')
    <h1>Кабінет автора</h1>
    <h3>Ваші записи:</h3>
    @forelse ($own as $blog)
        <p>
            <a href="{{ route('blog.show', $blog) }}">{{ $blog->title }}</a>
        </p>
    @empty
        <p>Ви ще не створили жодного запису.</p>
    @endforelse
@endsection
