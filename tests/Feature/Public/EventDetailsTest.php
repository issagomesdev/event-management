<?php

namespace Tests\Feature\Public;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EventDetailsTest extends TestCase
{
    use RefreshDatabase;

    private function url(Event $event): string
    {
        return route('site.event.details', ['id' => $event->id, 'name' => str_replace(' ', '-', $event->name)]);
    }

    public function test_public_event_details_page_loads(): void
    {
        $event = Event::factory()->create(['visualization' => '1']);

        $response = $this->get($this->url($event));

        $response->assertOk();
        $response->assertViewIs('public.events.details');
    }

    public function test_returns_404_for_a_non_existent_event(): void
    {
        $response = $this->get(route('site.event.details', ['id' => 999999, 'name' => 'inexistente']));

        $response->assertNotFound();
    }

    public function test_private_event_is_still_reachable_via_direct_link(): void
    {
        // "Privado" só remove o evento da listagem pública — não existe
        // convite/ACL no sistema, então o link direto continua funcionando.
        $event = Event::factory()->create(['visualization' => '0']);

        $response = $this->get($this->url($event));

        $response->assertOk();
    }

    public function test_event_without_end_date_does_not_crash_and_is_treated_as_open(): void
    {
        $event = Event::factory()->create(['end' => null]);

        $response = $this->get($this->url($event));

        $response->assertOk();
        $response->assertViewHas('open', true);
    }

    public function test_shows_check_in_state_for_the_cookie_identified_customer(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        DB::table('customer_event')->insert([
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'checkin' => 1,
        ]);

        $response = $this->withCookie('userID', (string) $customer->id)->get($this->url($event));

        $response->assertOk();
        $response->assertViewHas('attendance', true);
        $response->assertViewHas('isChecked', 1);
    }
}
