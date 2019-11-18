<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\case_study;
use App\Models\User_Groups;
use App\Http\Resources\Case_Study as Case_StudyResource;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cases = case_study::withTrashed()->get();

        return Case_StudyResource::collection($cases);
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
        $attributes = array(
            'cid' => 'case study id',
            'c_title' => 'case study title',
            'c_description'  => 'case study description',
            'c-thumbnail' => 'case study thumbnail',
            'c_status' => 'case study status',
            'c_date' => 'case study creation date',
            'c_owner' => 'case study author',
            'c_group' => 'case study group'
        );
        $validator = Validator::make($request->all(), [

            'cid' => 'bail|required|unique:Case',
            'c_title' => 'bail|required|max:32',
            'c_description'  => 'bail|required|max:140',
            'c-thumbnail' => 'nullable',
            'c_status' => 'bail|required',
            'c_date' => 'bail|required|date_format:Y-m-d',
            'c_owner' => 'bail|required',
            'c_group' => 'nullable',
        ]);

        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }

        $case_study = $request->isMethod('put') ? case_study::findOrFail($request->cid) : new case_study;
        $case_study->cid = $request->input('cid');
        $case_study->c_title = $request->input('c_title');
        $case_study->c_description = $request->input('c_description');
        $case_study->c_thumbnail = $request->input('c_thumbnail');
        $case_study->c_status = $request->input('c_status');
        $case_study->c_date = $request->input('c_date');
        $case_study->c_owner = $request->input('c_owner');
        $case_study->c_group = $request->input('c_group');

        if ($case_study->save()) {
            return response()->json(['message'=>'Case study has been created']);
        }
        else{
            return response()->json(['errors'=>'Error creating case study from controller']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showGroupCases($id)
    {
        $gid = $id;

        $cases = Case_Study::where('Case.c_group', $gid)->get();
        return Case_StudyResource::collection($cases);
    }

    public function showAllUserCases($id)
    {
        $uid = $id;

        $cases = Case_Study::where('Case.c_owner', $uid)->get();
        $group_cases = User_Groups::
        where('User_Groups.uid', $uid)
        ->join('Case', 'Case.c_group', '=', 'User_Groups.gid')
        ->whereNull('deleted_at')
        ->select('Case.*')
        ->get();

        $all_cases = $cases->concat($group_cases);
        $unique_data = $all_cases->unique('cid')->sortByDesc('cid');

        return Case_StudyResource::collection($unique_data);
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

        $data = [ 'data' => $request->all() ];

        $attributes = array(
            'data.*.cid' => 'case study id',
        );
        $validator = Validator::make($data, [
            'data.*.cid' => 'bail|exists:Case|required|integer'
        ]);
        $validator->setAttributeNames($attributes);
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }

        $to_delete = $request->all();
        $cids_to_delete = array_map(function ($item) {
            return $item['cid'];
        }, $to_delete);
        case_study::whereIn('cid', $cids_to_delete)->update(['c_status'=>'disabled']);
        case_study::whereIn('cid', $cids_to_delete)->delete();
        return response()->json(['message'=>'Case(s) has been removed']);
    }
}
