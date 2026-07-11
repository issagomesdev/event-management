<?php

namespace Database\Seeders;

use App\Support\Seeding\EventCatalog;
use Carbon\Carbon;
use Database\Seeders\Concerns\SeedsEventsFromCatalog;
use Illuminate\Database\Seeder;

/**
 * Seeder independente para uso durante o desenvolvimento: cria apenas 3
 * eventos, todos no mês corrente. Não é chamado pelo DatabaseSeeder (o
 * EventSeeder já cobre o mês atual dentro dos 36 eventos do ano) — rode
 * manualmente quando quiser popular só o mês atual:
 *
 *   php artisan db:seed --class=CurrentMonthEventSeeder
 */
class CurrentMonthEventSeeder extends Seeder
{
    use SeedsEventsFromCatalog;

    public function run(): void
    {
        $now = Carbon::now();

        $this->createEventsFromCatalog(EventCatalog::currentMonthPool(), $now->year, $now->month);
    }
}
