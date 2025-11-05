<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        $materials = Material::where('is_active', true)->get();
        return view('calculator', compact('materials'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'weight' => 'required|numeric|min:0.1',
            'print_time' => 'required|numeric|min:1',
            'electricity_cost' => 'required|numeric|min:0',
            'labor_cost' => 'required|numeric|min:0',
            'profit_margin' => 'required|numeric|min:0|max:100',
        ]);

        $material = Material::findOrFail($validated['material_id']);

        // Calculate material cost
        $materialCost = ($material->price_per_kg / 1000) * $validated['weight'];

        // Calculate electricity cost (assuming 0.2kWh for the printer)
        $electricityCost = ($validated['print_time'] / 60) * ($validated['electricity_cost'] * 0.2);

        // Calculate total cost
        $totalCost = $materialCost + $electricityCost + $validated['labor_cost'];

        // Add profit margin
        $finalPrice = $totalCost * (1 + ($validated['profit_margin'] / 100));

        return response()->json([
            'material_cost' => number_format($materialCost, 2),
            'electricity_cost' => number_format($electricityCost, 2),
            'labor_cost' => number_format($validated['labor_cost'], 2),
            'total_cost' => number_format($totalCost, 2),
            'final_price' => number_format($finalPrice, 2),
        ]);
    }
}