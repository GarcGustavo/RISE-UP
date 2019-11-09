<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\role;


class AdminController extends Controller
{





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





    //public function groups
    public function groups(){
        $groups = DB::table('group')
            ->join('user', 'group.g_owner', '=', 'user.uid')
            ->select('group.*', 'user.first_name', 'user.last_name')
            ->orderBy('group.g_creation_date', 'desc')
            ->get();

        return view('admin.groups', ['groups' => $groups]);
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





    //public function groupEdit
    public function groupEdit($id){

        $users = DB::table('user')
            ->select('user.*')
            ->where('uid', '=', $id)
            ->get();
        return view('admin.userEdit', ['user' => $users[0]]);
    }
}
?>
