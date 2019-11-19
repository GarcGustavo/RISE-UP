<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->isMethod('put') ? User::findOrFail($request->uid): new User;

        $user->uid = $request -> input('uid');
        $user->first_name = $request -> input('first_name');
        $user->last_name = $request -> input('last_name');
        $user->email = $request -> input('email');
        $user->contact_email = $request -> input('contact_email');
        $user->u_creation_date = $request -> input('u_creation_date');
        $user->u_ban_status = $request -> input('u_ban_status');
        $user->current_edit_cid = $request -> input('current_edit_cid');
        $user->u_role = $request -> input('u_role');
        $user->delete_at = null;

        if ($user->save()) {
            return new UserResource($user);
        }
    }

    /**
     * Return users currently editing specified cid
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUsersEditing($id)
    {
        $cid = $id;
        $user = User::where('User.current_edit_cid', $cid)->get();
        return UserResource::collection($user);
    }

    /**
     * Return users currently editing specified cid
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUsersEditing(Request $request, $id)
    {
        $uid = $id;
        $current_edit_cid = $request -> input('current_edit_cid');
        User::where(['uid' => $uid])->update(['current_edit_cid' => $current_edit_cid]);
        return response()->json(['message'=>'Updated user editing successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uid = $id;

        $user = User::where('User.uid', $uid)->get();
        return UserResource::collection($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
