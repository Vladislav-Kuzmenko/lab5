@extends('layouts.app')

@section('title', 'Детальна статистика')

@section('content')
    <h1>Детальна статистика</h1>

    <p>
        Фільтр: <strong>{{ $type }}</strong> = <strong>{{ $item }}</strong>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
        <tr>
            <th>Сторінка</th>
            <th>IP</th>
            <th>User-Agent (Пристрій)</th>
            <th>Статус</th>
            <th>Дата і час</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row->page }}</td>
                <td>{{ $row->ip }}</td>
                <td><small>{{ $row->user_agent }}</small></td>
                <td>{{ $row->status }}</td>
                <td>{{ $row->visited_at ? $row->visited_at->format('d.m.Y H:i:s') : '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br>
    {{ $rows->links() }}

    <p><a href="{{ route('stats.pages') }}">Повернутися до загальної статистики</a></p>
@endsection
