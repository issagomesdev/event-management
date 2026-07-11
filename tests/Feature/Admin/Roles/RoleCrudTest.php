<?php

namespace Tests\Feature\Admin\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class RoleCrudTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_index_requires_role_access_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.roles.index'))->assertForbidden();
    }

    public function test_restricted_role_cannot_manage_roles(): void
    {
        $this->actingAsRestrictedUser();

        $this->get(route('admin.roles.index'))->assertForbidden();
    }

    public function test_store_creates_a_role_and_syncs_permissions(): void
    {
        $this->actingAsAdmin();
        $permission = Permission::factory()->create();

        $response = $this->post(route('admin.roles.store'), [
            'title' => 'Organizador',
            'permissions' => [$permission->id],
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $role = Role::where('title', 'Organizador')->firstOrFail();
        $this->assertTrue($role->permissions->contains('id', $permission->id));
    }

    public function test_store_requires_permissions_array(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.roles.store'), ['title' => 'Sem Permissões']);

        $response->assertSessionHasErrors('permissions');
    }

    public function test_update_replaces_the_permission_set(): void
    {
        $this->actingAsAdmin();
        $role = Role::factory()->create();
        $oldPermission = Permission::factory()->create();
        $newPermission = Permission::factory()->create();
        $role->permissions()->sync([$oldPermission->id]);

        $this->put(route('admin.roles.update', $role), [
            'title' => $role->title,
            'permissions' => [$newPermission->id],
        ]);

        $role->refresh();
        $this->assertFalse($role->permissions->contains('id', $oldPermission->id));
        $this->assertTrue($role->permissions->contains('id', $newPermission->id));
    }

    public function test_destroy_soft_deletes_the_role(): void
    {
        $this->actingAsAdmin();
        $role = Role::factory()->create();

        $this->delete(route('admin.roles.destroy', $role));

        $this->assertSoftDeleted('roles', ['id' => $role->id]);
    }
}
