<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Report;
use App\Models\Reservation;
use App\Models\Subscription;
use App\Models\Supplier;
use App\Models\Table;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('super admin');
    }

    public function optimize()
    {
        Artisan::call('optimize');
        Artisan::call('view:cache');
        Artisan::call('route:cache');

        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Cache::flush();

        return redirect()->back()->with('success', 'System Optimized Successfully...');
    }

    public function clean()
    {
        User::onlyTrashed()->forceDelete();
        Subscription::onlyTrashed()->forceDelete();
        Category::onlyTrashed()->forceDelete();
        Product::onlyTrashed()->forceDelete();
        Client::onlyTrashed()->forceDelete();
        Supplier::onlyTrashed()->forceDelete();
        Order::onlyTrashed()->forceDelete();
        OrderItem::onlyTrashed()->forceDelete();
        Purchase::onlyTrashed()->forceDelete();
        PurchaseItem::onlyTrashed()->forceDelete();
        Currency::onlyTrashed()->forceDelete();
        Tax::onlyTrashed()->forceDelete();
        Debt::onlyTrashed()->forceDelete();
        Reservation::onlyTrashed()->forceDelete();
        Table::onlyTrashed()->forceDelete();
        Report::onlyTrashed()->forceDelete();
        Expense::onlyTrashed()->forceDelete();

        return redirect()->back()->with('success', 'Database Cleaned Successfully...');
    }
}
