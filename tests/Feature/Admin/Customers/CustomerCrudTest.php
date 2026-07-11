<?php

namespace Tests\Feature\Admin\Customers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class CustomerCrudTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Beatriz',
            'surname' => 'Ferreira',
            'phonenumber' => '5581988887777',
            'birthdate' => '01/01/1990',
        ], $overrides);
    }

    public function test_index_requires_customer_access_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.customers.index'))->assertForbidden();
    }

    public function test_index_is_reachable_with_permission(): void
    {
        $this->actingAsAdmin();

        $this->get(route('admin.customers.index'))->assertOk();
    }

    public function test_store_creates_a_customer(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.customers.store'), $this->payload());

        $response->assertRedirect(route('admin.customers.index'));
        $this->assertDatabaseHas('customers', ['phonenumber' => '5581988887777']);
    }

    public function test_store_rejects_a_duplicate_phone_number(): void
    {
        $this->actingAsAdmin();
        Customer::factory()->create(['phonenumber' => '5581988887777']);

        $response = $this->post(route('admin.customers.store'), $this->payload());

        $response->assertSessionHasErrors('phonenumber');
    }

    public function test_show_requires_customer_show_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $customer = Customer::factory()->create();

        $this->get(route('admin.customers.show', $customer))->assertForbidden();
    }

    public function test_update_allows_saving_without_changing_the_phone_number(): void
    {
        $this->actingAsAdmin();
        $customer = Customer::factory()->create(['phonenumber' => '5581988887777', 'name' => 'Antigo']);

        $response = $this->put(route('admin.customers.update', $customer), $this->payload(['name' => 'Novo']));

        $response->assertRedirect(route('admin.customers.index'));
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Novo', 'phonenumber' => '5581988887777']);
    }

    public function test_update_still_rejects_a_phone_number_belonging_to_another_customer(): void
    {
        $this->actingAsAdmin();
        Customer::factory()->create(['phonenumber' => '5581900001111']);
        $customer = Customer::factory()->create(['phonenumber' => '5581988887777']);

        $response = $this->put(route('admin.customers.update', $customer), $this->payload(['phonenumber' => '5581900001111']));

        $response->assertSessionHasErrors('phonenumber');
    }

    public function test_destroy_soft_deletes_the_customer(): void
    {
        $this->actingAsAdmin();
        $customer = Customer::factory()->create();

        $this->delete(route('admin.customers.destroy', $customer));

        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }

    public function test_mass_destroy_requires_customer_delete_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $customers = Customer::factory()->count(2)->create();

        $response = $this->delete(route('admin.customers.massDestroy'), [
            'ids' => $customers->pluck('id')->toArray(),
        ]);

        $response->assertForbidden();
    }
}
