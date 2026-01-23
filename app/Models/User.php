<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'subscription_start',
        'subscription_end',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'subscription_start' => 'datetime',
        'subscription_end' => 'datetime',
    ];

    /**
     * Check if user is admin (admin or super_admin)
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || $this->role === 'super_admin';
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if subscription is active
     */
    public function isSubscriptionActive()
    {
        if (!$this->subscription_end) return false;
        return now()->lessThanOrEqualTo($this->subscription_end);
    }

    /**
     * Get days remaining in subscription
     */
    public function daysRemainingInSubscription()
    {
        if (!$this->subscription_end) return 0;
        return now()->diffInDays($this->subscription_end, false);
    }
}
