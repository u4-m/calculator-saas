<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalculationResource;
use App\Models\Calculation;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CalculationController extends Controller
{
    /**
     * Display a listing of the authenticated user's calculations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $calculations = Auth::user()->calculations()
            ->with('material')
            ->latest()
            ->paginate(10);

        return CalculationResource::collection($calculations);
    }

    /**
     * Store a newly created calculation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => ['required', 'exists:materials,id'],
            'weight' => ['required', 'numeric', 'min:0.1'],
            'print_time' => ['required', 'integer', 'min:1'],
            'electricity_cost' => ['required', 'numeric', 'min:0'],
            'labor_cost' => ['required', 'numeric', 'min:0'],
            'profit_margin' => ['required', 'numeric', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $material = Material::findOrFail($request->material_id);
        
        // Calculate costs (same as in CalculatorController)
        $materialCost = ($material->price_per_kg * $request->weight) / 1000;
        $electricityCost = ($request->print_time / 60) * 0.3 * $request->electricity_cost; // Assuming 300W printer
        $totalCost = $materialCost + $electricityCost + $request->labor_cost;
        $finalPrice = $totalCost * (1 + ($request->profit_margin / 100));

        $calculation = Auth::user()->calculations()->create([
            'material_id' => $material->id,
            'material_name' => $material->name,
            'weight' => $request->weight,
            'print_time' => $request->print_time,
            'electricity_cost' => $request->electricity_cost,
            'labor_cost' => $request->labor_cost,
            'profit_margin' => $request->profit_margin,
            'material_cost' => $materialCost,
            'total_electricity_cost' => $electricityCost,
            'total_labor_cost' => $request->labor_cost,
            'total_cost' => $totalCost,
            'final_price' => $finalPrice,
            'notes' => $request->notes,
        ]);

        return new CalculationResource($calculation->load('material'));
    }

    /**
     * Display the specified calculation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $calculation = Auth::user()->calculations()
            ->with('material')
            ->findOrFail($id);

        return new CalculationResource($calculation);
    }

    /**
     * Remove the specified calculation from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $calculation = Auth::user()->calculations()->findOrFail($id);
        $calculation->delete();

        return response()->json([
            'message' => 'Calculation deleted successfully'
        ]);
    }
}
