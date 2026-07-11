<?php

namespace Tests\Feature\Admin\Events;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class EventCheckinTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_checkin_view_requires_event_show_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $event = Event::factory()->create();

        $this->get(route('admin.events.checkin', $event->id))->assertForbidden();
    }

    public function test_checkin_view_renders_with_permission(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create();

        $this->get(route('admin.events.checkin', $event->id))->assertOk();
    }

    public function test_to_check_in_requires_event_show_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $event->attendance_lists()->attach($customer->id);

        $response = $this->post(route('admin.events.toCheckIn', [
            'id' => $customer->id, 'eventID' => $event->id, 'action' => 1, 'type' => 0,
        ]));

        $response->assertForbidden();
    }

    public function test_to_check_in_toggles_the_attendee_check_in_flag(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $event->attendance_lists()->attach($customer->id);

        $response = $this->post(route('admin.events.toCheckIn', [
            'id' => $customer->id, 'eventID' => $event->id, 'action' => 1, 'type' => 0,
        ]));

        $response->assertOk();
        $this->assertDatabaseHas('customer_event', [
            'event_id' => $event->id, 'customer_id' => $customer->id, 'checkin' => 1,
        ]);
    }

    public function test_to_check_in_updates_a_guest_row_when_type_is_1(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $guestID = \Illuminate\Support\Facades\DB::table('customer_event_guests')->insertGetId([
            'event_id' => $event->id, 'customer_id' => $customer->id, 'guest' => 'Convidado',
        ]);

        $response = $this->post(route('admin.events.toCheckIn', [
            'id' => $guestID, 'eventID' => $event->id, 'action' => 1, 'type' => 1,
        ]));

        $response->assertOk();
        $this->assertDatabaseHas('customer_event_guests', ['id' => $guestID, 'checkin' => 1]);
    }
}
