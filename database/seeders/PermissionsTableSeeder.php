<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_show',
            ],
            [
                'id'    => 3,
                'title' => 'permission_access',
            ],
            [
                'id'    => 4,
                'title' => 'role_create',
            ],
            [
                'id'    => 5,
                'title' => 'role_edit',
            ],
            [
                'id'    => 6,
                'title' => 'role_show',
            ],
            [
                'id'    => 7,
                'title' => 'role_delete',
            ],
            [
                'id'    => 8,
                'title' => 'role_access',
            ],
            [
                'id'    => 9,
                'title' => 'user_create',
            ],
            [
                'id'    => 10,
                'title' => 'user_edit',
            ],
            [
                'id'    => 11,
                'title' => 'user_show',
            ],
            [
                'id'    => 12,
                'title' => 'user_delete',
            ],
            [
                'id'    => 13,
                'title' => 'user_access',
            ],
            [
                'id'    => 14,
                'title' => 'customer_create',
            ],
            [
                'id'    => 15,
                'title' => 'customer_edit',
            ],
            [
                'id'    => 16,
                'title' => 'customer_show',
            ],
            [
                'id'    => 17,
                'title' => 'customer_delete',
            ],
            [
                'id'    => 18,
                'title' => 'customer_access',
            ],
            [
                'id'    => 19,
                'title' => 'event_create',
            ],
            [
                'id'    => 20,
                'title' => 'event_edit',
            ],
            [
                'id'    => 21,
                'title' => 'event_show',
            ],
            [
                'id'    => 22,
                'title' => 'event_delete',
            ],
            [
                'id'    => 23,
                'title' => 'event_access',
            ],
            [
                'id'    => 24,
                'title' => 'config_create',
            ],
            [
                'id'    => 25,
                'title' => 'config_edit',
            ],
            [
                'id'    => 26,
                'title' => 'config_show',
            ],
            [
                'id'    => 27,
                'title' => 'config_delete',
            ],
            [
                'id'    => 28,
                'title' => 'config_access',
            ],
            [
                'id'    => 29,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
