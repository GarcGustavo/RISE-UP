<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGroupsActionsController extends Controller
{
    //public function show
    //Presents recent actions for a particular group
    public function show(Request $request){
        $gid = $request->input('id');;
        $groups = DB::table('Group')
            ->select('g_name')
            ->where('gid', '=', $gid)
            ->get();

        $actions = DB::table('Group')
            ->join('User_Groups', 'User_Groups.gid', '=', 'Group.gid')
            ->join('Action', 'Action.a_user', '=', 'User_Groups.uid')
            ->join('User', 'User.uid', '=', 'User_Groups.uid')
            ->join('Action_Type', 'Action_Type.act_id', '=', 'Action.a_type')
            ->select('Group.*',  'Action.a_date', 'Action_Type.act_name', 'User.first_name', 'User.last_name')
            ->where('Group.gid', '=', $gid)
            ->orderBy('Action.a_date', 'desc')
            ->get();

            $uid = $request->input('uid');;
        return view('admin.groups-actions.show', ['groups' => $groups, 'actions' => $actions , 'uid' => $uid]);

    }
}
