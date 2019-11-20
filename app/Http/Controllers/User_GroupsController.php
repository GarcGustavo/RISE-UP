<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User_Groups;
use App\Http\Resources\User as UserResource;

class User_GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //store groups id's
        $gids= array_map(function ($item) {
            return $item['gid'];
        }, $request->all());

        //store user id's
        $uids = array_map(function ($item) {
            return $item['uid'];
        }, $request->all());

        //data array
        $data_arr = [ 'data' => $request->all() ];

        //renaming attributes for messages
        $attributes = array(
            'data.*.gid' => 'group id',
            'data.*.uid' => 'user id'
        );

        //validate each gid/uid
        $validator = Validator::make($data_arr, [
            'data.*.gid' => 'bail|required|integer',
            'data.*.uid' => ['bail','required', 'integer',
            //verifies if record already exist
            Rule::unique('User_Groups')->where(function ($query) use ($gids,$uids) {
                return $query->whereIn('gid', $gids)
                ->whereIn('uid', $uids);
            })
            ]//custom message
        ], ['data.*.uid.unique' => 'The user id already exists in this group.']);
        $validator->setAttributeNames($attributes); //apply renaming attributes
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //if validated add records
        $data = $request->all();
        $user_group = [];
        foreach ($data as $key=>$value) {
            array_push($user_group, [
            'gid' => $value['gid'],
            'uid' => $value['uid']]);
        }
        User_Groups::insert($user_group);
        return response()->json(['message'=>'User(s) has been added to the group']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMembers(Request $request)
    {
        //renaming attributes
        $attributes = array(
            'gid' => 'group id',
        );
        //validation rules
        $validator = Validator::make($request->all(), [
            'gid' => 'bail|exists:Group|required|integer'
        ],['gid.exists' => 'The group id does not exists.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //process request
        $gid = $request->input('gid');

        $members = User_Groups::
        where('gid', $gid)
        ->join('User', 'User_Groups.uid', '=', 'User.uid')
        ->select('User.*')
        ->get();

        return UserResource::collection($members);

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
    public function destroy(Request $request)
    {
        //store group id's
        $gids= array_map(function ($item) {
            return $item['gid'];
        }, $request->all());
        //store user d's i
        $uids = array_map(function ($item) {
            return $item['uid'];
        }, $request->all());

        //data array
        $data = [ 'data' => $request->all() ];

        //renaming attributes for messages
        $attributes = array(
            'data.*.gid' => 'group id',
            'data.*.uid' => 'user id'
        );

        //validation rules
        $validator = Validator::make($data, [
            'data.*.gid' => 'bail|required|integer',
            'data.*.uid' => ['bail','required','integer',
            //verifies if record exists
            Rule::exists('User_Groups')->where(function ($query) use ($gids,$uids) {
                return $query->whereIn('gid', $gids)
                ->whereIn('uid', $uids);
            })
            ]//custom error message if uid does not exist
        ],['data.*.uid.exists' => 'The user id does not exists in this group.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        //valida request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //if validated remove records

        //process request
        User_Groups::whereIn('gid', $gids)->whereIn('uid', $uids)->delete();
        return response()->json(['message'=>'User(s) has been removed from group']);
    }
}
