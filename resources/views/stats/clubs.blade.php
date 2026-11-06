@extends('layouts.app')

@section('title', 'Популярність клубів')

@section('content')
    <h1>Аналітика популярності футбольних клубів</h1>

    <p><a href="{{ route('stats.pages') }}">← До загальної статистики</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
        <tr>
            <th>URL Сторінки клубу</th>
            <th>Всього переглядів</th>
            <th>Унікальних відвідувачів (IP)</th>
            <th>Останній перегляд</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($rows as $row)
            <tr>
                <td>
                    <a href="{{ url($row->page) }}">{{ $row->page }}</a>
                </td>
                <td>{{ $row->hits }}</td>
                <td>{{ $row->unique_visitors }}</td>
                <td>{{ $row->last_visit }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Сторінки окремих клубів ще не переглядали. Відкрийте декілька клубів зі списку!</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
