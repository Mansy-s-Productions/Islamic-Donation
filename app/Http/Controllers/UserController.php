<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function redirectToProvider($provider)
    {
        // dd($provider);
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $r, $driver)
    {
        $user = Socialite::driver($driver)->user();
        if (! $user->email) {
            $user->email = 'no@'.$user->id.'email.com';
        }
        $FindUser = User::where('email', $user->email)->get();
        if ($FindUser->count() == 0) {
            // Signup
            $ProfileImage = (isset($user->avatar)) ? $user->avatar : 'user.png';
            // dd($user);
            $NewUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'image' => $ProfileImage,
                'password' => 'PlaceholderPass',
                'auth_provider' => $driver,
                'code' => mt_rand(100000, 999999),
                'confirmed' => 1,
                'active' => 1,
            ]);
            auth()->loginUsingId($NewUser->id);

            // Redirect back to homepage
            return redirect()->route('home')->withSuccesss('Your are now logged in as '.auth()->user()->name);
            // }
        } else {
            auth()->loginUsingId($FindUser->first()->id);

            // Redirect back to homepage
            return redirect()->route('home')->withSuccesss('Your are now logged in as '.auth()->user()->name);
            // }
        }
    }
}
