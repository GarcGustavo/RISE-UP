<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Group;
use App\Models\User_Groups;
use App\Http\Resources\Group as GroupResource;

class GroupController extends Controller
{
    /**
     * Return a listing of all system's groups.
     * @return \App\Http\Resources\Group
     */
    public function index()
    {
        $groups = Group::withTrashed()->get();

        if ($groups) {
            return GroupResource::collection($groups);
        } else {
            return response()->json(['errors'=>'Error fetching all registered groups - Origin: Group controller']);
        }
    }

    /**
         * Return data of a specified group.
         * @return \App\Http\Resources\Group
         */
    public function info(Request $request)
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
        $group = Group::where('gid', $gid)->get();

        if ($group) {
            return GroupResource::collection($group);
        } else {
            return response()->json(['errors'=>'Error fetching group info - Origin: Group controller']);
        }
    }

    /**
     * Store a newly created group in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //rename attributes
        $attributes = array(
            'gid' => 'group id',
            'g_name' => 'group name',
            'g_status'  => 'group status',
            'g_reaction_date' => 'group creation date',
            'g_owner' => 'group owner'
        );
        //valiadate attributes of record
        $validator = Validator::make($request->all(), [
            'gid' => 'bail|required|unique:Group',
            'g_name' => 'bail|required|max:32',
            'g_status' => 'bail|required|in:active',
            'g_creation_date' => 'bail|required|date_format:Y-m-d',
            'g_owner' => 'bail|required',
        ]);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //create group
        $group = new Group;
        $group->gid = $request -> input('gid');
        $group->g_name = $request -> input('g_name');
        $group->g_status = $request -> input('g_status');
        $group->g_creation_date = $request -> input('g_creation_date');
        $group->g_owner = $request -> input('g_owner');
        //process request
        if ($group->save()) {
            return response()->json(['message'=>'Group has been created']);
        } else {
            return response()->json(['errors'=>'Error creating group - Origin: Group controller']);
        }
    }


    /**
     * Display a user's list of groups.
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\Group
     */
    public function showGroups(Request $request)
    {
        //renaming attributes
        $attributes = array(
            'uid' => 'user id',
        );
        //validation rules
        $validator = Validator::make($request->all(), [
            'uid' => ['bail','exists:User','required','integer',
            //if exist verify user has not been banned
            Rule::exists('User')->where(function ($query) use ($request) {
                return $query->where('uid', $request->input('uid'))->whereNull('deleted_at');
            })]
            //custom error message if uid does not exist
        ], ['uid.exists' => 'The user id does not exists.']);
        //apply validation request
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //process request
        $uid = $request->input('uid');
        //groups by member relation
        $groups = User_Groups::
        where('User_Groups.uid', $uid)
        ->join('Group', 'User_Groups.gid', 'Group.gid')
        ->whereNull('Group.deleted_at')
        ->select('Group.*')
        ->orderBy('gid', 'DESC')
        ->get();

        if ($groups) {
            return GroupResource::collection($groups);
        } else {
            return response()->json(['errors'=>'Error fetching groups - Origin: Group controller']);
        }
    }


    /**
     * Update the specified group's name in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //rename attributes
        $attributes = array(
            'gid' => 'group id',
            'g_name' => 'group name',

        );
        //validation rules
        $validator = Validator::make($request->all(), [
            'gid' => ['bail','exists:Group','required',

            //if exist verify group has not been removed
            Rule::exists('Group')->where(function ($query) use ($request) {
                return $query->where('gid', $request->input('gid'))->whereNull('deleted_at');
            })],
            'g_name' => 'bail|required|max:32',

            //custom error message if gid does not exist
        ], ['gid.exists' => 'The group id does not exists.']);

        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //process request
        $group = Group::where('gid', $request->input('gid'))->first();

        $group->g_name=$request->input('g_name');

        if ($group->save()) {
            return response()->json(['message'=>'Changed group name successfully']);
        } else {
            return response()->json(['errors'=>'Error editing group name - Origin: Group controller']);
        } //
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //assign request to data array
        $data = [ 'data' => $request->all() ];
        //renaming attributes
        $attributes = array(
            'data.*.gid' => 'group id',
        );
        //validate request rules
        $validator = Validator::make($data, [
            'data.*.gid' => 'bail|exists:Group|required|integer'
            //custom error message if gid does not exist
        ], ['data.*.gid.exists' => 'The group id does not exist.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //process request
        $to_delete = $request->all();
        $gids_to_delete = array_map(function ($item) {
            return $item['gid'];
        }, $to_delete);

        $disabled =  Group::whereIn('gid', $gids_to_delete)->update(['g_status'=>'disabled']);
        $deleted = Group::whereIn('gid', $gids_to_delete)->delete();

        //return response
        if ($disabled && $deleted) {
            return response()->json(['message'=>'Group(s) has been removed']);
        } else {
            return response()->json(['errors'=>'Error deleting group - Origin: Group controller']);
        }
    }
}
