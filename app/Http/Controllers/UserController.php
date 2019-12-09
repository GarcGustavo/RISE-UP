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
        $users = User::all();


        if ($users) {
            return UserResource::collection($users);
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
            'first' => 'bail|required|string|max:32',
            'last' => 'bail|required|string|max:32',
            'contact_email' => 'bail|required|email|max:32',
            'organization' => 'bail|string|required|max:32',
            'terms' => 'bail|required',
        ]);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);

        //If the validation fails send error to profile creation
        if ($validator->fails()) {
            $errors = json_encode($validator->errors()->all());
            return redirect('/profile-creation?email='. $request->input('email').'&errors='. $errors);
        }
        //create user
        $user = new User;
        $user->first_name = $request->input('first');
        $user->last_name = $request->input('last');
        $user->email = $request->input('email');
        $user->contact_email = $request->input('contact_email');
        $user->organization = $request->input('organization');
        $user->u_expiration_date = "2020-1-10";
        $user->u_creation_date = Carbon::now()->format('Y-m-d');
        $user->u_ban_status = 0;
        $user->current_edit_cid = null;
        $user->u_role = 2;
        $user->u_role_upgrade_request = 0;

        //process request
        if ($user->save()) {
            if ($request->session()->exists('user')) {
                // Session anomaly
                $request->session()->forget('user');
            }
            // Store the session data
            $request->session()->put('user', $user["uid"]);
            $message = 'Profile created sucessfully.';
            return redirect('/home?uid='.$user["uid"].'&message='.$message);
        } else {
            return abort(404);
        }
    }

    /**
     * Display the specified resource.
     * Verify if current user trying to login exist of not,
     * if not redirect to profile creation
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        //Get parameter value email, which is user email from Google Api
        $email = $request->input('e');

        //Verify if user's email exist in IReN
        $user = User::where(['email' => $email])->get();

        if (sizeOf($user) == 0) {
            //User dont exist in IReN
            return redirect('/profile-creation?email=' . $email);
        } else {
            //Forget info in temporary session with key 'user'
            $request->session()->forget('user');
            if ($user['0']["u_ban_status"] == 0) {
                // Store the users id in session data with key 'user', its used to verify user
                $request->session()->put('user', $user['0']["uid"]);

                return redirect('/home?uid=' . $user['0']["uid"]);
            } else {
                //The user is banned
                $error = 'The account associated with the email ' . $user['0']["email"] . ' has been banned.';
                return redirect('/?error='.$error);
            }
        }
    }

    /**
     * Return users currently editing specified cid
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function requestCollab(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::where(['uid' => $uid])->get();
        if (sizeOf($user) != 0) {
            if($user['0']["u_role_upgrade_request"]==0){
                User::where(['uid' => $uid])->update(['u_role_upgrade_request' => 1]);
                $message = 'Sucessfully requested Collaborator role.';
            }
            else{
                $message = 'Already requested Collaborator role.';
            }
        }
        else{
            $error = 'Invalid access.';
            return redirect('/?error=' . $error);
        }
        return redirect('/home?uid=' . $uid . '&message='.$message);
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGoogleInfo(Request $request)
    {
        //Store google api user's info in session with key 'u'
        $u = json_decode($request->session()->get('u'));

        return response()->json(['u'=>$u]);
    }


    /**
     * Return users currently editing specified cid
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUsersEditing(Request $request)
    {
        $cid = $request->input('cid');
        $user = User::where('current_edit_cid', "=", $cid)->get();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //rename attributes
        $attributes = array(
            'first' => 'first name',
            'last' => 'last name',
            'contact_email'  => 'contact email',
            'organization'  => 'organization',
        );
        //valiadate attributes of record
        $validator = Validator::make($request->all(), [
            'first' => 'bail|string|max:32',
            'last' => 'bail|string|max:32',
            'contact_email' => 'bail|email|max:32',
            'organization' => 'bail|string|max:32',
        ]);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);

        //If the validation fails send error to profile creation
        if ($validator->fails()) {
            $errors = json_encode($validator->errors()->all());
            return redirect('/user/profile?uid=' . $request->input('uid') . '&u_errors=' . $errors);
        }

        User::where(['uid' =>$request->input('uid')])->update(['organization' => $request->input('organization'), 'first_name' => $request->input('first') , 'last_name'=> $request->input('last'), 'contact_email' => $request->input('contact_email')]);
        $message = 'You have sucessfully updated you profile information.';
        return redirect('/user/profile?uid=' . $request->input('uid') . '&u_message=' . $message);

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
