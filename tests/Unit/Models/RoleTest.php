<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions_relationship(): void
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();
        $role->permissions()->attach($permission->id);

        $this->assertTrue($role->permissions->contains('id', $permission->id));
    }

    public function test_users_can_be_attached_to_a_role_via_role_user_pivot(): void
    {
        $role = Role::factory()->create();
        $user = User::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
    }
}
