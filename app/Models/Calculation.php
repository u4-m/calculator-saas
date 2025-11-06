<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calculation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'material_id',
        'material_name',
        'weight',
        'print_time',
        'electricity_cost',
        'labor_cost',
        'profit_margin',
        'material_cost',
        'total_electricity_cost',
        'total_labor_cost',
        'total_cost',
        'final_price',
        'notes',
    ];

    protected $casts = [
        'weight' => 'float',
        'print_time' => 'integer',
        'electricity_cost' => 'float',
        'labor_cost' => 'float',
        'profit_margin' => 'float',
        'material_cost' => 'float',
        'total_electricity_cost' => 'float',
        'total_labor_cost' => 'float',
        'total_cost' => 'float',
        'final_price' => 'float',
    ];

    /**
     * Get the user that owns the calculation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the material associated with the calculation.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
