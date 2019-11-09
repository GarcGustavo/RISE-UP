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
        $groups = DB::table('group')
            ->join('user', 'user.uid', '=', 'group.g_owner')
            ->select('group.*', 'user.first_name', 'user.last_name')
            ->orderBy('group.g_creation_date', 'desc')
            ->get();

        return view('admin.groups.index', ['groups' => $groups]);
    }
}
