<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/app';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => 'required',
        ]);
    }

    protected function create(array $data)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $data['g-recaptcha-response'],
        ]);

        $body = $response->json();

        if (!$body['success'] || $body['score'] < 0.5) {
            abort(403, 'Failed reCAPTCHA verification. Please try again.');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'admin',
            'currency_id' =>  1,
            'image' => 'assets/images/default_profile.png',
            'password' => Hash::make($data['password']),
            'terms_agreed' => true,
            'terms_agreed_at' => now(),
        ]);

        $user->subscription()->create([
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'is_active' => true,
        ]);

        session()->flash('success', 'Welcome to YellowPOS, Enjoy your 30 days free trial...');

        return $user;
    }
}
