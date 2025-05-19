<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'currency_id',
        'business_id',
        'image',
        'terms_agreed',
        'terms_agreed_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'cashier_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function hasActiveSubscription()
    {
        $subscription = $this->subscription;

        return $subscription && $subscription->is_active && (!$subscription->ends_at || now()->between($subscription->starts_at, $subscription->ends_at));
    }

    public function isOnTrial()
    {
        $subscription = $this->subscription;

        return $subscription && $subscription->isTrialActive();
    }

    public function can_delete()
    {
        return $this->orders->count() == 0 && (auth()->user()->role == 'admin' || auth()->user()->role == 'super admin');
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('email')) {
            $email = request('email');
            $q->where('email', 'LIKE', "%{$email}%");
        }
        if (request('phone')) {
            $phone = request('phone');
            $q->where('phone', 'LIKE', "%{$phone}%");
        }
        if (request('role')) {
            $role = request('role');
            $q->where('role', $role);
        }
        if (request('business_id')) {
            $business_id = request('business_id');
            $q->where('business_id', $business_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }

        return $q;
    }
}
