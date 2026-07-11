<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_form_renders_for_a_visitor_without_a_cookie(): void
    {
        $response = $this->get(route('customers.register'));

        $response->assertOk();
        $response->assertViewIs('public.customer-form');
        $response->assertViewHas('register', true);
    }

    public function test_register_form_redirects_home_when_already_identified_by_cookie(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $customer->id)->get(route('customers.register'));

        $response->assertRedirect(route('site.home'));
    }

    public function test_store_creates_a_customer_and_sets_the_identification_cookie(): void
    {
        $response = $this->post(route('customers.store'), [
            'name' => 'Ana',
            'surname' => 'Clara',
            'phonenumber' => '5581999990000',
            'birthdate' => '10/05/1998',
        ]);

        $response->assertRedirect(route('site.home'));
        $response->assertCookie('userID');
        $this->assertDatabaseHas('customers', ['phonenumber' => '5581999990000', 'name' => 'Ana']);
    }

    public function test_store_requires_name_surname_and_phonenumber(): void
    {
        $response = $this->post(route('customers.store'), []);

        $response->assertSessionHasErrors(['name', 'surname', 'phonenumber']);
    }

    public function test_store_rejects_a_duplicate_phone_number(): void
    {
        Customer::factory()->create(['phonenumber' => '5581999990000']);

        $response = $this->post(route('customers.store'), [
            'name' => 'Outro',
            'surname' => 'Cliente',
            'phonenumber' => '5581999990000',
        ]);

        $response->assertSessionHasErrors('phonenumber');
    }

    public function test_store_rejects_a_birthdate_in_the_wrong_format(): void
    {
        $response = $this->post(route('customers.store'), [
            'name' => 'Ana',
            'surname' => 'Clara',
            'phonenumber' => '5581999990001',
            'birthdate' => '1998-05-10',
        ]);

        $response->assertSessionHasErrors('birthdate');
    }
}
