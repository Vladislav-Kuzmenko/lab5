<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    public function create(User $user): bool
    {
        return $user->can('createPost');
    }

    public function update(User $user, Blog $blog): bool
    {
        if ($user->can('updatePost')) {
            return true;
        }

        return $user->can('updateOwnPost') && $blog->user_id === $user->id;
    }

    public function delete(User $user, Blog $blog): bool
    {
        return $user->hasRole('admin');
    }
}
