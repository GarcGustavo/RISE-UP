<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\user;
use App\Models\role;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    //public function users
	public function users(){
        $users = DB::table('user')
            ->join('role', 'user.u_role', '=', 'role.rid')
            ->select('user.*', 'r_name')
            ->orderBy('u_creation_date', 'desc')
            ->get();

        $requests = DB::table('user')
            ->join('role', 'user.u_role', '=', 'role.rid')
            ->select('user.*', 'r_name')
            ->where('u_role_upgrade', 1)
            ->where('u_role', 1)
            ->where('u_ban_status', 0)
            ->orderBy('u_creation_date', 'desc')
            ->get();

		return view('admin.users', ['users' => $users, 'requests' => $requests]);
	}



    //public function log
    public function log(){
        $userActions = DB::table('user')
            ->join('role', 'user.u_role', '=', 'role.rid')
            ->select('user.*', 'r_name')
            ->orderBy('u_creation_date', 'desc')
            ->get();

        return view('admin.log', ['userActions' => $userActions]);
    }



    //public function actions
    public function actions($userId){

        $usersName = DB::table('user')
            ->select('first_name', 'last_name')
            ->where('uid', '=', $userId)
            ->get();

        $actions = DB::table('user')
            ->join('action', 'user.uid', '=', 'action.a_user')
            ->join('action_type', 'action.a_type', '=', 'action_type.act_id')
            ->select('user.*',  'action.a_date', 'action_type.act_name')
            ->where('uid', '=', $userId)
            ->orderBy('action.a_date', 'desc')
            ->get();

        return view('admin.actions', ['usersName' => $usersName, 'actions' => $actions]);
    }



    //public function filters
    public function filters(){

        $filters = DB::table('cs_parameter')
            ->select('cs_parameter.*')
            ->get();

        $options = DB::table('option')
            ->select('option.*')
            ->get();

        return view('admin.filters', ['filters' => $filters, 'options' => $options]);
    }
}
?>
