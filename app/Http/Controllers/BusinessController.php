<?php

namespace App\Http\Controllers;

use App\Exports\BusinessesExport;
use App\Helpers\Helper;
use App\Models\Business;
use App\Models\Currency;
use App\Models\Log;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Tax;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::select('id', 'name', 'email', 'phone', 'website', 'tax_id', 'logo', 'type')->filter()->orderBy('id', 'desc')->paginate(25);
        $businesses->each(function ($business) {
            $lastActivity = DB::table('logs')
                ->where('business_id', $business->id)
                ->max('created_at');

            $business->last_activity = $lastActivity
                ? Carbon::make($lastActivity)->diffForHumans()
                : 'No Activity Recorded...';
        });
        $taxes = Tax::select('id', 'name')->get();
        $types = Helper::get_business_types();

        $data = compact('businesses', 'taxes', 'types');
        return view('businesses.index', $data);
    }

    public function new()
    {
        $taxes = Tax::select('id', 'name')->get();
        $types = Helper::get_business_types();

        $data = compact('taxes', 'types');
        return view('businesses.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'google_maps_link' => 'nullable|max:255',
            'website' => 'nullable|max:255',
            'tax_id' => 'required',
            'type' => 'requered',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = auth()->user()->id . '_' . time() . '.' . $ext;
            $image = Image::make($file);
            $image->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            });
            $image->save(public_path('uploads/businesses/' . $filename));
            $path = '/uploads/businesses/' . $filename;
        } else {
            $path = "assets/images/no_img.png";
        }

        Business::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'google_maps_link' => $request->google_maps_link,
            'website' => $request->website,
            'logo' => $path,
            'tax_id' => $request->tax_id,
            'type' => $request->type,
        ]);

        Log::create([
            'text' => auth()->user()->name . ' created Business: ' . $request->name . ', datetime: ' . now(),
        ]);

        return redirect()->route('businesses')->with('success', 'Business Successfully created...');
    }

    public function edit(Business $business)
    {
        $taxes = Tax::select('id', 'name')->get();

        $data = compact('business', 'taxes');
        return view('businesses.edit', $data);
    }

    public function update(Request $request, Business $business)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'website' => 'nullable|max:255',
            'google_maps_link' => 'nullable|max:255'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = auth()->user()->id . '_' . time() . '.' . $ext;
            $image = Image::make($file);
            $image->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            });
            $image->save(public_path('uploads/businesses/' . $filename));
            $path = '/uploads/businesses/' . $filename;
        } else {
            $path = $business->logo;
        }

        $business->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'google_maps_link' => $request->google_maps_link,
            'website' => $request->website,
            'logo' => $path,
            'tax_id' => $request->tax_id,
        ]);

        Log::create([
            'text' => 'Business ' . ucwords($business->name) . ' updated successfully, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Business updated successfully...');
    }

    public function destroy(Business $business)
    {
        if ($business->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Business: " . $business->name . ", datetime: " . now();

            if ($business->image != 'assets/images/no_img.png') {
                $path = public_path($business->image);
                File::delete($path);
            }

            $business->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Business was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new BusinessesExport($filters), 'Businesses.xlsx');
    }

    public function pdf(Request $request)
    {
        $businesses = Business::with('tax')->filter()->get();

        $pdf = Pdf::loadView('businesses.pdf', compact('businesses'));

        return $pdf->download('Businesses.pdf');
    }

    public function users(Business $business)
    {
        $currencies = Currency::withoutGlobalScopes()->where('business_id', $business->id)->orderBy('created_at', 'DESC')->get();
        $roles = Helper::get_roles();
        $logs = Log::withoutGlobalScopes()->where('business_id', $business->id)->orderBy('created_at', 'DESC')->limit(10)->get();
        $order_count = Order::withoutGlobalScopes()->where('business_id', $business->id)->count();
        $purchase_count = Purchase::withoutGlobalScopes()->where('business_id', $business->id)->count();
        $product_count = Product::withoutGlobalScopes()->where('business_id', $business->id)->count();
        $log_count = Log::withoutGlobalScopes()->where('business_id', $business->id)->count();

        $data = compact('business', 'currencies', 'roles', 'logs', 'order_count', 'purchase_count', 'product_count', 'log_count');
        return view('businesses.users', $data);
    }

    public function users_create(Request $request, Business $business)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required',
            'role' => 'required',
            'currency_id' => 'required',
            'password' => 'required|max:255|confirmed',
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone' => $request->phone,
            'image' => 'assets/images/default_profile.png',
            'business_id' => $business->id,
            'currency_id' => $request->currency_id,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        $user->subscription()->create([
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'is_active' => true,
        ]);

        $text = ucwords(auth()->user()->name) . " created User : " . $request->name . " for Business: " . $business->name . ", datetime :   " . now();
        Log::create([
            'text' => $text,
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }
}
