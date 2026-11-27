<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //Відображення списку зареєстрованих користувачів
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $users = User::query()
            ->with('roles')
            ->orderBy('name')
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::query()->where('guard_name', 'web')->orderBy('name')->pluck('name')->all(),
            'selected' => $user->getRoleNames()->all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', ValidationRule::unique('users', 'email')->ignore($user->id)],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['string', 'distinct', ValidationRule::exists('roles', 'name')->where('guard_name', 'web')],
        ]);

        $roles = $data['roles'] ?? [];

        // Захист від зняття ролі admin із самого себе
        if ($user->id === $request->user()->id && $user->hasRole('admin') && !in_array('admin', $roles, true)) {
            throw ValidationException::withMessages([
                'roles' => 'Не можна зняти роль адміністратора із себе.',
            ]);
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $user->syncRoles($roles);

        return redirect()->route('users.index')->with('status', 'Дані користувача оновлено.');
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        abort_if($user->id === auth()->id(), 403);

        $user->delete();

        return redirect()->route('users.index')->with('status', 'Користувача видалено.');
    }
}
