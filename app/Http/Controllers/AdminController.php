<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\user;
use App\Models\role;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    //public function index
	public function users(){
	    //$users = user::all();

        $users = DB::table('user')
            ->join('role', 'user.u_role', '=', 'role.rid')
            ->select('user.*', 'r_name')
            ->orderBy('u_creation_date', 'desc')
            ->get();

		return view('admin.users', ['users' => $users]);
	}
}
?>
