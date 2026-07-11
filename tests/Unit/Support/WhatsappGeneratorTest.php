<?php

namespace Tests\Unit\Support;

use App\Support\Seeding\WhatsappGenerator;
use PHPUnit\Framework\TestCase;

class WhatsappGeneratorTest extends TestCase
{
    public function test_number_matches_the_brazilian_format_with_a_real_ddd(): void
    {
        $generator = new WhatsappGenerator();

        $number = $generator->number();

        $this->assertMatchesRegularExpression('/^\(\d{2}\) \d{5}-\d{4}$/', $number);
    }

    public function test_event_message_returns_a_non_empty_greeting(): void
    {
        $generator = new WhatsappGenerator();

        $message = $generator->eventMessage();

        $this->assertIsString($message);
        $this->assertNotEmpty($message);
    }
}
