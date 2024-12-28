<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street_address' => $this->faker->streetAddress(),
            'locality' => $this->faker->streetName(),
            'city_town_village' => $this->faker->city(),
            'district' => $this->faker->word(),
            'state' => $this->faker->word(),
            'pin_code' => $this->faker->numerify('######'),
            'addressable_id' => null,
            'addressable_type' => null,
        ];
    }
}
