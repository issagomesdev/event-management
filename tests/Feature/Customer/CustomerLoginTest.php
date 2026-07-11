<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_form_renders_for_a_visitor_without_a_cookie(): void
    {
        $response = $this->get(route('customers.login'));

        $response->assertOk();
        $response->assertViewIs('public.customer-form');
        $response->assertViewHas('register', false);
    }

    public function test_login_form_redirects_home_when_already_identified_by_cookie(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $customer->id)->get(route('customers.login'));

        $response->assertRedirect(route('site.home'));
    }

    public function test_verify_customer_logs_in_an_existing_phone_number(): void
    {
        $customer = Customer::factory()->create(['phonenumber' => '5581999990000']);

        $response = $this->post(route('customers.verifyCustomer'), [
            'phonenumber' => '5581999990000',
        ]);

        $response->assertRedirect(route('site.home'));
        $response->assertCookie('userID', (string) $customer->id);
    }

    public function test_verify_customer_redirects_to_register_when_phone_is_unknown(): void
    {
        $response = $this->post(route('customers.verifyCustomer'), [
            'phonenumber' => '5581900000000',
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString(route('customers.register'), $response->headers->get('Location'));
        $this->assertStringContainsString('phonenumber=5581900000000', $response->headers->get('Location'));
    }
}
