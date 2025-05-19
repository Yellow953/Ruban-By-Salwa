<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Currency;
use App\Models\OperatingHour;
use App\Models\Product;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function menu(Business $business)
    {
        if ($business->menu_activated) {
            $categories = Category::withoutGlobalScopes()->select('id', 'name', 'image')->with('products')->where('business_id', $business->id)->where('deleted_at', null)->get();
            $products = Product::withoutGlobalScopes()->select('id', 'name', 'price', 'description', 'image', 'category_id')->with('category', 'secondary_images', 'variants', 'variants.options')->where('business_id', $business->id)->where('deleted_at', null)->where('quantity', '>', 0)->get()->groupBy('category_id');
            $operating_hours = OperatingHour::withoutGlobalScopes()->where('business_id', $business->id)->get();
            $rate = Currency::withoutGlobalScopes()->where('business_id', $business->id)->where('code', 'LBP')->where('deleted_at', null)->first()->rate;
            $data = compact('business', 'categories', 'products', 'operating_hours', 'rate');
            return view('menu.index', $data);
        } else {
            return abort(403);
        }
    }

    public function checkout(Business $business)
    {
        if ($business->ordering_activated) {
            $rate = Currency::withoutGlobalScopes()->where('business_id', $business->id)->where('code', 'LBP')->where('deleted_at', null)->first()->rate;

            $data = compact('business', 'rate');
            return view('menu.checkout', $data);
        } else {
            return abort(403);
        }
    }

    public function qrcode_download(Business $business)
    {
        $url = route('menu', $business->name);
        $filePath = public_path('qrcodes/qr-code.png');

        QrCode::size(300)->format('png')->generate($url, $filePath);

        return response()->download($filePath);
    }

    public function fix()
    {
        return 'fixed...';
    }

    public function test()
    {
        return view('test');
    }
}
