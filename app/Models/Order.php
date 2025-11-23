<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'order_number',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_address',
        'address_id',
        'subtotal',
        'shipping_cost',
        'shipping_method_id',
        'shipping_tracking_number',
        'total',
        'status',
        'payment_method',
        'notes',
    ];
    
    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];
    
    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }
    
    // Accessors
    public function getCustomerNameAttribute()
    {
        return $this->user ? $this->user->name : $this->guest_name;
    }
    
    public function getCustomerEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->guest_email;
    }
    
    public function isGuestOrder(): bool
    {
        return is_null($this->user_id);
    }
    
    // Status helper methods
    public function isPendingPayment(): bool
    {
        return $this->status === 'pending_payment';
    }
    
    public function isPaymentUploaded(): bool
    {
        return $this->status === 'payment_uploaded';
    }
    
    public function isPaymentVerified(): bool
    {
        return $this->status === 'payment_verified';
    }
    
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }
    
    // Scopes
    public function scopePendingPayment($query)
    {
        return $query->where('status', 'pending_payment');
    }
    
    public function scopePaymentUploaded($query)
    {
        return $query->where('status', 'payment_uploaded');
    }
    
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }
}
