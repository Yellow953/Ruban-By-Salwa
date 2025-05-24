<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Client;
use App\Models\Log;
use App\Models\Order;
use App\Models\Product;
use App\Models\Report;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['business', 'business_update']);
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
            'text' => ucwords($user->name) . ' deactivated and deleted his account, datetime: ' . now(),
        ]);

        $user->delete();

        return redirect()->route('custom_logout');
    }

    public function business()
    {
        $business = Business::firstOrFail();
        $users = User::select('name', 'role')->get();
        $taxes = Tax::select('id', 'name')->get();
        $categories_count = Category::count();
        $products_count = Product::count();
        $orders_count = Order::count();
        $reports_count = Report::count();
        $clients_count = Client::count();

        $data = compact('business', 'taxes', 'categories_count', 'products_count', 'orders_count', 'reports_count', 'clients_count', 'users');
        return view('profile.business', $data);
    }

    public function business_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'website' => 'nullable|max:255'
        ]);

        $business = Business::firstOrFail();

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
            'website' => $request->website,
            'logo' => $path,
            'tax_id' => $request->tax_id,
        ]);

        Log::create([
            'text' => auth()->user()->name . ' updated Business settings, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Business updated successfully!');
    }
}
