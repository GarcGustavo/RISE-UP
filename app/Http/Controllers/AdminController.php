<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\role;


class AdminController extends Controller
{
    //public function users
	public function users(){

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
            ->orderBy('u_creation_date', 'desc')
            ->get();

		return view('admin.users', ['users' => $users, 'requests' => $requests]);
	}



    //public function log
    public function log(){
        $userActions = DB::table('user')
            ->join('role', 'user.u_role', '=', 'role.rid')
            ->select('user.*', 'r_name')
            ->orderBy('u_creation_date', 'desc')
            ->get();

        return view('admin.log', ['userActions' => $userActions]);
    }



    //public function groups
    public function groups(){
        $groups = DB::table('group')
            ->join('user', 'group.g_owner', '=', 'user.uid')
            ->select('group.*', 'user.first_name', 'user.last_name')
            ->orderBy('group.g_creation_date', 'desc')
            ->get();

        return view('admin.groups', ['groups' => $groups]);
    }






    //public function actions
    public function actions($userId){

        $usersName = DB::table('user')
            ->select('first_name', 'last_name')
            ->where('uid', '=', $userId)
            ->get();

        $actions = DB::table('user')
            ->join('action', 'user.uid', '=', 'action.a_user')
            ->join('action_type', 'action.a_type', '=', 'action_type.act_id')
            ->select('user.*',  'action.a_date', 'action_type.act_name')
            ->where('uid', '=', $userId)
            ->orderBy('action.a_date', 'desc')
            ->get();

        return view('admin.actions', ['usersName' => $usersName, 'actions' => $actions]);
    }



    //public function filters
    public function filters(){

        $filters = DB::table('cs_parameter')
            ->select('cs_parameter.*')
            ->get();

        $options = DB::table('option')
            ->select('option.*')
            ->get();

        return view('admin.filters', ['filters' => $filters, 'options' => $options]);
    }


    //public function userEdit
    public function userEdit($id){

        $users = DB::table('user')
            ->select('user.*')
            ->where('uid', '=', $id)
            ->get();
        return view('admin.userEdit', ['user' => $users[0]]);
    }

    //public function userUpdate
    public function userUpdate($uid){
        $validatedData = request()->validate([
            'u_role' => ['required'],
            'u_expiration_date' => ['required'],
            'u_ban_status' => ['required'],
            'u_role_upgrade_request' => ['required'],
        ]);

         $user = user::where('uid', $uid)->first(); // ->firstOrFail();
      //dd($user);
         $user->u_role = $validatedData['u_role'];
         $user->u_expiration_date = $validatedData['u_expiration_date'];
         $user->u_ban_status = $validatedData['u_ban_status'];
         $user->u_role_upgrade_request = $validatedData['u_role_upgrade_request'];
      //dd($user);
         $user->save();
         return redirect('/admin/users');
    }
}
?>
