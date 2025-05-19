<?php

namespace App\Models;

use App\Models\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Scope
    protected static function booted()
    {
        static::addGlobalScope(new BusinessScope);

        static::creating(function ($model) {
            $model->business_id = auth()->user()->business_id;
        });
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // Permissions
    public function can_delete()
    {
        return auth()->user()->role == 'admin' && $this->debts->count() == 0 && $this->purchases->count() == 0;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('address')) {
            $address = request('address');
            $q->where('address', 'LIKE', "%{$address}%");
        }
        if (request('email')) {
            $email = request('email');
            $q->where('email', 'LIKE', "%{$email}%");
        }
        if (request('phone')) {
            $phone = request('phone');
            $q->where('phone', $phone);
        }

        return $q;
    }
}
