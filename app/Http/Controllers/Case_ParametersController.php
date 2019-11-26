<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case_Study;
use App\Models\Case_Parameters;
use App\Models\CS_Parameter;
use App\Models\Option;
use App\Http\Resources\Case_Parameters as Case_ParametersResource;
use App\Http\Resources\Option as OptionResource;

class Case_ParametersController extends Controller
{
    // public function getParameters()
    // {
    //     $parameters = CS_Parameter::all();
    //     return CS_ParameterResource::collection($parameters);
    // }

    // public function getParameterOptions()
    // {
    //     $options = Option::all();
    //     return OptionResource::collection($options);
    // }

    public function getCaseParameters($id)
    {
/*
        //renaming attributes
        $attributes = array(
            'cid' => 'case study id',
        );
        //validation rules
        $validator = Validator::make($request->all(), [
            'cid' => ['bail','exists:Case','required','integer',
            //if exist verify case study has not been removed
            Rule::exists('Case')->where(function ($query) use ($request) {
                return $query->where('cid', $request->input('cid'))->whereNull('deleted_at');
            })]
        ], ['cid.exists' => 'The case study id does not exists.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
*/

        //process request
        $cid = $id;
        $caseParams = Case_Parameters::
        where('cid', $cid)
        ->join('CS_Parameter', 'Case_Parameters.csp_id', '=', 'CS_Parameter.csp_id')
        ->join('Option', 'Case_Parameters.opt_selected', '=', 'Option.oid')
        ->select('Case_Parameters.cid','Case_Parameters.opt_selected', 'Case_Parameters.csp_id', 'CS_Parameter.csp_name', 'Option.o_content')
        ->get();
/*
        if ($caseParams) {
           return Case_ParametersResource::collection($caseParams);
        } else {
            return response()->json(['errors'=>'Error fetching case parameters - Origin: Case Parameters controller']);
        }
*/
        return Case_ParametersResource::collection($caseParams);
    }
    public function getCaseSelectedOptions($id)
    {

/*
        //renaming attributes
        $attributes = array(
            'cid' => 'case study id',
        );
        //validation rules
        $validator = Validator::make($request->all(), [
            'cid' => ['bail','exists:Case','required','integer',
            //if exist verify case study has not been removed
            Rule::exists('Case')->where(function ($query) use ($request) {
                return $query->where('cid', $request->input('cid'))->whereNull('deleted_at');
            })]
        ], ['cid.exists' => 'The case study id does not exists.']);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
*/

        $cid = $id;
        $caseOps = Case_Parameters::
        where('cid', $cid)
        ->join('Option', 'Case_Parameters.opt_selected', '=', 'Option.oid')
        ->select('Case_Parameters.opt_selected', 'Option.o_content')
        ->get();
/*
        if ($caseOps) {
            return Case_ParametersResource::collection($caseOps);
        } else {
            return response()->json(['errors'=>'Error fetching case parameters selected option - Origin: Case Parameters controller']);
        }
*/
        return Case_ParametersResource::collection($caseOps);
    }
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
        //
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
