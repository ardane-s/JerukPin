<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    protected $fillable = [
        'payment_id',
        'proof_image_path',
        'payment_date',
        'payment_amount',
        'bank_name',
        'account_name',
        'notes',
        'uploaded_at',
        'verified_by',
        'verified_at',
        'verification_notes',
    ];
    
    protected $casts = [
        'uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
    
    // Relationships
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    // Accessor
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->proof_image_path);
    }
    
    // Helper methods
    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }
}
