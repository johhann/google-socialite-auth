<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $customer = User::where('google_id', $user->id)->first();

            if (!$customer)  {
                $customer = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('password')
                ]);
            }

            // $token = $user->createToken('hanbon-inventory-secret-key', ["*"])->plainTextToken;

            // assign token variable to the user token
            // $user->token = $token;
            return view('welcome');

        } catch (\Exception $e) {
           return $e;
        }
    }
}
