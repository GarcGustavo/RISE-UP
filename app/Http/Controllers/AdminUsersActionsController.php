<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminUsersActionsController extends Controller
{
    //public function index
    //Selects a recent action, for each user
	//Shows only one action per user per day
    public function index(Request $request){

        $uid = $request->input('uid');;

        $limitActionDate = DB::table('Action')
            ->select('a_user', DB::raw('MAX(a_date) as recent_action_date'))
            ->groupBy('a_user');
            //->orderBy('recent_action_date', 'desc');
            //->get();
			
        $limitActionType = DB::table('Action')
            ->select('a_user', 'a_date', DB::raw('MAX(a_type) as recent_action_type'))
            ->groupBy('a_user')
			->groupBy('a_date');
            //->orderBy('recent_action_type', 'desc');			

        $users = DB::table('User')
            ->joinSub($limitActionDate, 'limitActionDate','limitActionDate.a_user', '=', 'User.uid')
            ->joinSub($limitActionType, 'limitActionType',  function ($join) {
                $join->on('limitActionType.a_user', '=', 'limitActionDate.a_user')
                     ->on('limitActionType.a_date', '=', 'limitActionDate.recent_action_date');
            })
            ->join('Action_Type', 'Action_Type.act_id', '=', 'limitActionType.recent_action_type')
            ->orderBy('recent_action_date', 'desc')
            ->get();

        return view('admin.users-actions.index', ['users' => $users, 'uid'=> $uid]);
    }

    //public function show
    //Selects recent actions for a particular user
    public function show(Request $request){
        $eluid = $request->input('id');;
        $users = DB::table('user')
            ->select('first_name', 'last_name')
            ->where('uid', '=', $eluid)
            ->get();

        $actions = DB::table('user')
            ->join('action', 'action.a_user', '=', 'user.uid')
            ->join('action_type', 'action.a_type', '=', 'action_type.act_id')
            ->select('user.*',  'action.a_date', 'action_type.act_name')
            ->where('user.uid', '=', $eluid)
            ->orderBy('action.a_date', 'desc')
            ->get();

            $uid = $request->input('uid');;
        return view('admin.users-actions.show', ['users' => $users, 'actions' => $actions, 'uid' => $uid]);

    }
}