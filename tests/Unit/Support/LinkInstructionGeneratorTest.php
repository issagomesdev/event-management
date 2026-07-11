<?php

namespace Tests\Unit\Support;

use App\Support\Seeding\LinkInstructionGenerator;
use PHPUnit\Framework\TestCase;

class LinkInstructionGeneratorTest extends TestCase
{
    public function test_random_returns_a_non_empty_demonstration_notice(): void
    {
        $generator = new LinkInstructionGenerator();

        $text = $generator->random();

        $this->assertIsString($text);
        $this->assertNotEmpty($text);
    }
}
