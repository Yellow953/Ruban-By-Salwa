<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
