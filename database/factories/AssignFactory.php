<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'employee_id' => Employee::factory(),
            'inventory_id' => Inventory::factory(),
            'assigned_by' => fake()->company,
        ];
    }
}