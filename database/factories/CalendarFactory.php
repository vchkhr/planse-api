<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarFactory extends Factory
{
    protected $model = Calendar::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'color' => '0',
            'name' => $this->faker->word(),
            'description' => $this->faker->optional()->word()
        ];
    }
}
