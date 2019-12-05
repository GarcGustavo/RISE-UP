<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\cs_parameter;
use Illuminate\Http\Request;

class AdminFilterCategoryController extends Controller
{
    //public function store
    public function store(Request $request){
        $validatedData = request()->validate([
            'csp_name' => ['required', 'string'],
        ]);

        $cs_parameter = new cs_parameter();
        //dd($user);
        $cs_parameter->csp_name = $validatedData['csp_name'];
        //dd($user);
        $cs_parameter->save();

        $uid = $request->input('uid');;
        return redirect('/admin/filters?uid='.$uid);
    }


    //public function destroy
    public function destroy(Request $request){
        $id = $request->input('id');;
        $cs_parameter = cs_parameter::find($id);
        //dd($option);
        $cs_parameter->delete();

        $uid = $request->input('uid');;
        return redirect('/admin/filters?uid='.$uid);
    }

	
	//public function update
    public function update(Request $request){
        $id = $request->input('id');;
        $validatedData = request()->validate([
            'csp_name' => ['required', 'string'],
        ]);

        $cs_parameter = cs_parameter::find($id);
        //dd($user);
        $cs_parameter->csp_name = $validatedData['csp_name'];
        //dd($user);
        $cs_parameter->save();

        $uid = $request->input('uid');;
        return redirect('/admin/filters?uid='.$uid);
    }	
}
