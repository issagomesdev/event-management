<?php

namespace Tests\Feature\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_index_requires_user_access_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_restricted_role_cannot_access_user_management(): void
    {
        // A role "User" (id 2) nunca recebe permissões user_*.
        $this->actingAsRestrictedUser();

        $this->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_store_creates_a_user_and_syncs_roles(): void
    {
        $this->actingAsAdmin();
        $role = Role::factory()->create();

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Novo Usuário',
            'email' => 'novo@admin.com',
            'password' => 'password123',
            'roles' => [$role->id],
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $user = User::where('email', 'novo@admin.com')->firstOrFail();
        $this->assertTrue($user->roles->contains('id', $role->id));
    }

    public function test_store_requires_a_role(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Sem Role',
            'email' => 'semrole@admin.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('roles');
    }

    public function test_store_rejects_a_duplicate_email(): void
    {
        $this->actingAsAdmin();
        $existing = User::factory()->create(['email' => 'duplicado@admin.com']);
        $role = Role::factory()->create();

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Outro',
            'email' => 'duplicado@admin.com',
            'password' => 'password123',
            'roles' => [$role->id],
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_update_can_keep_the_same_email(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->create(['email' => 'mesmo@admin.com']);
        $role = Role::factory()->create();

        $response = $this->put(route('admin.users.update', $user), [
            'name' => 'Nome Atualizado',
            'email' => 'mesmo@admin.com',
            'roles' => [$role->id],
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nome Atualizado']);
    }

    public function test_update_without_a_password_keeps_the_existing_hash(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->create();
        $originalHash = $user->getRawOriginal('password');
        $role = Role::factory()->create();

        $this->put(route('admin.users.update', $user), [
            'name' => $user->name,
            'email' => $user->email,
            'roles' => [$role->id],
        ]);

        $this->assertSame($originalHash, $user->fresh()->getRawOriginal('password'));
    }

    public function test_destroy_soft_deletes_the_user(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user));

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
