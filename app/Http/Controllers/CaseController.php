<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case;
use App\Http\Resources\Case_Study as CaseResource;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Case_Study::all();

        return CaseResource::collection($case_studies);
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
        $case_study = $request->isMethod('put') ? case_study::findOrFail($request->cid): new case_study;

        $case_study->c_title = $request -> input('c_title');
        $case_study->c_description = $request -> input('c_description');
        $case_study->c_thumbnail = $request -> input('c_thumbnail');
        $case_study->c_status = $request -> input('c_status');
        $case_study->c_date = $request -> input('c_date');
        $case_study->c_owner = $request -> input('c_owner');
        $case_study->c_group = $request -> input('c_group');

        if ($case_study->save()) {
            return new CaseResource($case_study);
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
        $case_study = Case_Study::findOrFail($id);

        return new CaseResource($case_study);
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
        $case_study = Case_Study::findOrFail($id);


        if ($case_study->delete()) {
            return new CaseResource($case_study);
        }
    }
}
