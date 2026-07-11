<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ConfirmAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirms_attendance_for_the_cookie_identified_customer(): void
    {
        $event = Event::factory()->create(['type' => Event::TYPE_UNLIMITED, 'end' => now()->addDays(5)->format('d/m/Y')]);
        $customer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $customer->id)
            ->post(route('confirm.attendance.event', $event->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('customer_event', ['event_id' => $event->id, 'customer_id' => $customer->id]);
    }

    public function test_confirming_twice_does_not_create_a_duplicate_row(): void
    {
        $event = Event::factory()->create(['type' => Event::TYPE_UNLIMITED, 'end' => now()->addDays(5)->format('d/m/Y')]);
        $customer = Customer::factory()->create();

        $this->withCookie('userID', (string) $customer->id)->post(route('confirm.attendance.event', $event->id));
        $this->withCookie('userID', (string) $customer->id)->post(route('confirm.attendance.event', $event->id));

        $this->assertSame(1, DB::table('customer_event')
            ->where('event_id', $event->id)->where('customer_id', $customer->id)->count());
    }

    public function test_rejects_confirmation_for_a_closed_event(): void
    {
        $event = Event::factory()->create(['end' => now()->subDay()->format('d/m/Y')]);
        $customer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $customer->id)
            ->post(route('confirm.attendance.event', $event->id));

        $response->assertSessionHas('error', 'Este evento já encerrou!');
        $this->assertDatabaseMissing('customer_event', ['event_id' => $event->id, 'customer_id' => $customer->id]);
    }

    public function test_rejects_confirmation_when_a_limited_event_is_full(): void
    {
        $event = Event::factory()->create([
            'type' => Event::TYPE_LIMITED,
            'capacity' => 1,
            'end' => now()->addDays(5)->format('d/m/Y'),
        ]);
        $existingAttendee = Customer::factory()->create();
        DB::table('customer_event')->insert(['event_id' => $event->id, 'customer_id' => $existingAttendee->id]);

        $newCustomer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $newCustomer->id)
            ->post(route('confirm.attendance.event', $event->id));

        $response->assertSessionHas('error', 'Este evento atingiu sua capacidade máxima!');
        $this->assertDatabaseMissing('customer_event', ['event_id' => $event->id, 'customer_id' => $newCustomer->id]);
    }

    public function test_unlimited_event_never_blocks_on_capacity(): void
    {
        $event = Event::factory()->create([
            'type' => Event::TYPE_UNLIMITED,
            'capacity' => null,
            'end' => now()->addDays(5)->format('d/m/Y'),
        ]);
        $customer = Customer::factory()->create();

        $response = $this->withCookie('userID', (string) $customer->id)
            ->post(route('confirm.attendance.event', $event->id));

        $response->assertSessionHas('success');
    }

    public function test_confirming_with_a_new_phone_number_creates_a_customer_and_sets_the_cookie(): void
    {
        $event = Event::factory()->create(['type' => Event::TYPE_UNLIMITED, 'end' => now()->addDays(5)->format('d/m/Y')]);

        $response = $this->post(route('confirm.attendance.event', $event->id), [
            'name' => 'João',
            'surname' => 'Pedro',
            'phonenumber' => '5581999998888',
        ]);

        $response->assertCookie('userID');
        $this->assertDatabaseHas('customers', ['phonenumber' => '5581999998888']);
        $this->assertDatabaseHas('customer_event', ['event_id' => $event->id]);
    }

    public function test_confirming_with_a_known_phone_number_updates_that_customers_name(): void
    {
        $event = Event::factory()->create(['type' => Event::TYPE_UNLIMITED, 'end' => now()->addDays(5)->format('d/m/Y')]);
        $customer = Customer::factory()->create(['phonenumber' => '5581999997777', 'name' => 'Nome Antigo']);

        $this->post(route('confirm.attendance.event', $event->id), [
            'name' => 'Nome Novo',
            'surname' => 'Sobrenome Novo',
            'phonenumber' => '5581999997777',
        ]);

        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Nome Novo']);
    }

    public function test_without_cookie_or_phonenumber_redirects_to_details_with_login_modal_flag(): void
    {
        $event = Event::factory()->create();

        $response = $this->post(route('confirm.attendance.event', $event->id));

        $response->assertRedirect(route('site.event.details', [
            'id' => $event->id,
            'name' => str_replace(' ', '-', $event->name),
            'login_model' => true,
        ]));
    }

    public function test_returns_404_for_a_non_existent_event(): void
    {
        $response = $this->withCookie('userID', '1')->post(route('confirm.attendance.event', 999999));

        $response->assertNotFound();
    }
}
