<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LandingController extends Controller
{
    /**
     *
     */
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

    /**
     *
     */
    function logout(Request $r)
    {
        //Clear of info in session
        $r->session()->flush();

        return redirect('/');
    }

    /**
     *
     */
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
    public function redirectToProvider(Request $request)
    {
        //valiadate attributes of record
        $validator = Validator::make($request->all(), [
            '_token' => "bail|required",
            'choice' => "required|string|max:64",
        ]);

        if ($validator->fails()) {
            $error = 'Please select a valid login choice.';
            return redirect('/?error=' . $error);
        }

        $choice = $request->input('choice');

        if ($choice == "Login with UPR/UPRM account") {
            return Socialite::driver('google')->redirect();
        } else {
            $error = 'Please select a valid login choice.';
            return redirect('/?error=' . $error);
        }

    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        //Get Socialite obeject user with google api info
        $user = Socialite::driver('google')->stateless()->user();

        //Verify if a key 'user' exist in current session it is used to verify user
        if ($request->session()->exists('user')) {
            //Forget info in session with key 'user'
            $request->session()->forget('user');
        }

        //Get user info from object and decode with json
        $u = $user->user;
        $u = json_encode($u);

        //Store temporay value in session with key 'user' to verify user in login progress
        $request->session()->put('user', 'temporary');
        //Store google api user's info in session with key 'u'
        $request->session()->put('u', $u);

        return redirect('/user/verify?e='.$user->getEmail());

    }
}
