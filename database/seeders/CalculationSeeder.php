<?php

namespace Database\Seeders;

use App\Models\Calculation;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalculationSeeder extends Seeder
{
    public function run(): void
    {
        // Only run in local or testing environment
        if (!app()->environment(['local', 'testing'])) {
            return;
        }

        // Get the first user or create one if none exists
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Get some materials
        $materials = Material::take(3)->get();
        if ($materials->isEmpty()) {
            $this->call(MaterialSeeder::class);
            $materials = Material::take(3)->get();
        }

        // Create sample calculations
        $calculations = [
            [
                'material_id' => $materials[0]->id,
                'material_name' => $materials[0]->name,
                'weight' => 150,
                'print_time' => 180,
                'electricity_cost' => 0.15,
                'labor_cost' => 10.00,
                'profit_margin' => 20,
                'material_cost' => 4.50,
                'total_electricity_cost' => 1.35,
                'total_labor_cost' => 10.00,
                'total_cost' => 15.85,
                'final_price' => 19.02,
                'notes' => 'Small prototype part',
                'created_at' => now()->subDays(2),
            ],
            [
                'material_id' => $materials[1]->id,
                'material_name' => $materials[1]->name,
                'weight' => 320,
                'print_time' => 420,
                'electricity_cost' => 0.15,
                'labor_cost' => 15.00,
                'profit_margin' => 25,
                'material_cost' => 12.80,
                'total_electricity_cost' => 3.15,
                'total_labor_cost' => 15.00,
                'total_cost' => 30.95,
                'final_price' => 38.69,
                'notes' => 'Functional part with supports',
                'created_at' => now()->subDays(1),
            ],
            [
                'material_id' => $materials[2]->id,
                'material_name' => $materials[2]->name,
                'weight' => 80,
                'print_time' => 90,
                'electricity_cost' => 0.15,
                'labor_cost' => 8.00,
                'profit_margin' => 15,
                'material_cost' => 3.20,
                'total_electricity_cost' => 0.68,
                'total_labor_cost' => 8.00,
                'total_cost' => 11.88,
                'final_price' => 13.66,
                'notes' => 'Small decorative item',
                'created_at' => now(),
            ],
        ];

        // Insert calculations for the user
        foreach ($calculations as $calculation) {
            $user->calculations()->create($calculation);
        }
    }
}
