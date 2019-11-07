<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    choices[] = {"UPRM Email"};
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_of_choices()
    {
        $users = "UPRM Email";

        return $users;
    }
}
