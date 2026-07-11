<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_is_true_only_for_users_with_role_id_1(): void
    {
        $role = Role::factory()->create(['id' => 1]);
        $user = User::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertTrue($user->fresh()->is_admin);
    }

    public function test_is_admin_is_false_for_users_without_role_1(): void
    {
        $role = Role::factory()->create(['id' => 2]);
        $user = User::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertFalse($user->fresh()->is_admin);
    }

    public function test_password_is_hashed_on_creation(): void
    {
        $user = User::factory()->create(['password' => 'plain-text-password']);

        $this->assertNotSame('plain-text-password', $user->getRawOriginal('password'));
        $this->assertTrue(Hash::check('plain-text-password', $user->getRawOriginal('password')));
    }

    public function test_empty_password_does_not_overwrite_existing_hash(): void
    {
        $user = User::factory()->create(['password' => 'original-password']);
        $originalHash = $user->getRawOriginal('password');

        $user->password = '';
        $user->save();

        $this->assertSame($originalHash, $user->fresh()->getRawOriginal('password'));
    }

    public function test_password_and_remember_token_are_hidden_from_arrays(): void
    {
        $user = User::factory()->create();

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_roles_relationship(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertTrue($user->roles->contains('id', $role->id));
    }
}
