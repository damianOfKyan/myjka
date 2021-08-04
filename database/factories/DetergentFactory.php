<?php

namespace Database\Factories;

use App\Models\Detergent;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetergentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Detergent::class;

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
