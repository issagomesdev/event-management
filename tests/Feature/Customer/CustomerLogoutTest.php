<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_forgets_the_identification_cookie_and_redirects_home(): void
    {
        $response = $this->withCookie('userID', '1')->get(route('customers.logout'));

        $response->assertRedirect(route('site.home'));
        $response->assertCookieExpired('userID');
    }
}
