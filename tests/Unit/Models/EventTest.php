<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_start_and_end_dates_round_trip_through_d_m_y_format(): void
    {
        $event = Event::factory()->create([
            'start' => '25/12/2026',
            'end' => '26/12/2026',
        ]);

        $this->assertSame('25/12/2026', $event->start);
        $this->assertSame('26/12/2026', $event->end);
        $this->assertSame('2026-12-25', $event->getRawOriginal('start'));
    }

    public function test_start_time_accessor_prefixes_as_and_formats_hi(): void
    {
        $event = Event::factory()->create(['start_time' => '19:30:00']);

        $this->assertSame('ás 19:30', $event->start_time);
    }

    public function test_start_time_accessor_returns_null_when_not_set(): void
    {
        $event = Event::factory()->create(['start_time' => null]);

        $this->assertNull($event->start_time);
    }

    public function test_type_constants_match_radio_options(): void
    {
        $this->assertSame('0', Event::TYPE_LIMITED);
        $this->assertSame('1', Event::TYPE_UNLIMITED);
        $this->assertSame(['1' => 'Ilimitado', '0' => 'Limitado'], Event::TYPE_RADIO);
        $this->assertSame(['1' => 'Público', '0' => 'Privado'], Event::VISUALIZATION_RADIO);
        $this->assertSame(['1' => 'Sim', '0' => 'Não'], Event::ALLOW_GUESTS_RADIO);
    }

    public function test_attendance_lists_relationship_returns_confirmed_customers(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();

        $event->attendance_lists()->attach($customer->id);

        $this->assertTrue($event->attendance_lists()->where('customers.id', $customer->id)->exists());
    }

    public function test_attendance_returns_true_only_when_a_confirmation_row_exists(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();

        $this->assertFalse($event->attendance($event->id, $customer->id));

        DB::table('customer_event')->insert(['event_id' => $event->id, 'customer_id' => $customer->id]);

        $this->assertTrue($event->attendance($event->id, $customer->id));
    }

    public function test_guests_returns_rows_for_the_given_event_and_customer(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();

        DB::table('customer_event_guests')->insert([
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'guest' => 'João Pedro',
        ]);

        $guests = $event->guests($event->id, $customer->id);

        $this->assertCount(1, $guests);
        $this->assertSame('João Pedro', $guests->first()->guest);
    }

    public function test_attendance_count_sums_attendees_and_guests(): void
    {
        $event = Event::factory()->create();
        $customers = Customer::factory()->count(2)->create();

        DB::table('customer_event')->insert([
            ['event_id' => $event->id, 'customer_id' => $customers[0]->id],
            ['event_id' => $event->id, 'customer_id' => $customers[1]->id],
        ]);
        DB::table('customer_event_guests')->insert([
            'event_id' => $event->id,
            'customer_id' => $customers[0]->id,
            'guest' => 'Convidado 1',
        ]);

        $this->assertSame(3, $event->attendanceCount($event->id));
    }

    public function test_attendance_count_is_zero_for_event_with_no_attendees(): void
    {
        $event = Event::factory()->create();

        $this->assertSame(0, $event->attendanceCount($event->id));
    }

    public function test_attendance_check_in_count_only_counts_checked_in_rows(): void
    {
        $event = Event::factory()->create();
        $customers = Customer::factory()->count(2)->create();

        DB::table('customer_event')->insert([
            ['event_id' => $event->id, 'customer_id' => $customers[0]->id, 'checkin' => 1],
            ['event_id' => $event->id, 'customer_id' => $customers[1]->id, 'checkin' => 0],
        ]);
        DB::table('customer_event_guests')->insert([
            'event_id' => $event->id,
            'customer_id' => $customers[0]->id,
            'guest' => 'Convidado 1',
            'checkin' => 1,
        ]);

        $this->assertSame(2, $event->attendanceCheckInCount($event->id));
    }

    public function test_attendance_list_attaches_checkin_and_guests_to_each_attendee(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $event->attendance_lists()->attach($customer->id, ['checkin' => 1]);
        DB::table('customer_event_guests')->insert([
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'guest' => 'Maria Eduarda',
        ]);

        $list = $event->attendanceList($event->id);

        $this->assertCount(1, $list);
        $this->assertEquals(1, $list->first()->checkin);
        $this->assertCount(1, $list->first()->guests);
    }

    public function test_attendance_list_is_empty_collection_for_event_with_no_attendees(): void
    {
        $event = Event::factory()->create();

        $list = $event->attendanceList($event->id);

        $this->assertCount(0, $list);
    }

    public function test_attendance_list_full_flattens_customers_and_guests_with_type_flags(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create(['name' => 'Ana', 'surname' => 'Clara']);
        $event->attendance_lists()->attach($customer->id, ['checkin' => 1]);
        DB::table('customer_event_guests')->insert([
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'guest' => 'Convidado X',
            'checkin' => 0,
        ]);

        $full = $event->attendanceListFull($event->id);

        $this->assertCount(2, $full);
        $this->assertSame(0, $full[0]->type);
        $this->assertSame('Ana Clara', $full[0]->name);
        $this->assertSame(1, $full[1]->type);
        $this->assertSame('Convidado X', $full[1]->name);
        $this->assertSame($customer->id, $full[1]->customerID);
    }

    public function test_registered_media_collections_accept_multiple_photos_and_a_single_cover(): void
    {
        Storage::fake('public');
        $event = Event::factory()->create();

        $event->addMedia(UploadedFile::fake()->image('a.jpg'))->preservingOriginal()->toMediaCollection('photo');
        $event->addMedia(UploadedFile::fake()->image('b.jpg'))->preservingOriginal()->toMediaCollection('photo');
        $event->addMedia(UploadedFile::fake()->image('cover1.jpg'))->preservingOriginal()->toMediaCollection('cover');
        $event->addMedia(UploadedFile::fake()->image('cover2.jpg'))->preservingOriginal()->toMediaCollection('cover');

        $this->assertCount(2, $event->fresh()->getMedia('photo'));
        $this->assertCount(1, $event->fresh()->getMedia('cover'));
    }
}
