<?php

namespace Database\Factories;

use App\Models\WashingRange;
use Illuminate\Database\Eloquent\Factories\Factory;

class WashingRangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WashingRange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->firstName,
            'description' => $this->faker->lastName,
        ];
    }
}
