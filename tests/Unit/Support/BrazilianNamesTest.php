<?php

namespace Tests\Unit\Support;

use App\Support\Seeding\BrazilianNames;
use PHPUnit\Framework\TestCase;

class BrazilianNamesTest extends TestCase
{
    public function test_first_name_and_surname_are_non_empty_strings(): void
    {
        $this->assertNotEmpty(BrazilianNames::firstName());
        $this->assertNotEmpty(BrazilianNames::surname());
    }

    public function test_full_name_combines_first_name_and_surname(): void
    {
        $fullName = BrazilianNames::fullName();

        $this->assertMatchesRegularExpression('/^\S+.*\s+\S+$/u', $fullName);
    }
}
