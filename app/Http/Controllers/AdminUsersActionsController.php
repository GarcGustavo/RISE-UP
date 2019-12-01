<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminUsersActionsController extends Controller
{
    //public function index
    //Selects latest action, for each user
    public function index(){
        $latestDate = DB::table('Action')
            ->select('a_user', DB::raw('MAX(a_date) as latest_action_date'))
            ->groupBy('a_user');
            //->orderBy('latest_action_date', 'desc');
            //->get();
			
        $ooa = DB::table('Action')
            ->select('a_user', 'a_date', DB::raw('MAX(a_type) as recent_action_type'))
            ->groupBy('a_user')
			->groupBy('a_date');
            //->orderBy('recent_action_type', 'desc');			

        $users = DB::table('User')
            ->joinSub($latestDate, 'latestDate','latestDate.a_user', '=', 'User.uid')

            ->joinSub($ooa, 'ooa',  function ($join) {
                $join->on('ooa.a_user', '=', 'latestDate.a_user')
                     ->on('ooa.a_date', '=', 'latestDate.latest_action_date');
            })
            ->join('Action_Type', 'Action_Type.act_id', '=', 'ooa.recent_action_type')
            ->orderBy('latest_action_date', 'desc')
            ->get();

        return view('admin.users-actions.index', ['users' => $users]);
    }

    //public function show
    //Selects recent actions for a particular user
    public function show($id){
        $users = DB::table('user')
            ->select('first_name', 'last_name')
            ->where('uid', '=', $id)
            ->get();

        $actions = DB::table('user')
            ->join('action', 'action.a_user', '=', 'user.uid')
            ->join('action_type', 'action.a_type', '=', 'action_type.act_id')
            ->select('user.*',  'action.a_date', 'action_type.act_name')
            ->where('user.uid', '=', $id)
            ->orderBy('action.a_date', 'desc')
            ->get();

        return view('admin.users-actions.show', ['users' => $users, 'actions' => $actions]);

    }
}
//show only one per user