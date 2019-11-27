<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGroupsActionsController extends Controller
{
    //public function show
    //Presents recent actions for a particular group
    public function show($id){
        $groups = DB::table('group')
            ->select('g_name')
            ->where('gid', '=', $id)
            ->get();

        $actions = DB::table('group')
            ->join('user_groups', 'user_groups.gid', '=', 'group.gid')
            ->join('action', 'action.a_user', '=', 'user_groups.uid')
            ->join('user', 'user.uid', '=', 'user_groups.uid')
            ->join('action_type', 'action_type.act_id', '=', 'action.a_type')
            ->select('group.*',  'action.a_date', 'action_type.act_name', 'user.first_name', 'user.last_name')
            ->where('group.gid', '=', $id)
            ->orderBy('action.a_date', 'desc')
            ->get();

        return view('admin.groups-actions.show', ['groups' => $groups, 'actions' => $actions]);

    }
}
