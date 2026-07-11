<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_title_and_description_are_mass_assignable(): void
    {
        $permission = Permission::create([
            'title' => 'event_create',
            'description' => 'Pode criar eventos',
        ]);

        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'title' => 'event_create',
            'description' => 'Pode criar eventos',
        ]);
    }

    public function test_belongs_to_many_roles_through_permission_role_pivot(): void
    {
        $permission = Permission::factory()->create();
        $role = Role::factory()->create();
        $role->permissions()->attach($permission->id);

        $this->assertDatabaseHas('permission_role', ['permission_id' => $permission->id, 'role_id' => $role->id]);
    }
}
