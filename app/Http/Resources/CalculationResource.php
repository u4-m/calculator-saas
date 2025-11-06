<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalculationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'material' => [
                'id' => $this->material_id,
                'name' => $this->material_name,
            ],
            'weight' => (float) $this->weight,
            'print_time' => (int) $this->print_time,
            'costs' => [
                'material' => (float) $this->material_cost,
                'electricity' => (float) $this->total_electricity_cost,
                'labor' => (float) $this->total_labor_cost,
                'total' => (float) $this->total_cost,
            ],
            'profit_margin' => (float) $this->profit_margin,
            'final_price' => (float) $this->final_price,
            'notes' => $this->notes,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
