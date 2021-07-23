<?php

namespace Database\Factories;

use App\Models\Contractor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contractor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->company,
            'name' => $this->faker->company,
            'nip' => 'PL 123 '
                . $this->faker->unique()->randomNumber(6)
                . ' '
                . $this->faker->randomNumber(1),
            // 'ulica' => $this->faker->streetAddress,
            // 'kod_pocztowy' => $this->faker->postcode,
            // 'miasto' => $this->faker->city,
            // 'kraj' => $this->faker->country,
        ];
    }
}
