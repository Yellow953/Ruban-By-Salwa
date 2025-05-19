<?php

namespace App\Models;

use App\Models\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'reservation_time' => 'datetime',
    ];

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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Permissions
    public function can_delete()
    {
        return auth()->user()->role == 'admin';
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'canceled' => 'danger',
            'completed' => 'info',
            default => 'primary'
        };
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('client_id')) {
            $q->where('client_id', request('client_id'));
        }

        if (request('table_id')) {
            $q->where('table_id', request('table_id'));
        }

        if (request('status')) {
            $q->where('status', request('status'));
        }

        if (request('date')) {
            $date = request('date');
            $q->whereDate('reservation_time', $date);
        }

        if (request('search')) {
            $search = request('search');
            $q->whereHas('client', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })->orWhereHas('table', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%{$search}%");
            });
        }

        return $q;
    }
}
