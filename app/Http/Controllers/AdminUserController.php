<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    //public function edit
    public function edit(Request $request){
        $urtd = $request->input('urtd');;
        $uid = $request->input('uid');;
        $users = DB::table('User')
            ->select('User.*')
            ->where('uid', '=', $urtd)
            ->get();
        return view('admin.user.edit', ['users' => $users, 'uid'=> $uid]);
    }


    //public function update
    public function update(Request $request){
        $urtd = $request->input('urtd');;
        $uid = $request->input('uid');;
        $validatedData = request()->validate([
            'u_role' => ['required'],
            'u_expiration_date' => ['required'],
            'u_ban_status' => ['required'],
            'u_role_upgrade_request' => ['required'],
        ]);

        $user = user::where('uid', $urtd)->first(); // ->firstOrFail();
        //dd($user);
        $user->u_role = $validatedData['u_role'];
        $user->u_expiration_date = $validatedData['u_expiration_date'];
        $user->u_ban_status = $validatedData['u_ban_status'];
        $user->u_role_upgrade_request = $validatedData['u_role_upgrade_request'];
        //dd($user);
        $user->save();
        return redirect('/admin/users-requests?uid='.$uid);
    }
}
