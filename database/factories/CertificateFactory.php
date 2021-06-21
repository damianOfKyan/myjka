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
            // 'kon_id' => $this->faker->randomNumber(1),
            'series' => 'PL' . $this->faker->unique()->randomNumber(7),
            'date_of_arrival' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'date_of_departure' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'tractor' => $this->faker->randomNumber,
            'bowser' => $this->faker->randomNumber,
            'container' => $this->faker->randomNumber,
            'last_product' => $this->faker->word,
            // 'nazwisko_kierowcy' => $this->faker->name,
            'washing_range' => $this->faker->randomNumber(1),
            'washing_procedure' => $this->faker->randomNumber(1),
            'detergents' => $this->faker->randomNumber(1),
            'chamber' => $this->faker->randomNumber(1),
            'partitions' => $this->faker->randomNumber(1),
            'seals' => $this->faker->randomNumber(1),
            // 'kon_nazwa' => $this->faker->name,
            // 'kon_ulica' => $this->faker->streetAddress,
            // 'kon_kod_pocztowy' => $this->faker->postcode,
            // 'kon_miasto' => $this->faker->city,
            // 'kon_kraj' => $this->faker->country,
            // 'kon_nip' => 'PL 123 ' . $this->faker->unique()->randomNumber(6) . ' ' . $this->faker->randomNumber(1),
        ];
    }
}
