<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    public function googlepage()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googlecallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))->user();
            // Log Google user data for debugging
            Log::info('Google User Data: ', (array) $googleUser);

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                // If user doesn't exist, create a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => encrypt('123456'),
                ]);
            }
            if (Auth::guard('admin')->attempt(['email' => $user->email, 'password' => $user->password])) {
                Session::flash('success', 'Loging Successfully');
                return redirect()->route('admin.dashboard');
            } else {
                Session::flash('Error', 'Loging Error');
                return redirect()->back();
            }
            Session::flash('success', 'Loging Successfully');
            return redirect()->route('admin.dashboard');
        } catch (Exception $e) {
        }
    }
}
