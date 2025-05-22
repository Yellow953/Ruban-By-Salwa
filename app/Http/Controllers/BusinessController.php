<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Log;
use App\Models\Tax;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BusinessController extends Controller
{
    public function edit()
    {
        $business = Business::firstOrFail();
        $taxes = Tax::select('id', 'name')->get();

        $data = compact('business', 'taxes');
        return view('businesses.edit', $data);
    }

    public function update(Request $request,)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'website' => 'nullable|max:255',
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
            'text' => 'Business ' . ucwords($business->name) . ' updated successfully, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Business updated successfully...');
    }
}
