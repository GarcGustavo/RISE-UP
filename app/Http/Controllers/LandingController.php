<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LandingController extends Controller
{
    //
    function login(Request $r)
    {
        $validatedData = $r->validate([
            '_token' => "bail|required",
            'choice' => "required|string"
        ]);

        $choice = $r->input('choice');

        if ($choice == "Login with UPR/UPRM account") {
            return redirect('/login');
        } else {
            return abort(404);
        }
    }

    //
    function logout(Request $r)
    {
        $r->session()->flush();
        return redirect('/');
    }

    //
    public function getLoginChoices()
    {
        $choices = ['0' => 'Login with UPR/UPRM account'];
        return response()->json(['choices' => $choices]);
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        return response()->json(['choices' => $user]);
        // $user->token;
    }
}
