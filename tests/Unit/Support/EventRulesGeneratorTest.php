<?php

namespace Tests\Unit\Support;

use App\Support\Seeding\EventRulesGenerator;
use PHPUnit\Framework\TestCase;

class EventRulesGeneratorTest extends TestCase
{
    public function test_generate_returns_a_list_wrapped_in_ul_with_6_to_10_items_by_default(): void
    {
        $generator = new EventRulesGenerator();

        $html = $generator->generate();

        $this->assertStringStartsWith('<ul>', $html);
        $this->assertStringEndsWith('</ul>', $html);

        $itemCount = substr_count($html, '<li>');
        $this->assertGreaterThanOrEqual(6, $itemCount);
        $this->assertLessThanOrEqual(10, $itemCount);
    }

    public function test_generate_respects_custom_min_and_max(): void
    {
        $generator = new EventRulesGenerator();

        $html = $generator->generate(3, 3);

        $this->assertSame(3, substr_count($html, '<li>'));
    }

    public function test_two_calls_produce_different_rule_sets(): void
    {
        $generator = new EventRulesGenerator();

        $first = $generator->generate(10, 10);
        $second = $generator->generate(10, 10);

        // Com 25 regras no pool e 10 sorteadas, a chance de sets idênticos é desprezível.
        $this->assertNotSame($first, $second);
    }
}
