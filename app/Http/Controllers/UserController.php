<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Group::withTrashed()->get();

        if ($users) {
            return GroupResource::collection($users);
        } else {
            return response()->json(['errors' => 'Error fetching all registered users - Origin: User controller']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //rename attributes
        $attributes = array(
            'first' => 'first name',
            'last' => 'last name',
            'contact_email'  => 'contact email',
            'organization'  => 'organization',
            'terms' => 'Terms and Conditions'
        );
        //valiadate attributes of record
        $validator = Validator::make($request->all(), [
            'first' => 'bail|required|max:32',
            'last' => 'bail|required|max:32',
            'contact_email' => 'bail|required|email',
            'organization' => 'bail|required',
            'terms' => 'bail|required',
        ]);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        //create group
        $user = new User;
        $user->first_name = $request->input('first');
        $user->last_name = $request->input('last');
        $user->email = $request->input('email');
        $user->contact_email = $request->input('contact_email');
        $user->u_expiration_date = "2020-1-10";
        $user->u_creation_date = Carbon::now()->format('Y-m-d');
        $user->u_ban_status = 0;
        $user->current_edit_cid = null;
        $user->u_role = 1;
        $user->u_role_upgrade_request = 0;

        //process request
        if ($user->save()) {
            if ($request->session()->exists('user')) {
                // Session anomaly
                $request->session()->forget('user');
            }
            // Store the session data
            $request->session()->put('user', $user["uid"]);
            $request->session()->flash('message', 'Profile has been created!');
            return redirect('/home?uid='.$user["uid"]);
        } else {
            return abort(404);
        }
    }

    /**
     * Return users currently editing specified cid
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUsersEditing(Request $request)
    {
        $cid = $request -> input('cid');
        $user = User::where('User.current_edit_cid', $cid)->get();
        return UserResource::collection($user);
    }

    /**
     * Return users currently editing specified cid
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUsersEditing(Request $request)
    {
        $uid = $request -> input('uid');
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
    public function show(Request $request)
    {
        $uid = $request->input('uid');

        $user = User::findOrFail($uid)
        ->where('User.uid', $uid)
        ->get();

        return UserResource::collection($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findToLogin(Request $request)
    {
        $validatedData = $request->validate([
            '_token' => "bail|required",
            'email' => "required|email",
        ]);
        $email = $request->input('email');
        $user = User::where(['email' => $email])->get();

        if(sizeOf($user) == 0){
            return redirect('/profile-creation?email='.$email);
        }
        else{
            if ($request->session()->exists('user')) {
                // Session anomaly
                $request->session()->forget('user');
            }
            // Store the session data
            $request->session()->put('user', $user['0']["uid"]);

            return redirect('/home?uid='.$user['0']["uid"]);
        }
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
