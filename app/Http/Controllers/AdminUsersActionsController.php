<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminUsersActionsController extends Controller
{
    //public function index
    //Selects the most recent action, for each user
    public function index(){
        $latestDate = DB::table('action')
            ->select('a_user', DB::raw('MAX(a_date) as latest_action_date'))
            ->groupBy('a_user');
            //->orderBy('latest_action_date', 'desc')
            //->get();

        $users = DB::table('user')
            ->joinSub($latestDate, 'latestDate','user.uid', '=', 'latestDate.a_user')

            ->join('action',  function ($join) {
                $join->on('action.a_user', '=', 'latestDate.a_user')
                     ->on('action.a_date', '=', 'latestDate.latest_action_date');
            })
            ->join('action_type', 'action_type.act_id', '=', 'action.a_type')
            ->get();

        //dd($users);
        return view('admin.users-actions.index', ['users' => $users]);
    }
}
