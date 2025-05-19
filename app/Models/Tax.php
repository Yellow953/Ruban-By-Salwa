<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    // Permissions
    public function can_delete()
    {
        return auth()->user()->role == "super admin" && $this->businesses->count() == 0;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }

        return $q;
    }
}
