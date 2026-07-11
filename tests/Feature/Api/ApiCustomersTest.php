<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\Concerns\SeedsPermissions;
use Tests\TestCase;

class ApiCustomersTest extends TestCase
{
    use RefreshDatabase;
    use SeedsPermissions;

    private function actingAsApiAdmin(): User
    {
        $this->seedPermissions();
        $admin = User::factory()->create();
        $admin->roles()->sync([1]);
        Sanctum::actingAs($admin, ['*']);

        return $admin;
    }

    public function test_store_creates_a_customer_and_returns_201(): void
    {
        $this->actingAsApiAdmin();

        $response = $this->postJson(route('api.customers.store'), [
            'name' => 'Felipe',
            'surname' => 'Nogueira',
            'phonenumber' => '5581977776666',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('customers', ['phonenumber' => '5581977776666']);
    }

    public function test_update_returns_202(): void
    {
        $this->actingAsApiAdmin();
        $customer = Customer::factory()->create();

        $response = $this->putJson(route('api.customers.update', $customer), [
            'name' => 'Atualizado',
            'surname' => $customer->surname,
            'phonenumber' => $customer->phonenumber,
        ]);

        $response->assertStatus(202);
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Atualizado']);
    }

    public function test_destroy_returns_204_and_soft_deletes(): void
    {
        $this->actingAsApiAdmin();
        $customer = Customer::factory()->create();

        $response = $this->deleteJson(route('api.customers.destroy', $customer));

        $response->assertNoContent();
        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }

    public function test_index_is_forbidden_without_customer_access_permission(): void
    {
        $this->seedPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $this->getJson(route('api.customers.index'))->assertForbidden();
    }
}
