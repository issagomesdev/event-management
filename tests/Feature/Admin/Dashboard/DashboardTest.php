<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_dashboard_loads_for_any_authenticated_user_regardless_of_permissions(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.home'))->assertOk();
    }

    public function test_dashboard_requires_authentication(): void
    {
        $this->get(route('admin.home'))->assertRedirect(route('login'));
    }

    public function test_dashboard_reports_invited_and_check_in_counts_per_event(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create(['visualization' => '1', 'end' => now()->addDays(3)->format('d/m/Y')]);
        $customer = Customer::factory()->create();
        DB::table('customer_event')->insert(['event_id' => $event->id, 'customer_id' => $customer->id, 'checkin' => 1]);

        $response = $this->get(route('admin.home'));

        $response->assertOk();
        $response->assertViewHas('events', function ($events) use ($event) {
            $found = $events->firstWhere('id', $event->id);

            return $found && $found->invited === 1 && $found->checkIn === 1;
        });
    }
}
