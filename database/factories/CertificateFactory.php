<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'series' => 'PL' . $this->faker->unique()->randomNumber(7),
            'date_of_arrival' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'date_of_departure' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'tractor' => $this->faker->randomNumber,
            'bowser' => $this->faker->randomNumber,
            'container' => $this->faker->randomNumber,
            'last_product' => $this->faker->word,
            'chamber' => $this->faker->randomNumber(1) . ',' . $this->faker->randomNumber(1),
            'partitions' => $this->faker->randomNumber(1) . ',' . $this->faker->randomNumber(1),
            'seals' => $this->faker->randomNumber(1) . ',' . $this->faker->randomNumber(1),
        ];
    }
}
