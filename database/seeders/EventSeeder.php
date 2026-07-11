<?php

namespace Database\Seeders;

use App\Support\Seeding\EventCatalog;
use Carbon\Carbon;
use Database\Seeders\Concerns\SeedsEventsFromCatalog;
use Illuminate\Database\Seeder;

/**
 * Cria os 36 eventos de demonstração do ano corrente (3 por mês, de
 * janeiro a dezembro), com fotos, capa, endereço e textos realistas.
 */
class EventSeeder extends Seeder
{
    use SeedsEventsFromCatalog;

    public function run(): void
    {
        $this->createEventsFromCatalog(EventCatalog::yearly(), Carbon::now()->year);
    }
}
