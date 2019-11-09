<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUsersRequestsController extends Controller
{
    //public function index
    public function index(){

        //Creates the list of users to be sent to the view
        //A join is made with the 'user' and 'role' table in order to provide
        //the view the role names 'r_name' in addition to 'user' attributes
        //The method orders the user by creation date and in descending order
        //before sending them to the view.
        //Section 1.62 on Software Requirement Specifications Documents
        $users = DB::table('user')
            ->join('role', 'user.u_role', '=', 'role.rid')
            ->select('user.*', 'r_name')
            ->orderBy('u_creation_date', 'desc')
            ->get();

        //Creates the list of users who have sent a request to become collaborators
        //The method selects those users who have:
        // a user attribute of ban status = zero
        // a user attribute of role = 1 (Viewer role)
        // a user attribute of role upgrade request = 1
        //Section 1.64 on Software Requirement Specifications Documents
        $requests = DB::table('user')
            ->join('role', 'user.u_role', '=', 'role.rid')
            ->select('user.*', 'r_name')
            ->where('u_role_upgrade_request', 1)
            ->where('u_role', 1)
            ->where('u_ban_status', 0)
            ->get();

        return view('admin.users-requests.index', ['users' => $users, 'requests' => $requests]);
    }
}
