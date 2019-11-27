<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\cs_parameter;
use Illuminate\Http\Request;

class AdminFilterCategoryController extends Controller
{
    //public function store
    public function store(){
        $validatedData = request()->validate([
            'csp_name' => ['required', 'string'],
        ]);

        $cs_parameter = new cs_parameter();
        //dd($user);
        $cs_parameter->csp_name = $validatedData['csp_name'];
        //dd($user);
        $cs_parameter->save();
        return redirect('/admin/filters');
    }

    //public function destro
    public function destroy($id){
        $cs_parameter = cs_parameter::find($id);
        //dd($option);
        $cs_parameter->delete();
        return redirect('/admin/filters');
    }
}
