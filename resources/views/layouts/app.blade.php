<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Довідник')</title>
    <!-- Підключення Bootstrap 5 через CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<!-- Навігаційна панель (Navbar) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('clubs.index') }}">⚽ УПЛ Довідник</a>
        <div class="navbar-nav">
            <a class="nav-link {{ request()->routeIs('country.*') ? 'active' : '' }}" href="{{ route('country.index') }}">Країни</a>
            <a class="nav-link {{ request()->routeIs('clubs.*') ? 'active' : '' }}" href="{{ route('clubs.index') }}">Футбольні клуби</a>
            <a class="nav-link {{ request()->routeIs('stats.*') ? 'active' : '' }}" href="{{ route('stats.pages') }}">Статистика</a>
            <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Блог / Новини</a>
            <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакти</a>
        </div>
    </div>
</nav>

<!-- Основний контент -->
<div class="container bg-white p-4 rounded shadow-sm mb-4">
    <!-- Flash-повідомлення -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

<!-- Підвал (Footer) -->
<footer class="mt-auto py-3 bg-dark text-white text-center">
    <div class="container">
        <p class="mb-0">Виконав: студент групи РС-42 Кузьменко Владислав</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
