<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_birthdate_round_trips_through_d_m_y_format(): void
    {
        $customer = Customer::factory()->create(['birthdate' => '15/03/1995']);

        $this->assertSame('15/03/1995', $customer->birthdate);
        $this->assertSame('1995-03-15', $customer->getRawOriginal('birthdate'));
    }

    public function test_email_is_optional(): void
    {
        $customer = Customer::create([
            'name' => 'Parker',
            'surname' => 'Mason',
            'phonenumber' => '5585677567867',
        ]);

        $this->assertNull($customer->email);
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'email' => null]);
    }

    public function test_has_customer_returns_id_when_phone_number_matches(): void
    {
        $customer = Customer::factory()->create(['phonenumber' => '5581999998888']);

        $this->assertSame($customer->id, (new Customer())->hasCustomer('5581999998888'));
    }

    public function test_has_customer_returns_false_without_throwing_when_not_found(): void
    {
        $this->assertFalse((new Customer())->hasCustomer('0000000000000'));
    }

    public function test_guests_returns_rows_scoped_to_event_and_customer(): void
    {
        $customer = Customer::factory()->create();
        $event = Event::factory()->create();
        DB::table('customer_event_guests')->insert([
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'guest' => 'Carlos Henrique',
        ]);

        $guests = (new Customer())->guests($customer->id, $event->id);

        $this->assertTrue($guests->keys()->contains('Carlos Henrique'));
    }

    public function test_attendance_list_events_relationship(): void
    {
        $customer = Customer::factory()->create();
        $event = Event::factory()->create();
        $event->attendance_lists()->attach($customer->id);

        $this->assertTrue($customer->attendanceListEvents()->where('events.id', $event->id)->exists());
    }
}
