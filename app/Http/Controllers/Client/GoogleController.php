<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $googleUser = Socialite::driver('google')->user();
        dd($googleUser);
        
        $user = User::updateOrCreate(
            ['google_user_id' => $googleUser->id],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make('P@ssword!123'),
                'role' => 0,
                'google_user_id' => $googleUser->id
            ]
        );

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
