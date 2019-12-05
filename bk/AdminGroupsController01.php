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
        $latestDate = DB::table('Action')
            ->join('User_Groups', 'User_Groups.uid', '=', 'Action.a_user')
            ->select('gid', DB::raw('MAX(a_date) as latest_action_date'))
            ->groupBy('User_Groups.gid')
            ->orderBy('latest_action_date', 'desc');

        $latestActions = DB::table('User_Groups')
            ->joinSub($latestDate, 'latestDate','latestDate.gid', '=', 'User_Groups.gid')
            ->join('Action',  function ($join) {
                $join->on('Action.a_user', '=', 'User_Groups.uid')
                    ->on('Action.a_date', '=', 'latestDate.latest_action_date');
            })
            ->join('Action_Type', 'Action_Type.act_id', '=', 'Action.a_type')
            ->join('Group', 'Group.gid', '=', 'User_Groups.gid')
            ->join('User', 'User.uid', '=', 'Group.g_owner')
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
