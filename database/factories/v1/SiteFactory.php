<?php

namespace Database\Factories\v1;

use App\Models\v1\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Site::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_corporate' => \App\Models\v1\Corporate::all()->unique()->random()->id,
            'name' => $this->faker->company,
            'address' => $this->faker->address,
        ];
    }
}
