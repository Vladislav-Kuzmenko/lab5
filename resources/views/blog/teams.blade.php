@extends('layouts.app')
@section('title', 'Керування клубами')

@section('content')
    <div class="container mt-4">
        <h2>Прив'язка клубів до новини: {{ $blog->getTranslatedAttribute('title', app()->getLocale()) }}</h2>

        <form method="POST" action="{{ route('blog.teams.store', $blog->blog_id) }}">
            @csrf
            <div class="mb-3 mt-4">
                <select id="duallist" name="teams[]" multiple>
                    @foreach ($teams as $id => $name)
                        <option value="{{ $id }}" @selected(in_array($id, old('teams', $selectedTeams)))>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Зберегти клуби</button>
            <a href="{{ route('blog.admin') }}" class="btn btn-secondary mt-3">Скасувати</a>
        </form>
    </div>
@endsection
