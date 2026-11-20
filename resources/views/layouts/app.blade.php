<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'УПЛ Довідник')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<!-- Навігаційна панель -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('clubs.index') }}">⚽ УПЛ Довідник</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav me-auto">
                <a class="nav-link {{ request()->routeIs('country.*') ? 'active' : '' }}" href="{{ route('country.index') }}">Країни</a>
                <a class="nav-link {{ request()->routeIs('clubs.*') ? 'active' : '' }}" href="{{ route('clubs.index') }}">Футбольні клуби</a>
                <a class="nav-link {{ request()->routeIs('stats.*') ? 'active' : '' }}" href="{{ route('stats.pages') }}">Статистика</a>
                <a class="nav-link {{ request()->routeIs('blog.index') || request()->routeIs('blog.show') ? 'active' : '' }}" href="{{ route('blog.index') }}">Блог / Новини</a>
                <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакти</a>
            </div>

            <!-- Меню автентифікації -->
            <div class="navbar-nav ms-auto align-items-center">
                @auth
                    <a class="nav-link {{ request()->routeIs('blog.admin') ? 'active' : '' }}" href="{{ route('blog.admin') }}">Панель адміністрування</a>
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Користувачі</a>
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Мій профіль</a>

                    <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            Вийти ({{ auth()->user()->name }})
                        </button>
                    </form>
                @endauth

                @guest
                    <a class="nav-link me-2" href="{{ route('login') }}">Увійти</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Реєстрація</a>
                @endguest
            </div>
        </div>
    </div>
</nav>

<!-- Основний контент -->
<div class="container bg-white p-4 rounded shadow-sm mb-4 flex-grow-1">
    <!-- Flash-повідомлення -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- Підвал -->
<footer class="mt-auto py-3 bg-dark text-white text-center">
    <div class="container">
        <p class="mb-0">Виконав: студент групи РС-42 Кузьменко Владислав</p>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.bundle.min.css"></script>
</body>
</html>
