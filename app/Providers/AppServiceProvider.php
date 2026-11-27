<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::before(function (User $user, string $ability, array $arguments = []) {
            $target = $arguments[0] ?? null;

            // Виняток для UserPolicy, щоб адмін не міг видалити самого себе
            if ($target instanceof User && in_array($ability, ['update', 'delete'], true)) {
                return null;
            }

            return $user->hasRole('admin') ? true : null;
        });
    }
}
