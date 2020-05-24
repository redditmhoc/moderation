<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redditLogin()
    {
        // Get URLs
        $urlPrevious = url()->previous();
        $urlBase = url()->to('/');

        // Set the previous url that we came from to redirect to after successful login but only if is internal
        if(($urlPrevious != $urlBase . '/auth/login') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)) {
            session()->put('url.intended', $urlPrevious);
        }
        return Socialite::with('reddit')->redirect();
    }

    public function redditCallback()
    {
        $return = Socialite::driver('reddit')->user();
        $users = User::where(['username' => $return->nickname])->first();
        if($users){
            if ($users->banned) {
                abort(403, 'You have been banned.');
            }
            Auth::login($users);
            return redirect()->route('dash');
        }else {
            $user = new User();
            $user->username = $return->nickname;
            $user->banned = false;
            $user->save();
            Auth::login($user);
            return redirect()->route('dash');
        }
    }

    public function getUserDataJson()
    {
        $user = User::whereId(Auth::id())->firstOrFail();
        $roles = $user->getRoleNames()->toArray();
        $permissions = $user->getAllPermissions()->toArray();
        $userArray = $user->toArray();
        return json_encode($userArray);
    }
}
