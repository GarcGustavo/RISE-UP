<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User_Groups;
use App\Http\Resources\Group as GroupResource;
use App\Http\Resources\User_Groups as User_GroupsResource;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();

        return GroupResource::collection($groups);
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
        $group = $request->isMethod('put') ? group::findOrFail($request->gid): new group;

        $group->gid = $request -> input('gid');
        $group->gname = $request -> input('gname');
        $group->g_status = $request -> input('g_status');
        $group->g_creation_date = $request -> input('g_creation_date');
        $group->g_owner = $request -> input('g_owner');

        if ($group->save()) {
            return new GroupResource($group);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_groups($id)
    {
        //$group = Group::findOrFail($id);

        //  return new GroupResource($group);

        $uid = $id;
        $groups = User_Groups::
        where('User_Groups.uid', $uid)
        ->join('User', 'User_Groups.uid', '=', 'User.uid')
        ->join('Group', 'User_Groups.gid', '=', 'Group.gid')
        ->select('Group.*')
        ->get();

       return GroupResource::collection($groups);

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
        $group = Group::findOrFail($id);


        if ($group->delete()) {
            return new GroupResource($group);
        }
    }
}
