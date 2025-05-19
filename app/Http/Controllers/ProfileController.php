<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Business;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Log;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['business', 'business_update', 'setup', 'setup_update', 'business_operating_hours_update', 'business_banner_upload', 'toggle_menu', 'toggle_orders', 'toggle_delivery', 'delivery_update']);
    }

    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
        ]);

        $user = auth()->user();
        $text = ucwords($user->name) . ' updated his profile, datetime: ' . now();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = auth()->user()->id . '_' . time() . '.' . $ext;
            $image = Image::make($file);
            $image->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            });
            $image->save(public_path('uploads/users/' . $filename));
            $path = '/uploads/users/' . $filename;
        } else {
            $path = $user->image;
        }

        $user->update([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone' => $request->phone,
            'image' => $path,
        ]);

        Log::create([
            'text' => $text,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function save_password(Request $request)
    {
        $request->validate([
            'new_password' => 'required|max:255|confirmed',
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make(
                $request->new_password
            )
        ]);

        Log::create([
            'text' => ucwords($user->name) . ' changed his password, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Password Changed Successfully...');
    }

    public function deactivate()
    {
        $user = auth()->user();

        Log::create([
            'text' => ucwords($user->name) . ' deactivated his account, datetime: ' . now(),
        ]);

        $user->subscription->delete();

        return redirect()->route('custom_logout');
    }

    public function business()
    {
        $business = auth()->user()->business;
        $taxes = Tax::select('id', 'name')->get();
        $operating_hours = $business->operating_hours;
        $days = Helper::get_days();
        $hours = Helper::get_hours();

        $data = compact('business', 'taxes', 'operating_hours', 'days', 'hours');
        return view('profile.business', $data);
    }

    public function business_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'google_maps_link' => 'nullable|max:255',
            'website' => 'nullable|max:255'
        ]);

        $business = auth()->user()->business;

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
            'text' => auth()->user()->name . ' updated Business settings, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Business updated successfully!');
    }

    public function setup()
    {
        $taxes = Tax::select('id', 'name')->get();
        $types = Helper::get_business_types();

        $data = compact('taxes', 'types');
        return view('auth.setup', $data);
    }

    public function setup_save(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:businesses',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'google_maps_link' => 'nullable|max:255',
            'website' => 'nullable|max:255',
            'tax_id' => 'required',
            'type' => 'required',
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

        $business = Business::create([
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

        $currencies = [
            [
                'code' => 'LBP',
                'name' => 'Lebanese Bank Pound',
                'symbol' => 'LBP',
                'rate' => 89500,
                'business_id' => $business->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'rate' => 1,
                'business_id' => $business->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('currencies')->insert($currencies);

        $currency = Currency::withoutGlobalScopes()
            ->where('business_id', $business->id)
            ->where('code', 'USD')
            ->first();

        auth()->user()->update([
            'business_id' => $business->id,
            'currency_id' => $currency->id,
        ]);

        $categories = Helper::get_categories_initial_list($request->type);

        foreach ($categories as $category) {
            Category::create([
                'name' => $category[0],
                'description' => $category[1],
                'image' => $category[2],
                'business_id' => $business->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $operating_hours = [
            ['business_id' => $business->id, 'day' => 'Monday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => $business->id, 'day' => 'Tuesday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => $business->id, 'day' => 'Wednesday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => $business->id, 'day' => 'Thursday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => $business->id, 'day' => 'Friday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => $business->id, 'day' => 'Saturday', 'open' => false, 'opening_hour' => null, 'closing_hour' => null, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => $business->id, 'day' => 'Sunday', 'open' => false, 'opening_hour' => null, 'closing_hour' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('operating_hours')->insert($operating_hours);

        Log::create([
            'text' => auth()->user()->name . ' created Business: ' . $request->name . ', datetime: ' . now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Business successfully created.');
    }

    public function business_operating_hours_update(Request $request)
    {
        $request->validate([
            'day' => 'required|array',
            'open' => 'required|array',
            'opening_hour' => 'nullable|array',
            'closing_hour' => 'nullable|array',
        ]);

        $business = auth()->user()->business;

        foreach ($request->day as $index => $day) {
            $business->operating_hours()->updateOrCreate(
                ['day' => $day],
                [
                    'open' => $request->open[$index] == 'true' ? true : false,
                    'opening_hour' => $request->open[$index] == 'true' ? $request->opening_hour[$index] : null,
                    'closing_hour' => $request->open[$index] == 'true' ? $request->closing_hour[$index] : null,
                ]
            );
        }

        return back()->with('success', 'Business hours updated successfully!');
    }

    public function business_banner_upload(Request $request)
    {
        if ($request->banner) {
            try {
                $file = $request->file('banner');
                $ext = $file->getClientOriginalExtension();
                $filename = auth()->id() . '_' . time() . '.' . $ext;
                $file->move('uploads/businesses/', $filename);
                $path = '/uploads/businesses/' . $filename;

                auth()->user()->business->update([
                    'banner' => $path,
                ]);

                Log::create(['text' => ucwords(auth()->user()->name) . ' updated banner, datetime: ' . now()]);

                return back()->with('success', 'Banner updated successfully!');
            } catch (\Throwable $th) {
                return back()->with('error', 'Image too Big, please compress it under 2MB...');
            }
        } else {
            return back()->with('danger', 'No Image Uploaded...');
        }
    }

    public function toggle_menu()
    {
        $business = auth()->user()->business;

        if (!$business->menu_activated) {
            $business->update([
                'menu_activated' => !$business->menu_activated
            ]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . ' activated Menu Feature, datetime: ' . now()
            ]);

            return redirect()->back()->with('success', 'Menu Feature Activated Successfully...');
        } else {
            $business->update([
                'menu_activated' => !$business->menu_activated
            ]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . ' deactivated Menu Feature, datetime: ' . now()
            ]);

            return redirect()->back()->with('success', 'Menu Feature Deactivated Successfully...');
        }
    }

    public function toggle_orders()
    {
        $business = auth()->user()->business;

        if (!$business->ordering_activated) {
            $business->update([
                'ordering_activated' => !$business->ordering_activated
            ]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . ' activated Menu Ordering Feature, datetime: ' . now()
            ]);

            return redirect()->back()->with('success', 'Menu Ordering Feature Activated Successfully...');
        } else {
            $business->update([
                'ordering_activated' => !$business->ordering_activated
            ]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . ' deactivated Menu Ordering Feature, datetime: ' . now()
            ]);

            return redirect()->back()->with('success', 'Menu Ordering Feature Deactivated Successfully...');
        }
    }

    public function toggle_delivery()
    {
        $business = auth()->user()->business;

        if (!$business->delivery_activated) {
            $business->update([
                'delivery_activated' => !$business->delivery_activated
            ]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . ' activated Delivery Feature, datetime: ' . now()
            ]);

            return redirect()->back()->with('success', 'Delivery Feature Activated Successfully...');
        } else {
            $business->update([
                'delivery_activated' => !$business->delivery_activated
            ]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . ' deactivated Delivery Feature, datetime: ' . now()
            ]);

            return redirect()->back()->with('success', 'Delivery Feature Deactivated Successfully...');
        }
    }

    public function delivery_update(Request $request)
    {
        $request->validate([
            'delivery' => 'required|numeric|min:0'
        ]);

        $business = auth()->user()->business;

        $business->update([
            'delivery' => $request->delivery
        ]);

        Log::create([
            'text' => ucwords(auth()->user()->name) . ' updated delivery charge, datetime: ' . now()
        ]);

        return redirect()->back()->with('success', 'Delivery Charge Updated Successfully...');
    }
}
