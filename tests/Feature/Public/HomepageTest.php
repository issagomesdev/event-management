<?php

namespace Tests\Feature\Public;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('public.index');
    }

    public function test_homepage_lists_only_public_events_that_have_not_ended(): void
    {
        $visible = Event::factory()->create([
            'name' => 'Evento Visível',
            'visualization' => '1',
            'start' => now()->addDay()->format('d/m/Y'),
            'end' => now()->addDays(2)->format('d/m/Y'),
        ]);

        $private = Event::factory()->create([
            'name' => 'Evento Privado',
            'visualization' => '0',
            'start' => now()->addDay()->format('d/m/Y'),
            'end' => now()->addDays(2)->format('d/m/Y'),
        ]);

        $expired = Event::factory()->create([
            'name' => 'Evento Encerrado',
            'visualization' => '1',
            'start' => now()->subDays(5)->format('d/m/Y'),
            'end' => now()->subDay()->format('d/m/Y'),
        ]);

        $response = $this->get('/');

        $response->assertViewHas('events', function ($events) use ($visible, $private, $expired) {
            return $events->contains('id', $visible->id)
                && ! $events->contains('id', $private->id)
                && ! $events->contains('id', $expired->id);
        });
    }
}
