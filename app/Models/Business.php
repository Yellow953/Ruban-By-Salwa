<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }

    public function barcodes()
    {
        return $this->hasMany(Barcode::class);
    }

    public function operating_hours()
    {
        return $this->hasMany(OperatingHour::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function subscription()
    {
        return $this->hasOneThrough(
            Subscription::class,
            User::class,
            'business_id',
            'user_id',
            'id',
            'id'
        );
    }

    // Permissions
    public function can_delete()
    {
        return auth()->user()->role == "super admin";
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
        if (request('address')) {
            $address = request('address');
            $q->where('address', 'LIKE', "%{$address}%");
        }
        if (request('tax_id')) {
            $tax_id = request('tax_id');
            $q->where('tax_id', 'LIKE', "%{$tax_id}%");
        }
        if (request('type')) {
            $type = request('type');
            $q->where('type', $type);
        }

        return $q;
    }
}
