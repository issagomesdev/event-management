<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GuestManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_identified_customer_can_add_a_guest_to_themselves(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $customer->id)
            ->post(route('add.guest.event', ['eventID' => $event->id, 'customerID' => $customer->id]), [
                'name' => 'Carlos Henrique',
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['message', 'guestID']);
        $this->assertDatabaseHas('customer_event_guests', [
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'guest' => 'Carlos Henrique',
        ]);
    }

    public function test_cannot_add_a_guest_on_behalf_of_another_customer(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $someoneElse = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $someoneElse->id)
            ->post(route('add.guest.event', ['eventID' => $event->id, 'customerID' => $customer->id]), [
                'name' => 'Convidado Indevido',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('customer_event_guests', ['event_id' => $event->id, 'guest' => 'Convidado Indevido']);
    }

    public function test_cannot_add_a_guest_without_the_identification_cookie(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->post(route('add.guest.event', ['eventID' => $event->id, 'customerID' => $customer->id]), [
            'name' => 'Sem Cookie',
        ]);

        $response->assertForbidden();
    }

    public function test_adding_a_guest_with_a_duplicate_name_does_not_create_a_second_row_or_return_a_guest_id(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        DB::table('customer_event_guests')->insert([
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'guest' => 'Maria Eduarda',
        ]);

        $response = $this->withCookie('userID', (string) $customer->id)
            ->post(route('add.guest.event', ['eventID' => $event->id, 'customerID' => $customer->id]), [
                'name' => 'Maria Eduarda',
            ]);

        $response->assertOk();
        $response->assertJsonMissing(['guestID' => true]);
        $this->assertSame(1, DB::table('customer_event_guests')
            ->where('event_id', $event->id)->where('guest', 'Maria Eduarda')->count());
    }

    public function test_the_owning_customer_can_delete_their_guest(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $guestID = DB::table('customer_event_guests')->insertGetId([
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'guest' => 'Convidado',
        ]);

        $response = $this->withCookie('userID', (string) $customer->id)
            ->post(route('delete.guest.event', $guestID));

        $response->assertOk();
        $this->assertDatabaseMissing('customer_event_guests', ['id' => $guestID]);
    }

    public function test_cannot_delete_a_guest_belonging_to_another_customer(): void
    {
        $event = Event::factory()->create();
        $owner = Customer::factory()->create();
        $someoneElse = Customer::factory()->create();
        $guestID = DB::table('customer_event_guests')->insertGetId([
            'event_id' => $event->id,
            'customer_id' => $owner->id,
            'guest' => 'Convidado',
        ]);

        $response = $this->withCookie('userID', (string) $someoneElse->id)
            ->post(route('delete.guest.event', $guestID));

        $response->assertForbidden();
        $this->assertDatabaseHas('customer_event_guests', ['id' => $guestID]);
    }

    public function test_deleting_a_non_existent_guest_returns_404(): void
    {
        $response = $this->withCookie('userID', '1')->post(route('delete.guest.event', 999999));

        $response->assertNotFound();
    }

    public function test_save_guests_endpoint_is_a_documented_no_op(): void
    {
        // saveGuests() tem o corpo comentado — não grava nada. Este teste
        // trava esse comportamento atual como regressão conhecida.
        $event = Event::factory()->create(['type' => Event::TYPE_UNLIMITED, 'end' => now()->addDays(5)->format('d/m/Y')]);
        $customer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $customer->id)
            ->post(route('save.guests.event', $event->id), [
                'guests' => json_encode([['name' => 'Alguém']]),
            ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('customer_event_guests', ['event_id' => $event->id, 'guest' => 'Alguém']);
    }
}
