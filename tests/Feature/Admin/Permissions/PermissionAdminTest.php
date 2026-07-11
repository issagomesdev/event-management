<?php

namespace Tests\Feature\Admin\Permissions;

use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class PermissionAdminTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_index_requires_permission_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.permissions.index'))->assertForbidden();
    }

    public function test_index_lists_permissions_for_an_authorized_user(): void
    {
        $this->actingAsAdmin();

        $this->get(route('admin.permissions.index'))->assertOk();
    }

    public function test_show_requires_permission_show(): void
    {
        $this->actingAsUserWithoutPermissions();
        $permission = Permission::factory()->create();

        $this->get(route('admin.permissions.show', $permission))->assertForbidden();
    }

    public function test_show_renders_for_an_authorized_user(): void
    {
        $this->actingAsAdmin();
        $permission = Permission::factory()->create();

        $this->get(route('admin.permissions.show', $permission))->assertOk();
    }

    public function test_create_edit_and_delete_routes_do_not_exist_even_for_admins(): void
    {
        // A seeder nunca cadastra permission_create/edit/delete — nem o
        // Admin pode ser autorizado a criar/editar/apagar permissões, e as
        // rotas nem existem (resource com except em create/store/edit/update/destroy).
        $this->actingAsAdmin();

        $this->get(route('admin.permissions.index') . '/create')->assertNotFound();
        $this->post(route('admin.permissions.index'))->assertMethodNotAllowed();
    }
}
