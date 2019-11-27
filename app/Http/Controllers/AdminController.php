<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\role;


class AdminController extends Controller
{
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
