<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGroupsController extends Controller
{
    //public function index
    //Presents group name, group owner, the latest action, and creation date for each group.
    public function index(){
        $latestDate = DB::table('action')
            ->join('user_groups', 'user_groups.uid', '=', 'action.a_user')
            ->select('gid', DB::raw('MAX(a_date) as latest_action_date'))
            ->groupBy('user_groups.gid')
            ->orderBy('latest_action_date', 'desc');

        $latestActions = DB::table('user_groups')
            ->joinSub($latestDate, 'latestDate','latestDate.gid', '=', 'user_groups.gid')
            ->join('action',  function ($join) {
                $join->on('action.a_user', '=', 'user_groups.uid')
                    ->on('action.a_date', '=', 'latestDate.latest_action_date');
            })
            ->join('action_type', 'action_type.act_id', '=', 'action.a_type')
            ->join('group', 'group.gid', '=', 'user_groups.gid')
            ->join('user', 'user.uid', '=', 'group.g_owner')
            ->orderBy('latest_action_date', 'desc')
            //->orderBy('g_creation_date', 'desc')
            ->get();
/*
        $groups = DB::table('group')
            ->join('user', 'user.uid', '=', 'group.g_owner')
            ->select('group.*', 'user.first_name', 'user.last_name')
            ->orderBy('group.g_creation_date', 'desc')
            ->get();

        return view('admin.groups.index', ['groups' => $groups, 'latestActions'=> $latestActions]);
*/
        return view('admin.groups.index', ['latestActions'=> $latestActions]);
    }
}
