@extends('layouts.app')

@section('content')
    <h1>Редагування користувача</h1>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <label>Ім'я</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}">

        <h3>Ролі користувача</h3>
        @foreach ($roles as $role)
            <label>
                <input type="checkbox" name="roles[]" value="{{ $role }}"
                    @checked(in_array($role, old('roles', $selected), true))>
                {{ $role }}
            </label>
        @endforeach

        @if ($errors->any())
            <div class="error" style="color: red;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <button type="submit">Зберегти</button>
    </form>
@endsection
