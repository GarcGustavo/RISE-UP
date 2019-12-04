<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUsersRequestsController extends Controller
{
    //public function index
    public function index(Request $request){

        $id = $request->input('id');;

        //Creates the list of users to be sent to the view
        //A join is made with the 'user' and 'role' table in order to provide
        //the view the role names 'r_name' in addition to 'user' attributes
        //The method orders the user by creation date and in descending order
        //before sending them to the view.
        //Section 1.62 on Software Requirement Specifications Documents
        $users = DB::table('User')
            ->join('Role', 'User.u_role', '=', 'Role.rid')
            ->select('User.*', 'r_name')
            ->orderBy('u_creation_date', 'desc')
            ->get();

        //Creates the list of users who have sent a request to become collaborators
        //The method selects those users who have:
        // a user attribute of ban status == zero
		// a user attribute of role upgrade request == 1
        // a user attribute of u_role == 2 (Viewer role)
        //Section 1.64 on Software Requirement Specifications Documents
        $requests = DB::table('User')
            ->join('Role', 'User.u_role', '=', 'Role.rid')
            ->select('User.*', 'r_name')
            ->where('u_ban_status', 0)
			->where('u_role_upgrade_request', 1)
			->where('u_role', 2)
            ->get();

        return view('admin.users-requests.index', ['users' => $users, 'requests' => $requests]);
    }
}
