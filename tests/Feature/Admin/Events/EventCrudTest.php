<?php

namespace Tests\Feature\Admin\Events;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Festival de Testes',
            'start' => now()->addDays(10)->format('d/m/Y'),
            'end' => now()->addDays(11)->format('d/m/Y'),
            'link' => 'https://byissa.dev/',
            'visualization' => '1',
            'type' => Event::TYPE_UNLIMITED,
            'allow_guests' => '1',
        ], $overrides);
    }

    public function test_index_requires_event_access_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.events.index'))->assertForbidden();
    }

    public function test_index_is_reachable_with_permission(): void
    {
        $this->actingAsAdmin();

        $this->get(route('admin.events.index'))->assertOk();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.events.index'))->assertRedirect(route('login'));
    }

    public function test_store_creates_an_event(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.events.store'), $this->payload(['name' => 'Sunset Premium']));

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['name' => 'Sunset Premium']);
    }

    public function test_store_is_forbidden_without_event_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $response = $this->post(route('admin.events.store'), $this->payload());

        $response->assertForbidden();
        $this->assertDatabaseMissing('events', ['name' => 'Festival de Testes']);
    }

    public function test_store_requires_a_name(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.events.store'), $this->payload(['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    public function test_store_requires_capacity_when_the_event_is_limited(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.events.store'), $this->payload([
            'type' => Event::TYPE_LIMITED,
            'capacity' => null,
        ]));

        $response->assertSessionHasErrors('capacity');
    }

    public function test_store_accepts_a_limited_event_with_capacity(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.events.store'), $this->payload([
            'type' => Event::TYPE_LIMITED,
            'capacity' => 20,
        ]));

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['type' => Event::TYPE_LIMITED, 'capacity' => 20]);
    }

    public function test_store_validates_the_cep_format(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.events.store'), $this->payload(['cep' => 'not-a-cep']));

        $response->assertSessionHasErrors('cep');
    }

    public function test_store_validates_state_against_the_uf_list(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.events.store'), $this->payload(['state' => 'ZZ']));

        $response->assertSessionHasErrors('state');
    }

    public function test_show_displays_the_event(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create();

        $this->get(route('admin.events.show', $event))->assertOk();
    }

    public function test_show_is_forbidden_without_event_show_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $event = Event::factory()->create();

        $this->get(route('admin.events.show', $event))->assertForbidden();
    }

    public function test_edit_form_renders(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create();

        $this->get(route('admin.events.edit', $event))->assertOk();
    }

    public function test_update_changes_event_fields(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create(['name' => 'Nome Antigo']);

        $response = $this->put(route('admin.events.update', $event), $this->payload(['name' => 'Nome Novo']));

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['id' => $event->id, 'name' => 'Nome Novo']);
    }

    public function test_update_is_forbidden_without_event_edit_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $event = Event::factory()->create(['name' => 'Nome Antigo']);

        $response = $this->put(route('admin.events.update', $event), $this->payload());

        $response->assertForbidden();
        $this->assertDatabaseHas('events', ['id' => $event->id, 'name' => 'Nome Antigo']);
    }

    public function test_destroy_soft_deletes_the_event(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create();

        $this->delete(route('admin.events.destroy', $event))->assertRedirect();

        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }

    public function test_destroy_is_forbidden_without_event_delete_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $event = Event::factory()->create();

        $this->delete(route('admin.events.destroy', $event))->assertForbidden();
        $this->assertDatabaseHas('events', ['id' => $event->id, 'deleted_at' => null]);
    }

    public function test_mass_destroy_soft_deletes_multiple_events(): void
    {
        $this->actingAsAdmin();
        $events = Event::factory()->count(3)->create();

        $response = $this->delete(route('admin.events.massDestroy'), [
            'ids' => $events->pluck('id')->toArray(),
        ]);

        $response->assertNoContent();
        foreach ($events as $event) {
            $this->assertSoftDeleted('events', ['id' => $event->id]);
        }
    }

    public function test_mass_destroy_is_forbidden_without_event_delete_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $events = Event::factory()->count(2)->create();

        $response = $this->delete(route('admin.events.massDestroy'), [
            'ids' => $events->pluck('id')->toArray(),
        ]);

        $response->assertForbidden();
    }
}
