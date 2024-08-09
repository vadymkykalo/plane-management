<?php

namespace Database\Factories;

use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Factories\Factory;

class AircraftFactory extends Factory
{
    protected $model = Aircraft::class;

    public function definition()
    {
        return [
            'model' => $this->faker->word,
            'serial_number' => $this->faker->unique()->numerify('###-###-###'),
            'registration' => $this->faker->unique()->bothify('???-#####'),
        ];
    }
}
