<?php

namespace Database\Factories;

use App\Models\Event;
use App\Support\Seeding\AddressCatalog;
use App\Support\Seeding\EventDescriptionGenerator;
use App\Support\Seeding\EventRulesGenerator;
use App\Support\Seeding\LinkInstructionGenerator;
use App\Support\Seeding\WhatsappGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define campos estruturais padrão. Nome, descrição, regras, datas,
     * tipo/capacidade, endereço e mídia costumam ser sobrescritos pelos
     * seeders a partir do EventCatalog — a factory garante que o modelo
     * também seja válido sozinho (ex.: em testes).
     */
    public function definition(): array
    {
        $whatsapp = new WhatsappGenerator();
        $address = (new AddressCatalog())->random();
        $start = Carbon::now()->addDays(fake()->numberBetween(1, 300));

        return [
            'name' => 'Evento '.fake()->unique()->words(2, true),
            'description' => (new EventDescriptionGenerator())->generate('este evento', 'social'),
            'rules' => (new EventRulesGenerator())->generate(),
            'link' => 'https://byissa.dev/',
            'link_instruction' => (new LinkInstructionGenerator())->random(),
            'pixel' => null,
            'visualization' => 1,
            'type' => Event::TYPE_UNLIMITED,
            'allow_guests' => 1,
            'capacity' => null,
            'whatsapp' => $whatsapp->number(),
            'whatsappmessage' => $whatsapp->eventMessage(),
            'whatsapp_help' => $whatsapp->number(),
            'start' => $start->format('d/m/Y'),
            'end' => $start->copy()->addHours(6)->format('d/m/Y'),
            'start_time' => '19:00:00',
            'end_time' => '23:00:00',
            'cep' => $address['cep'],
            'state' => $address['state'],
            'city' => $address['city'],
            'neighborhood' => $address['neighborhood'],
            'street' => $address['street'],
            'number' => $address['number'],
        ];
    }
}
