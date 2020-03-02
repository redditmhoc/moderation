<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redditLogin()
    {
        return Socialite::with('reddit')->redirect();
    }

    public function redditCallback()
    {
        $return = Socialite::driver('reddit')->user();
        $users = User::where(['username' => $return->nickname])->first();
        if($users){
            Auth::login($users);
            return redirect()->route('welcome');
        }else {
            $user = new User();
            $user->username = $return->nickname;
            $user->save();
            Auth::login($user);
            return redirect()->route('welcome');
        }
    }
}
