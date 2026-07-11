<?php

namespace Tests\Unit\Support;

use App\Support\Address\BrazilianStates;
use App\Support\Seeding\AddressCatalog;
use PHPUnit\Framework\TestCase;

class AddressCatalogTest extends TestCase
{
    public function test_random_returns_a_complete_address_with_a_valid_state(): void
    {
        $catalog = new AddressCatalog();

        $address = $catalog->random();

        foreach (['cep', 'state', 'city', 'neighborhood', 'street', 'number'] as $key) {
            $this->assertArrayHasKey($key, $address);
            $this->assertNotEmpty($address[$key]);
        }
        $this->assertContains($address['state'], BrazilianStates::codes());
    }

    public function test_random_generates_a_different_number_each_time(): void
    {
        $catalog = new AddressCatalog();

        $numbers = array_map(fn () => $catalog->random()['number'], range(1, 20));

        $this->assertGreaterThan(1, count(array_unique($numbers)));
    }
}
