<?php

namespace Database\Factories;

use App\Support\Seeding\BrazilianNames;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /** DDDs reais em uso no Brasil, para telefones plausíveis. */
    private const DDDS = [11, 21, 27, 31, 41, 47, 48, 51, 61, 62, 71, 81, 82, 83, 85, 91, 92, 98];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ddd = self::DDDS[array_rand(self::DDDS)];

        return [
            'name' => BrazilianNames::firstName(),
            'surname' => BrazilianNames::surname(),
            'phonenumber' => '55'.$ddd.'9'.fake()->numberBetween(10000000, 99999999),
            'email' => fake('pt_BR')->unique()->safeEmail(),
            'birthdate' => fake()->dateTimeBetween('-65 years', '-16 years')->format('d/m/Y'),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
