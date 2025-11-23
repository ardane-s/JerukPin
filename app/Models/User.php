<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Relationships
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    
    // Helper methods
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin ?? false;
    }
    
    public function hasInWishlist($productId): bool
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }
    
    public function isMember(): bool
    {
        return $this->role === 'member';
    }
    
    // Scopes
    public function scopeSuperAdmins($query)
    {
        return $query->where('role', 'super_admin');
    }
    
    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }
}

