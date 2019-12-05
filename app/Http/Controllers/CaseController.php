<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\case_study;
use App\Models\User_Groups;
use App\Models\Case_Parameters;
use App\Models\Group;
use App\Http\Resources\Case_Study as Case_StudyResource;
use App\Http\Resources\Group as GroupResource;
use Carbon\Carbon;
use DB;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @return \App\Http\Resources\case_study
     */
    public function index()
    {
        $cases = case_study::withTrashed()->get();

       if ($cases) {
            return Case_StudyResource::collection($cases);
        } else {
            return response()->json(['errors'=>'Error fetching all registered case studies - Origin: Case controller']);
        }
    }

    /**
     * Display the specified case study.
     *
     * @param  Request $request
     * @return \App\Http\Resources\case_study
     */
    public function show(Request $request)
    {
        $cid = $request->input('cid');

        $case = Case_Study::findOrFail($cid)
        ->where('Case.cid', $cid)
        ->get();

        return Case_StudyResource::collection($case);
    }

    /**
        * Display the case studies of the specified group.
        *
        * @param  Request $request
        * @return \App\Http\Resources\case_study
        */
    public function show_group_cases($id)
    {
        $gid = $id;

        $cases = Case_Study::where('Case.c_group', $gid)->get();

        return Case_StudyResource::collection($cases);
    }

     /**
        * Show a case study's group .
        * @param  \Illuminate\Http\Request  $request
        * @return \App\Http\Resources\Group
        */
    public function show_case_group(Request $request)
    {
        $gid = $request->input('gid');;

        $cases = Case_Study::where('Case.c_group', $gid)->get();
        $case_group = Group::
        where('Group.gid', $gid)
        ->join('Case', 'Case.c_group', '=', 'Group.gid')
        ->select('Group.*')
        ->get();
        $unique_data = $case_group->unique('gid');


        /*
          if ($unique_data) {
             return GroupResource::collection($unique_data);
          } else {
              return response()->json(['errors'=>'Error fetching case study - Origin: Case controller']);
          }
        */
        return GroupResource::collection($unique_data);
    }

    /**
     * Store a newly created case study in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //renaming attributes
        $attributes = array(
            'cid' => 'case study id',
            'c_title' => 'case study title',
            'c_description'  => 'case study description',
            'c_thumbnail' => 'case study thumbnail',
            'c_status' => 'case study status',
            'c_date' => 'case study creation date',
            'c_incident_date' => 'case study incident date',
            'c_owner' => 'case study author',
            'c_group' => 'case study group'
        );
        //validation rules
        $validator = Validator::make($request->all(), [

            'cid' => 'bail|required|unique:Case',
            'c_title' => 'bail|required|max:32',
            'c_description'  => 'bail|required|max:140',
            'c_thumbnail' => 'nullable',
            'c_status' => 'bail|required|in:active,disabled',
            'c_date' => 'bail|required|date_format:Y-m-d',
            'c_incident_date' => 'bail|nullable|date_format:Y-m-d',
            'c_owner' => 'bail|required|integer',
            'c_group' => 'nullable',
        ]);
        //apply renaming validation
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //create case study
        $case_study = $request->isMethod('put') ? case_study::findOrFail($request->cid) : new case_study;
        $case_study->cid = $request->input('cid');
        $case_study->c_title = $request->input('c_title');
        $case_study->c_description = $request->input('c_description');
        $case_study->c_thumbnail = $request->input('c_thumbnail');
        $case_study->c_status = $request->input('c_status');
        $case_study->c_date = $request->input('c_date');
        $case_study->c_incident_date = $request->input('c_incident_date');
        $case_study->c_owner = $request->input('c_owner');
        $case_study->c_group = $request->input('c_group');
        //process request
        if ($case_study->save()) {

            DB::table('Action')->insert([
                'a_date'=> now(),
                'a_user'=>  $case_study->c_owner,
                'a_type'=>  1,
            ]);

            return response()->json(['message'=>'Case study has been created']);
        } else {
            return response()->json(['errors'=>'Error creating case study - Origin: Case controller']);
        }
    }


    /**
        * Show group's case studies .
        * @param  \Illuminate\Http\Request  $request
        * @return \App\Http\Resources\Case_Study
        */
    public function showGroupCases(Request $request)
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
        //custom error message if group does not exist
        ], ['gid.exists' => 'The group id does not exists.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //process request
        $gid = $request->input('gid');

        $cases = Case_Study::where('Case.c_group', $gid)->get();
        if ($cases) {
            return Case_StudyResource::collection($cases);
        } else {
            return response()->json(['errors'=>'Error fetching group case studies - Origin: Case controller']);
        }
    }


    /**
        * Show a user's case studies .
        * @param  \Illuminate\Http\Request  $request
        * @return \App\Http\Resources\Case_Study
        */
    public function showAllUserCases(Request $request)
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
            //custom error message if user does not exist
        ], ['uid.exists' => 'The user id does not exists.']);
        //apply validation attributes
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //process request
        $uid = $request->input('uid');
        //cases by ownership and group relation
        $cases = Case_Study::where('Case.c_owner', $uid)->get();
        $group_cases = User_Groups::
        where('User_Groups.uid', $uid)
        ->join('Case', 'Case.c_group', '=', 'User_Groups.gid')
        ->whereNull('deleted_at')
        ->select('Case.*')
        ->get();

        $all_cases = $cases->concat($group_cases)->sortByDesc('cid');
        $unique_data = $all_cases->unique('cid'); //seeder duplicated data - Remove Later

        if ($unique_data) {
            return Case_StudyResource::collection($unique_data);
        } else {
            return response()->json(['errors'=>'Error fetching user case studies - Origin: Case controller']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCaseDetails(Request $request)
    {
        $c_thumbnail = $request->c_thumbnail;
        if($request->hasFile('image')){
            $validator = Validator::make($request->all(), [
                'image' => 'max:1024',
            ]);
            $c_thumbnail = time().'-'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $c_thumbnail);
        }
        $cid = $request->cid;
        $c_title = $request->c_title;
        $c_description = $request->c_description;
        $c_status = $request->c_status;
        $c_date = $request->c_date;
        $c_incident_date = $request->c_incident_date;
        $c_owner = $request->c_owner;
        $c_group = $request->c_group;

        Case_Study::where(['cid' => $cid])
        ->update([
            'c_title' => $c_title,
            'c_description' => $c_description,
            'c_thumbnail' => $c_thumbnail,
            'c_status' => $c_status,
            'c_date' => $c_date,
            'c_owner' => $c_owner
            ]);

        if($c_group == 0){
            Case_Study::where(['cid' => $cid])->update(['c_group' => NULL]);
        }
        else{
            Case_Study::where(['cid' => $cid])->update(['c_group' => $c_group]);
        }

        if(!$c_incident_date){
            Case_Study::where(['cid' => $cid])->update(['c_incident_date' => NULL]);
        }
        else{
            Case_Study::where(['cid' => $cid])->update(['c_incident_date' => Carbon::parse($c_incident_date)->toDateTimeString()]);
        }

        $uid = $request->input('uid');
        DB::table('Action')->insert([
            'a_date'=> now(),
            'a_user'=>  $uid,
            'a_type'=>  2,
        ]);
        return response()->json(['message'=>'Updated case successfully']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //data array
        $data = [ 'data' => $request->all() ];

        //renaming attributes
        $attributes = array(
            'data.*.cid' => 'case study id',
        );
        //validation rules
        $validator = Validator::make($data, [
            'data.*.cid' => 'bail|exists:Case|required|integer'
            //custom error message if cid does not exist
        ], ['data.*.cid.exists' => 'The case study id does not exists.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        //process request
        $to_delete = $request->all();
        $cids_to_delete = array_map(function ($item) {
            return $item['cid'];
        }, $to_delete);


        //uid data is the same
        $uid = $request->input('uid');

        $disabled = case_study::whereIn('cid', $cids_to_delete)->update(['c_status'=>'disabled']);
        $deleted = case_study::whereIn('cid', $cids_to_delete)->delete();


        if ($disabled && $deleted) {
            /*
            foreach($cids_to_delete as $cid){
            DB::table('Action')->insert([
                'a_date'=> now(),
                'a_user'=>  $uid,
                'a_type'=>  3,
            ]);
            }
            */
            return response()->json(['message'=>'Case(s) has been removed']);
        } else {
            return response()->json(['errors'=>'Error deleting case study - Origin: Case controller']);
        }
    }
}
