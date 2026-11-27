<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return view('cabinet.admin', [
                'total' => Blog::count(),
                'authors' => User::role('author')->count(),
            ]);
        }

        if ($user->hasRole('author')) {
            return view('cabinet.author', [
                'own' => Blog::query()
                    ->where('user_id', $user->id)
                    ->latest('dt_created')
                    ->get(),
            ]);
        }

        abort(403);
    }
}
