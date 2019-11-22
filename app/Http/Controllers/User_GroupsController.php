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
     * Store a newly created group-user member relationship in storage.
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
            'data.*.gid' => ['bail','exists:Group','required','integer',
            //if exists verify group has not been removed
            Rule::exists('Group')->where(function ($query) use ($gids) {
                return $query->whereIn('gid', $gids)->whereNull('deleted_at');
            })],
            'data.*.uid' => ['bail','exists:User','required', 'integer',
            //if exists verify has user been banned
            Rule::exists('User')->where(function ($query) use ($uids) {
                return $query->whereIn('uid', $uids)->whereNull('deleted_at');
            }),
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
        $inserted = User_Groups::insert($user_group); //insert array

        if ($inserted) {
            return response()->json(['message'=>'User(s) has been added to the group']);
        } else {
            return response()->json(['errors'=>'Error adding users to group - Origin: User Group controller']);
        }
    }


    /**
     * Display the members of a specified group.
     * @param  \Illuminate\Http\Request  $request
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
            'gid' => ['bail','exists:Group','required','integer',
            //if exist verify group has not been removed
            Rule::exists('Group')->where(function ($query) use ($request) {
                return $query->where('gid', $request->input('gid'))->whereNull('deleted_at');
            })]
        ], ['gid.exists' => 'The group id does not exists.']);
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

        if ($members) {
            return UserResource::collection($members);
        } else {
            return response()->json(['errors'=>'Error fetching members - Origin: User Group controller']);
        }
    }


    /**
     * Remove the specified group-user member relation from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //store group id's
        $gids= array_map(function ($item) {
            return $item['gid'];
        }, $request->all());
        //store user id's
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
        ], ['data.*.uid.exists' => 'The user id does not exists in this group.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        //valida request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //if validated remove records

        //process request
        $deleted = User_Groups::whereIn('gid', $gids)->whereIn('uid', $uids)->delete();

        if ($deleted) {
            return response()->json(['message'=>'User(s) has been removed from group']);
        } else {
            return response()->json(['errors'=>'Error removing member from group - Origin: User Group controller']);
        }
    }
}
