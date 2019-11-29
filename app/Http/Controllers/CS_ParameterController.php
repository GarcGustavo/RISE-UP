<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\CS_Parameter;
use App\Http\Resources\CS_Parameter as CS_ParameterResource;
use App\Http\Resources\Option as OptionResource;

class CS_ParameterController extends Controller
{
      /**
     * Display listing of case study parameters
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\cs_parameter
     */
    public function getParameters()
    {
        $parameters = CS_Parameter::all();
        return CS_ParameterResource::collection($parameters);
    }


     /**
     * Get the options of a parameter
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\cs_parameter
     */
    public function getParameterOptions()
    {
        $options = Option::all();
        return OptionResource::collection($options);
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
