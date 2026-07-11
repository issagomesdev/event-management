<?php

namespace Tests\Unit\Support;

use App\Support\Seeding\EventCatalog;
use PHPUnit\Framework\TestCase;

class EventCatalogTest extends TestCase
{
    public function test_yearly_returns_36_events_three_per_month(): void
    {
        $events = EventCatalog::yearly();

        $this->assertCount(36, $events);

        $perMonth = collect($events)->groupBy('month');
        $this->assertCount(12, $perMonth);
        foreach ($perMonth as $month => $entries) {
            $this->assertCount(3, $entries, "Mês {$month} deveria ter 3 eventos");
        }
    }

    public function test_yearly_event_names_are_all_unique(): void
    {
        $names = collect(EventCatalog::yearly())->pluck('name');

        $this->assertSame($names->count(), $names->unique()->count());
    }

    public function test_current_month_pool_has_3_events_not_present_in_yearly(): void
    {
        $pool = EventCatalog::currentMonthPool();
        $yearlyNames = collect(EventCatalog::yearly())->pluck('name');

        $this->assertCount(3, $pool);
        foreach ($pool as $entry) {
            $this->assertFalse($yearlyNames->contains($entry['name']));
        }
    }

    public function test_every_catalog_entry_has_a_type_of_limited_or_unlimited(): void
    {
        foreach (EventCatalog::yearly() as $entry) {
            $this->assertContains($entry['type'], ['0', '1']);
        }
    }

    public function test_every_catalog_entry_category_has_keywords(): void
    {
        foreach (EventCatalog::yearly() as $entry) {
            $this->assertNotEmpty(EventCatalog::keywordsFor($entry['category']), "Categoria sem palavras-chave: {$entry['category']}");
        }
    }

    public function test_keywords_for_unknown_category_returns_empty_array(): void
    {
        $this->assertSame([], EventCatalog::keywordsFor('categoria-inexistente'));
    }
}
