<?php

namespace Tests\Integration;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class AttendanceCapacityTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_full_pipeline_confirm_capacity_checkin_and_admin_dashboard_count(): void
    {
        $event = Event::factory()->create([
            'type' => Event::TYPE_LIMITED,
            'capacity' => 2,
            'visualization' => '1',
            'end' => now()->addDays(5)->format('d/m/Y'),
        ]);

        $customers = Customer::factory()->count(3)->create();

        // Os dois primeiros confirmam presença normalmente.
        foreach ($customers->take(2) as $customer) {
            $this->withCookie('userID', (string) $customer->id)
                ->post(route('confirm.attendance.event', $event->id))
                ->assertSessionHas('success');
        }

        // O terceiro esbarra na capacidade máxima.
        $this->withCookie('userID', (string) $customers[2]->id)
            ->post(route('confirm.attendance.event', $event->id))
            ->assertSessionHas('error', 'Este evento atingiu sua capacidade máxima!');

        $this->assertSame(2, (new Event())->attendanceCount($event->id));

        // Um convidado se soma à contagem, mas não reabre vaga para outro attendee.
        $this->withCookie('userID', (string) $customers[0]->id)
            ->post(route('add.guest.event', ['eventID' => $event->id, 'customerID' => $customers[0]->id]), [
                'name' => 'Convidado Extra',
            ])->assertOk();

        $this->assertSame(3, (new Event())->attendanceCount($event->id));

        // Admin faz o check-in de um participante.
        $this->actingAsAdmin();
        $this->post(route('admin.events.toCheckIn', [
            'id' => $customers[0]->id, 'eventID' => $event->id, 'action' => 1, 'type' => 0,
        ]))->assertOk();

        $this->assertSame(1, (new Event())->attendanceCheckInCount($event->id));

        // O painel reflete os mesmos números.
        $dashboard = $this->get(route('admin.home'));
        $dashboard->assertViewHas('events', function ($events) use ($event) {
            $found = $events->firstWhere('id', $event->id);

            return $found && $found->invited === 3 && $found->checkIn === 1;
        });
    }
}
