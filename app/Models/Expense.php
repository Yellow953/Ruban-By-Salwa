<?php

namespace App\Models;

use App\Models\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

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

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public static function generate_number()
    {
        $last_expense = Expense::where('business_id', auth()->user()->business_id)->orderBy('id', 'DESC')->first();

        if ($last_expense) {
            return (int)$last_expense->number + 1;
        } else {
            return 1;
        }
    }

    // Permissions
    public function can_delete()
    {
        return auth()->user()->role == 'admin';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('number')) {
            $number = request('number');
            $q->where('number', $number);
        }
        if (request('date')) {
            $date = request('date');
            $q->whereDate('date', $date);
        }
        if (request('category')) {
            $category = request('category');
            $q->where('category', $category);
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }

        return $q;
    }
}
