<?php

namespace Tests\Unit\Support;

use App\Support\Address\BrazilianStates;
use PHPUnit\Framework\TestCase;

class BrazilianStatesTest extends TestCase
{
    public function test_all_returns_the_27_brazilian_units(): void
    {
        $this->assertCount(27, BrazilianStates::all());
    }

    public function test_codes_returns_27_unique_two_letter_uppercase_codes(): void
    {
        $codes = BrazilianStates::codes();

        $this->assertCount(27, $codes);
        $this->assertCount(27, array_unique($codes));
        foreach ($codes as $code) {
            $this->assertMatchesRegularExpression('/^[A-Z]{2}$/', $code);
        }
    }

    public function test_name_of_returns_the_state_name_for_a_valid_uf(): void
    {
        $this->assertSame('Pernambuco', BrazilianStates::nameOf('PE'));
        $this->assertSame('Pernambuco', BrazilianStates::nameOf('pe'));
    }

    public function test_name_of_returns_null_for_an_invalid_uf(): void
    {
        $this->assertNull(BrazilianStates::nameOf('XX'));
    }
}
