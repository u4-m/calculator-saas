<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            [
                'name' => 'PLA',
                'price_per_kg' => 25.99,
                'density' => 1.24,
                'diameter' => 1.75,
                'is_active' => true,
                'notes' => 'Polylactic Acid - Easy to print, biodegradable, good for beginners'
            ],
            [
                'name' => 'ABS',
                'price_per_kg' => 29.99,
                'density' => 1.04,
                'diameter' => 1.75,
                'is_active' => true,
                'notes' => 'Acrylonitrile Butadiene Styrene - Durable, heat resistant, requires heated bed'
            ],
            [
                'name' => 'PETG',
                'price_per_kg' => 32.99,
                'density' => 1.27,
                'diameter' => 1.75,
                'is_active' => true,
                'notes' => 'Polyethylene Terephthalate Glycol - Strong, flexible, good layer adhesion'
            ],
            [
                'name' => 'TPU',
                'price_per_kg' => 39.99,
                'density' => 1.21,
                'diameter' => 1.75,
                'is_active' => true,
                'notes' => 'Thermoplastic Polyurethane - Flexible, rubber-like material'
            ],
            [
                'name' => 'Nylon',
                'price_per_kg' => 49.99,
                'density' => 1.14,
                'diameter' => 1.75,
                'is_active' => true,
                'notes' => 'Strong, durable, and flexible, requires high printing temperature'
            ]
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}