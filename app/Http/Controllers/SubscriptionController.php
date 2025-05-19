<?php

namespace App\Http\Controllers;

use App\Exports\SubscriptionsExport;
use App\Helpers\Helper;
use App\Models\Log;
use App\Models\Subscription;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::select('id', 'user_id', 'starts_at', 'ends_at', 'is_active', 'type', 'plan')->filter()->orderBy('id', 'desc')->paginate(25);
        $users = User::select('id', 'name')->get();
        $types = Helper::get_subscription_types();
        $plans = Helper::get_subscription_plans();

        $data = compact('subscriptions', 'users', 'types', 'plans');
        return view('subscriptions.index', $data);
    }

    public function new()
    {
        $users = User::select('id', 'name')->get();
        $types = Helper::get_subscription_types();
        $plans = Helper::get_subscription_plans();

        $data = compact('users', 'types', 'plans');
        return view('subscriptions.new', $data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'type' => 'required',
            'plan' => 'required',
        ]);

        $subscription =  Subscription::create($data);

        $text = ucwords(auth()->user()->name) . " created new Subscription for " . ucwords($subscription->user->name) . " from " . $subscription->starts_at . " to " . $subscription->ends_at . ", datetime :   " . now();

        Log::create([
            'text' => $text,
        ]);

        return redirect()->route('subscriptions')->with('success', 'Subscription created successfully!');
    }

    public function edit(Subscription $subscription)
    {
        $types = Helper::get_subscription_types();
        $plans = Helper::get_subscription_plans();

        $data = compact('subscription', 'types', 'plans');
        return view('subscriptions.edit', $data);
    }

    public function update(Subscription $subscription, Request $request)
    {
        $data = $request->validate([
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'type' => 'required',
            'plan' => 'required',
        ]);

        $subscription->update($data);

        $text = "Subscription of " . ucwords($subscription->user->name) . " changed, currently from " . $subscription->starts_at . " to " . $subscription->ends_at . ", datetime :   " . now();

        Log::create([
            'text' => $text
        ]);

        return redirect()->back()->with('success', 'Subscription successfully updated...');
    }

    public function destroy(Subscription $subscription)
    {
        if ($subscription->can_delete()) {
            $user = auth()->user();
            $text = ucwords($user->name) . " deleted Subscription of " . ucwords($subscription->user->name) . ", datetime :   " . now();

            Log::create([
                'text' => $text,
            ]);
            $subscription->delete();

            return redirect()->back()->with('error', 'Subscription deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new SubscriptionsExport($filters), 'Subscriptions.xlsx');
    }

    public function pdf(Request $request)
    {
        $subscriptions = Subscription::with('user')->filter()->get();

        $pdf = Pdf::loadView('subscriptions.pdf', compact('subscriptions'));

        return $pdf->download('Subscriptions.pdf');
    }

    public function invalid()
    {
        return view('subscriptions.invalid');
    }

    public function status()
    {
        $subscription = auth()->user()->subscription;

        if (!$subscription) {
            return response()->json(['status' => 'no_subscription']);
        }

        $expiresIn = floor(now()->diffInDays($subscription->ends_at, false));

        return response()->json([
            'status' => 'ok',
            'expires_in' => $expiresIn,
        ]);
    }
}
