<?php

namespace App\Models;

use App\Models\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public static function generate_number()
    {
        $last_purchase = Purchase::where('business_id', auth()->user()->business_id)->orderBy('id', 'DESC')->first();

        if ($last_purchase) {
            return (int)$last_purchase->number + 1;
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
        if (request('invoice_number')) {
            $invoice_number = request('invoice_number');
            $q->where('invoice_number', $invoice_number);
        }
        if (request('purchase_date')) {
            $purchase_date = request('purchase_date');
            $q->whereDate('purchase_date', $purchase_date);
        }
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }
        if (request('notes')) {
            $notes = request('notes');
            $q->where('notes', 'LIKE', "%{$notes}%");
        }

        return $q;
    }
}
