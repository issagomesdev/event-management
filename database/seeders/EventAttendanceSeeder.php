<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Event;
use App\Support\Seeding\BrazilianNames;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Popula customer_event (participantes) e customer_event_guests
 * (convidados de cada participante) para todos os eventos existentes.
 * As duas tabelas são preenchidas juntas porque os convidados dependem
 * diretamente de qual cliente foi sorteado como participante — separar
 * em dois seeders exigiria repetir a mesma amostragem de clientes.
 */
class EventAttendanceSeeder extends Seeder
{
    /** Proporção aproximada de check-ins já realizados. */
    private const CHECKIN_RATE = 0.3;

    public function run(): void
    {
        $customerIds = Customer::query()->pluck('id')->all();

        if (empty($customerIds)) {
            return;
        }

        Event::query()->select(['id', 'type', 'capacity'])->get()->each(
            fn (Event $event) => $this->seedEvent($event, $customerIds)
        );
    }

    /**
     * @param list<int> $customerIds
     */
    private function seedEvent(Event $event, array $customerIds): void
    {
        $pool = $customerIds;
        shuffle($pool);

        $limit = $event->type === Event::TYPE_LIMITED && $event->capacity
            ? min((int) $event->capacity, count($pool))
            : min(count($pool), random_int(20, 90));

        $limit = max($limit, 1);
        $attendeeCount = random_int(min(5, $limit), $limit);
        $attendees = array_slice($pool, 0, $attendeeCount);

        $attendanceRows = [];
        $guestRows = [];

        foreach ($attendees as $customerId) {
            $attendanceRows[] = [
                'event_id' => $event->id,
                'customer_id' => $customerId,
                'checkin' => $this->rollCheckin(),
            ];

            for ($i = 0, $guestsCount = random_int(0, 5); $i < $guestsCount; $i++) {
                $guestRows[] = [
                    'event_id' => $event->id,
                    'customer_id' => $customerId,
                    'guest' => BrazilianNames::fullName(),
                    'checkin' => $this->rollCheckin(),
                ];
            }
        }

        DB::table('customer_event')->insert($attendanceRows);

        if (! empty($guestRows)) {
            DB::table('customer_event_guests')->insert($guestRows);
        }
    }

    private function rollCheckin(): int
    {
        return (random_int(1, 100) <= self::CHECKIN_RATE * 100) ? 1 : 0;
    }
}
