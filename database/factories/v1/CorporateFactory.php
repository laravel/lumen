<?php

namespace Database\Factories\v1;

use App\Models\v1\Corporate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CorporateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Corporate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'is_owner' => 0,
        ];
    }
}
