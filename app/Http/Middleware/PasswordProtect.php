<?php

namespace App\Http\Middleware;

use App\Models\Business;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PasswordProtect
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'stock' || $request->session()->has('page_unlocked')) {
            return $next($request);
        } else {
            $business = Business::firstOrFail();
            if ($business->password == null) {
                return $next($request);
            } else if ($request->isMethod('POST')) {
                if ($request->input('page_password') === $business->password) {
                    $request->session()->put('page_unlocked', true);
                    return redirect($request->url());
                } else {
                    return back()->withErrors(['page_password' => 'Incorrect password.']);
                }
            }

            return response()->view('auth.passwords.protect');
        }
    }
}
