<?php

namespace Database\Factories\v1;

use App\Models\v1\Schedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand_time[0] = [
            'start' => '13:00:00',
            'end' => '17:00:00',
        ];

        $rand_time[1] = [
            'start' => '18:00:00',
            'end' => '21:00:00',
        ];

        $rand_time[2] = [
            'start' => '09:00:00',
            'end' => '12:00:00',
        ];

        $rand_get = rand(0,2);

        return [
            'day' => $this->faker->randomElement($array = array ('Senin','Selasa', 'Rabu', 'Kamis', 'Jumat')),
            'start' => $rand_time[$rand_get]['start'],
            'end' => $rand_time[$rand_get]['end'],
        ];
    }
}
