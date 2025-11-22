<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get shipping cost
     */
    public static function getShippingCost()
    {
        return (int) static::get('shipping_cost', 10000);
    }

    /**
     * Get free shipping threshold
     */
    public static function getFreeShippingThreshold()
    {
        return (int) static::get('free_shipping_threshold', 50000);
    }

    /**
     * Calculate shipping cost based on subtotal
     */
    public static function calculateShipping($subtotal)
    {
        $threshold = static::getFreeShippingThreshold();
        
        if ($subtotal >= $threshold) {
            return 0; // Free shipping
        }
        
        return static::getShippingCost();
    }
}
