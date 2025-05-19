<?php

namespace App\Models;

use App\Models\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $appends = ['status_color'];

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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function can_delete()
    {
        return auth()->user()->role == 'admin' && $this->reservations->count() == 0;
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'available' => 'success',
            'occupied' => 'danger',
            'reserved' => 'warning',
            'maintenance' => 'info',
            default => 'primary'
        };
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('code')) {
            $code = request('code');
            $q->where('code', 'LIKE', "%{$code}%");
        }
        if (request('seats')) {
            $seats = request('seats');
            $q->where('seats', $seats);
        }
        if (request('location')) {
            $location = request('location');
            $q->where('location', 'LIKE', "%{$location}%");
        }
        if (request('status')) {
            $status = request('status');
            $q->where('status', $status);
        }

        return $q;
    }
}
