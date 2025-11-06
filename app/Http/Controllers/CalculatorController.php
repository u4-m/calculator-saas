<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Calculate electricity cost (assuming 0.3kWh for the printer)
        $electricityCost = ($validated['print_time'] / 60) * ($validated['electricity_cost'] * 0.3);

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

    /**
     * Display the calculation history for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        $calculations = Auth::user()->calculations()
            ->with('material')
            ->latest()
            ->paginate(10);
            
        return view('history', compact('calculations'));
    }
    
    /**
     * Save a calculation to the user's history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCalculation(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'weight' => 'required|numeric|min:0.1',
            'print_time' => 'required|numeric|min:1',
            'electricity_cost' => 'required|numeric|min:0',
            'labor_cost' => 'required|numeric|min:0',
            'profit_margin' => 'required|numeric|min:0|max:100',
            'material_cost' => 'required|numeric|min:0',
            'electricity_cost_total' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'final_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        $material = Material::findOrFail($validated['material_id']);
        
        $calculation = Auth::user()->calculations()->create([
            'material_id' => $material->id,
            'material_name' => $material->name,
            'weight' => $validated['weight'],
            'print_time' => $validated['print_time'],
            'electricity_cost' => $validated['electricity_cost'],
            'labor_cost' => $validated['labor_cost'],
            'profit_margin' => $validated['profit_margin'],
            'material_cost' => $validated['material_cost'],
            'total_electricity_cost' => $validated['electricity_cost_total'],
            'total_labor_cost' => $validated['labor_cost'],
            'total_cost' => $validated['total_cost'],
            'final_price' => $validated['final_price'],
            'notes' => $validated['notes'] ?? null,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Calculation saved successfully!',
            'calculation' => [
                'id' => $calculation->id,
                'created_at' => $calculation->created_at->format('M j, Y g:i A'),
            ]
        ]);
    }
}