<?php

namespace Database\Factories;

use App\Models\MaintenanceCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceCompanyFactory extends Factory
{
    protected $model = MaintenanceCompany::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'contact' => $this->faker->phoneNumber,
            'specialization' => $this->faker->word,
        ];
    }
}
