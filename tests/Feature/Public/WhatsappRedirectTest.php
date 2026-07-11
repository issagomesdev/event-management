<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsappRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirects_to_wa_me_with_the_given_number_and_message(): void
    {
        $response = $this->post(route('redirect.whatsapp'), [
            'whatsapp' => '5581999998888',
            'message' => 'Olá',
        ]);

        $response->assertRedirect('https://wa.me/5581999998888?text=Olá');
    }

    public function test_requires_a_post_request(): void
    {
        $response = $this->get(route('redirect.whatsapp'));

        $response->assertMethodNotAllowed();
    }
}
