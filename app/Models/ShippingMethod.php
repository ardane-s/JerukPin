<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'base_cost',
        'icon',
        'estimated_days',
        'is_active',
        'order',
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'is_active' => 'boolean',
        'estimated_days' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active shipping methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * Get orders using this shipping method
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get formatted cost
     */
    public function getFormattedCostAttribute()
    {
        if ($this->base_cost == 0) {
            return 'Gratis';
        }
        return 'Rp ' . number_format($this->base_cost, 0, ',', '.');
    }

    /**
     * Get delivery estimate text
     */
    public function getEstimateTextAttribute()
    {
        if ($this->estimated_days == 0) {
            return 'Hari ini';
        }
        if ($this->estimated_days == 1) {
            return '1 hari';
        }
        return $this->estimated_days . ' hari';
    }
}
