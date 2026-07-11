<?php

namespace Tests\Feature\Public;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventListCheckinPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_without_credentials_shows_the_password_protect_view(): void
    {
        $event = Event::factory()->create();

        $response = $this->get(route('site.event.list', ['id' => $event->id, 'name' => 'x']));

        $response->assertOk();
        $response->assertViewIs('public.events.password-protect');
    }

    public function test_list_with_wrong_credentials_shows_password_protect_with_error(): void
    {
        $event = Event::factory()->create();

        $response = $this->get(route('site.event.list', ['id' => $event->id, 'name' => 'x']) . '?user=wrong&password=wrong');

        $response->assertOk();
        $response->assertViewIs('public.events.password-protect');
        $response->assertSessionHas('error');
    }

    public function test_list_with_correct_credentials_shows_the_real_list(): void
    {
        $event = Event::factory()->create();

        $url = route('site.event.list', ['id' => $event->id, 'name' => 'x'])
            . '?user=Listinhagjota&password=gjotalistinha05';

        $response = $this->get($url);

        $response->assertOk();
        $response->assertViewIs('public.events.list');
    }

    public function test_checkin_view_requires_the_same_credentials(): void
    {
        $event = Event::factory()->create();

        $this->get(route('site.event.checkin', ['id' => $event->id, 'name' => 'x']))
            ->assertViewIs('public.events.password-protect');

        $url = route('site.event.checkin', ['id' => $event->id, 'name' => 'x'])
            . '?user=Listinhagjota&password=gjotalistinha05';

        $this->get($url)->assertViewIs('public.events.checkin');
    }

    public function test_public_check_in_toggle_requires_the_shared_password_too(): void
    {
        $event = Event::factory()->create();
        $customer = \App\Models\Customer::factory()->create();
        $event->attendance_lists()->attach($customer->id);

        $withoutCreds = $this->postJson(route('site.events.toCheckIn', [
            'id' => $customer->id,
            'eventID' => $event->id,
            'action' => 1,
            'type' => 0,
        ]));

        $withoutCreds->assertOk();
        $this->assertDatabaseMissing('customer_event', [
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'checkin' => 1,
        ]);

        $withCreds = $this->post(route('site.events.toCheckIn', [
            'id' => $customer->id,
            'eventID' => $event->id,
            'action' => 1,
            'type' => 0,
        ]) . '?user=Listinhagjota&password=gjotalistinha05');

        $withCreds->assertOk();
        $this->assertDatabaseHas('customer_event', [
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'checkin' => 1,
        ]);
    }
}
