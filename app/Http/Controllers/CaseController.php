<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case_Study;
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
        $case_studies = Case_Study::all();

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
        $study = $request->isMethod('put') ? Case_Study::findOrFail($request->cid): new study;

        $study->c_title = $request -> input('c_title');
        $study->c_description = $request -> input('c_description');
        $study->c_thumbnail = $request -> input('c_thumbnail');
        $study->c_status = $request -> input('c_status');
        $study->c_date = $request -> input('c_date');
        $study->c_owner = $request -> input('c_owner');
        $study->c_group = $request -> input('c_group');

        if ($study->save()) {
            return new CaseResource($study);
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
        $study = Case_Study::findOrFail($id);

        return new CaseResource($study);
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
        $study = Case_Study::findOrFail($id);


        if ($study->delete()) {
            return new CaseResource($study);
        }
    }
}
