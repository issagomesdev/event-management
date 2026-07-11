<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\Concerns\SeedsPermissions;
use Tests\TestCase;

class ApiAuthorizationTest extends TestCase
{
    use RefreshDatabase;
    use SeedsPermissions;

    public function test_unauthenticated_requests_are_rejected(): void
    {
        $response = $this->getJson(route('api.customers.index'));

        $response->assertUnauthorized();
    }

    public function test_authenticated_admin_can_call_the_api_in_isolation_without_a_prior_web_request(): void
    {
        // Antes da correção, as Gates só eram registradas pelo middleware
        // AuthGates do grupo "web" — o grupo "api" nunca passava por ele,
        // então qualquer chamada de API (mesmo do Admin) recebia 403. Este
        // teste chama a API isoladamente (nenhuma requisição "web" antes)
        // para provar que a correção realmente resolveu isso.
        $this->seedPermissions();
        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        Sanctum::actingAs($admin, ['*']);

        $response = $this->getJson(route('api.customers.index'));

        $response->assertOk();
    }

    public function test_authenticated_user_without_the_permission_is_forbidden(): void
    {
        $this->seedPermissions();
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('api.customers.index'));

        $response->assertForbidden();
    }
}
