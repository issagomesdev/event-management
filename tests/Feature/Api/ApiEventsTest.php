<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\Concerns\SeedsPermissions;
use Tests\TestCase;

class ApiEventsTest extends TestCase
{
    use RefreshDatabase;
    use SeedsPermissions;

    private function actingAsApiAdmin(): User
    {
        $this->seedPermissions();
        $admin = User::factory()->create();
        $admin->roles()->sync([1]);
        Sanctum::actingAs($admin, ['*']);

        return $admin;
    }

    public function test_index_returns_events(): void
    {
        $this->actingAsApiAdmin();
        Event::factory()->count(2)->create();

        $response = $this->getJson(route('api.events.index'));

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    public function test_store_creates_an_event_and_returns_201(): void
    {
        $this->actingAsApiAdmin();

        $response = $this->postJson(route('api.events.store'), [
            'name' => 'Evento via API',
            'visualization' => '1',
            'type' => Event::TYPE_UNLIMITED,
            'allow_guests' => '1',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('events', ['name' => 'Evento via API']);
    }

    public function test_store_is_forbidden_without_event_create_permission(): void
    {
        $this->seedPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson(route('api.events.store'), ['name' => 'X']);

        $response->assertForbidden();
    }

    public function test_show_returns_a_single_event(): void
    {
        $this->actingAsApiAdmin();
        $event = Event::factory()->create();

        $response = $this->getJson(route('api.events.show', $event));

        $response->assertOk();
        $response->assertJsonPath('data.id', $event->id);
    }

    public function test_update_returns_202_and_persists_changes(): void
    {
        $this->actingAsApiAdmin();
        $event = Event::factory()->create(['name' => 'Nome Antigo']);

        $response = $this->putJson(route('api.events.update', $event), [
            'name' => 'Nome Novo',
            'visualization' => '1',
            'type' => Event::TYPE_UNLIMITED,
            'allow_guests' => '1',
        ]);

        $response->assertStatus(202);
        $this->assertDatabaseHas('events', ['id' => $event->id, 'name' => 'Nome Novo']);
    }

    public function test_destroy_returns_204_and_soft_deletes(): void
    {
        $this->actingAsApiAdmin();
        $event = Event::factory()->create();

        $response = $this->deleteJson(route('api.events.destroy', $event));

        $response->assertNoContent();
        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }
}
