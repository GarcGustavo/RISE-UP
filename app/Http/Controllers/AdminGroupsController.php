<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGroupsController extends Controller
{
    //public function index
    //Presents group name, group owner, a recent action, and creation date for each group.
	//Show only one action per group per day on index
	//Show all groups even when the group have no actions

    public function index(){
        $limitActionDate = DB::table('Action')
            ->join('User_Groups', 'User_Groups.uid', '=', 'Action.a_user')
            ->select('gid', DB::raw('MAX(a_date) as recent_action_date'))
            ->groupBy('User_Groups.gid');
            //->orderBy('recent_action_date', 'desc');

        $limitActionType = DB::table('Action')
			->join('User_Groups', 'User_Groups.uid', '=', 'Action.a_user')
            ->select('gid', 'a_date', DB::raw('MAX(a_type) as recent_action_type'))
            ->groupBy('gid')
			->groupBy('a_date');
            //->orderBy('recent_action_type', 'desc');	


        $groups = DB::table('User_Groups')
            ->joinSub($limitActionDate, 'limitActionDate','limitActionDate.gid', '=', 'User_Groups.gid')
            ->joinSub($limitActionType, 'limitActionType',  function ($join) {
                $join->on('limitActionType.gid', '=', 'User_Groups.uid')
                     ->on('limitActionType.a_date', '=', 'limitActionDate.recent_action_date');
            })
            ->join('Action_Type', 'Action_Type.act_id', '=', 'limitActionType.recent_action_type')
            ->rightJoin('Group', 'Group.gid', '=', 'User_Groups.gid')
            ->join('User', 'User.uid', '=', 'Group.g_owner')
            ->orderBy('recent_action_date', 'desc')
            //->orderBy('g_creation_date', 'desc')
            ->get();

        return view('admin.groups.index', ['groups'=> $groups]);
    }
}
