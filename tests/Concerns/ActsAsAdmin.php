<?php

namespace Tests\Concerns;

use App\Models\Role;
use App\Models\User;

trait ActsAsAdmin
{
    use SeedsPermissions;

    /** Role "Admin" (id 1) — todas as permissões seedadas. */
    protected function actingAsAdmin(): User
    {
        return $this->actingAsRole(1);
    }

    /** Role "User" (id 2) — todas as permissões exceto user_, role_ e permission_. */
    protected function actingAsRestrictedUser(): User
    {
        return $this->actingAsRole(2);
    }

    /** Usuário autenticado sem nenhuma role/permissão. */
    protected function actingAsUserWithoutPermissions(): User
    {
        $this->seedPermissions();

        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    protected function actingAsRole(int $roleId): User
    {
        $this->seedPermissions();

        $user = User::factory()->create();
        $user->roles()->sync([$roleId]);
        $this->actingAs($user);

        return $user;
    }
}
