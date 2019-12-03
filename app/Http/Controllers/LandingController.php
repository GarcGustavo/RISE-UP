<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
