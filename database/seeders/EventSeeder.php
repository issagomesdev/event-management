<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $customerIds = Customer::pluck('id')->toArray();

        $eventsData = [
            ['name' => 'Festa Praia'],
            ['name' => 'Balada Noite'],
            ['name' => 'Aniversário'],
            ['name' => 'Reunião'],
            ['name' => 'Workshop'],
        ];

        foreach ($eventsData as $index => $base) {
            $startDate = Carbon::now()->addDays(7 * ($index + 1));
            $endDate = Carbon::now()->addYears(3);
            $startTime = ($index % 2 == 0) ? '18:00:00' : '20:00:00';
            $endTime = ($index % 2 == 0) ? '23:00:00' : '02:00:00';
            $rules_txt = implode("", array_map(fn($t) => "<li>$t</li>",$faker->sentences(5)));

            $data = array_merge($base, [
                'start' => $startDate->format('d/m/Y'),
                'end' => $endDate->format('d/m/Y'),
                'description' => 'Descrição do evento ' . ($index + 1) . ': ' . $faker->text(300),
                'rules' => "<ul>$rules_txt</ul>",
                'link' => 'https://example.com/events/' . Str::slug($base['name']) . '-' . ($index + 1),
                'link_instruction' => 'Apresente o QR na entrada',
                'pixel' => null,
                'visualization' => 1,
                'type' => 1,
                'allow_guests' => 1,
                'capacity' => rand(10, 100),
                'whatsapp' => '+5581' . rand(90000, 99999) . rand(0000, 9999),
                'whatsappmessage' => 'Olá, tenho interesse no evento',
                'whatsapp_help' => 'Tire suas dúvidas',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'country' => 'Brasil',
                'state' => 'PE',
                'city' => 'Recife',
                'neighborhood' => 'Centro',
                'street' => 'Rua Exemplo',
                'number' => (string) rand(1, 9999),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $event = Event::create($data);

            // attendees: anexa alguns customers ao evento (presença)
            if (!empty($customerIds)) {
                $shuffled = $customerIds;
                shuffle($shuffled);
                $attendees = array_slice($shuffled, 0, rand(3, min(8, count($shuffled))));
                foreach ($attendees as $custId) {
                    try {
                        $event->attendance_lists()->attach($custId, ['checkin' => rand(0, 1)]);
                    } catch (\Exception $e) {
                        // ignore
                    }

                    // para alguns attendees, adicionar 0-4 guests
                    $guestsCount = rand(0, 4);
                    for ($g = 0; $g < $guestsCount; $g++) {
                        DB::table('customer_event_guests')->insert([
                            'event_id' => $event->id,
                            'customer_id' => $custId,
                            'guest' => $faker->name(),
                            'checkin' => rand(0, 1),
                        ]);
                    }
                }
            }
        }
    }
}
