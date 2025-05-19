<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isTrialActive()
    {
        return $this->starts_at && $this->ends_at && now()->between($this->starts_at, $this->ends_at);
    }

    public function can_delete()
    {
        return auth()->user()->role == 'super admin';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('user_id')) {
            $user_id = request('user_id');
            $q->where('user_id', $user_id);
        }
        if (request('type')) {
            $type = request('type');
            $q->where('type', $type);
        }
        if (request('plan')) {
            $plan = request('plan');
            $q->where('plan', $plan);
        }
        if (request('date_from') || request('date_to')) {
            $date_from = request()->query('date_from') ?? Carbon::today();
            $date_to = request()->query('date_to') ?? Carbon::today()->addYears(100);
            $q->whereBetween('starts_at', [$date_from, $date_to]);
        }

        return $q;
    }
}
