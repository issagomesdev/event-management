<?php

namespace Tests\Concerns;

use Database\Seeders\PermissionRoleTableSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;

/**
 * O AuthGates só define uma Gate para permissões que existem no banco
 * (app/Http/Middleware/AuthGates.php) — sem isso, todo Gate::allows()/
 * denies() de um teste autenticado é "denied" por padrão.
 */
trait SeedsPermissions
{
    protected function seedPermissions(): void
    {
        $this->seed(PermissionsTableSeeder::class);
        $this->seed(RolesTableSeeder::class);
        $this->seed(PermissionRoleTableSeeder::class);
    }
}
