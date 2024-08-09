<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceRequestFactory extends Factory
{
    protected $model = ServiceRequest::class;

    public function definition()
    {
        return [
            'aircraft_id' => \App\Models\Aircraft::factory(),
            'maintenance_company_id' => \App\Models\MaintenanceCompany::factory(),
            'issue_description' => $this->faker->sentence,
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => $this->faker->randomElement([ServiceRequest::STATUS_PENDING, ServiceRequest::STATUS_IN_PROGRESS, ServiceRequest::STATUS_COMPLETED]),
        ];
    }
}
