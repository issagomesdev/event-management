<?php

namespace Database\Seeders\Concerns;

use App\Models\Event;
use App\Support\Seeding\AddressCatalog;
use App\Support\Seeding\EventCatalog;
use App\Support\Seeding\EventDescriptionGenerator;
use App\Support\Seeding\EventMediaSelector;
use App\Support\Seeding\EventRulesGenerator;
use App\Support\Seeding\LinkInstructionGenerator;
use App\Support\Seeding\WhatsappGenerator;
use Carbon\Carbon;

/**
 * Lógica compartilhada entre EventSeeder e CurrentMonthEventSeeder: cria
 * eventos a partir de entradas do EventCatalog (nome/mês/categoria/tipo),
 * preenchendo datas, endereço, textos e mídia de forma realista e
 * variando a cada execução.
 */
trait SeedsEventsFromCatalog
{
    /**
     * @param list<array{name: string, month: int, category: string, type: string}> $catalog
     * @param int|null $forceMonth quando definido, ignora o "month" de cada entrada do catálogo
     */
    protected function createEventsFromCatalog(array $catalog, int $year, ?int $forceMonth = null): void
    {
        $descriptions = new EventDescriptionGenerator();
        $rules = new EventRulesGenerator();
        $linkInstructions = new LinkInstructionGenerator();
        $whatsapp = new WhatsappGenerator();
        $addresses = new AddressCatalog();
        $media = new EventMediaSelector();

        foreach ($catalog as $entry) {
            $month = $forceMonth ?? $entry['month'];
            [$start, $end] = $this->randomSchedule($year, $month);
            $address = $addresses->random();
            $isLimited = $entry['type'] === Event::TYPE_LIMITED;

            $event = Event::factory()->create([
                'name' => $entry['name'],
                'description' => $descriptions->generate($entry['name'], $entry['category']),
                'rules' => $rules->generate(),
                'link' => 'https://byissa.dev/',
                'link_instruction' => $linkInstructions->random(),
                'pixel' => null,
                'visualization' => 1,
                'type' => $entry['type'],
                'allow_guests' => 1,
                'capacity' => $isLimited ? random_int(10, 30) : null,
                'whatsapp' => $whatsapp->number(),
                'whatsappmessage' => $whatsapp->eventMessage(),
                'whatsapp_help' => $whatsapp->number(),
                'start' => $start->format('d/m/Y'),
                'end' => $end->format('d/m/Y'),
                'start_time' => $start->format('H:i:s'),
                'end_time' => $end->format('H:i:s'),
                'cep' => $address['cep'],
                'state' => $address['state'],
                'city' => $address['city'],
                'neighborhood' => $address['neighborhood'],
                'street' => $address['street'],
                'number' => $address['number'],
            ]);

            $this->attachMedia($event, $media, EventCatalog::keywordsFor($entry['category']));
        }
    }

    /**
     * @param list<string> $keywords
     */
    private function attachMedia(Event $event, EventMediaSelector $media, array $keywords): void
    {
        $photos = $media->pickPhotos($keywords, random_int(1, 6));

        foreach ($photos as $photo) {
            $event->addMedia($photo)->preservingOriginal()->toMediaCollection('photo');
        }

        $cover = $media->pickCover($photos);
        $event->addMedia($cover)->preservingOriginal()->toMediaCollection('cover');
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function randomSchedule(int $year, int $month): array
    {
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $day = random_int(1, $daysInMonth);
        $start = Carbon::create($year, $month, $day, 0, 0, 0);

        $roll = random_int(1, 10);
        if ($roll <= 5) {
            // Algumas horas, no fim de tarde/noite.
            $start->setTime(random_int(14, 20), [0, 30][random_int(0, 1)]);
            $end = $start->copy()->addHours(random_int(3, 6));
        } elseif ($roll <= 8) {
            // Um dia inteiro.
            $start->setTime(10, 0);
            $end = $start->copy()->setTime(22, 0);
        } else {
            // Fim de semana inteiro.
            $start->setTime(18, 0);
            $end = $start->copy()->addDays(2)->setTime(23, 0);
        }

        return [$start, $end];
    }
}
