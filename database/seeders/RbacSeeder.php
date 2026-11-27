<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $createPost = Permission::findOrCreate('createPost', 'web');
        $updatePost = Permission::findOrCreate('updatePost', 'web');
        $updateOwnPost = Permission::findOrCreate('updateOwnPost', 'web');

        $author = Role::findOrCreate('author', 'web');
        $author->syncPermissions([
            $createPost,
            $updateOwnPost,
        ]);

        $admin = Role::findOrCreate('admin', 'web');
        $admin->syncPermissions([
            $createPost,
            $updatePost,
            $updateOwnPost,
        ]);
    }
}
