<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price_per_kg',
        'density',
        'diameter',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'density' => 'decimal:3',
        'diameter' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the calculations for the material.
     */
    public function calculations(): HasMany
    {
        return $this->hasMany(Calculation::class);
    }
}
