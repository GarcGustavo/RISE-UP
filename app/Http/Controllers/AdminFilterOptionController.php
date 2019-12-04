<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class AdminFilterOptionController extends Controller
{
    //public function store
    public function store(){
        $validatedData = request()->validate([
            'o_parameter' => ['required', 'numeric'],
            'o_content' => ['required', 'string'],
        ]);

        $option = new option();
        //dd($option);
        $option->o_parameter = $validatedData['o_parameter'];
        $option->o_content = $validatedData['o_content'];
        //dd($option);
        $option->save();
        return redirect('/admin/filters');
    }

    //public function destroy
    public function destroy(Request $request){
        $id = $request->input('id');;
        $option = option::find($id);
        //dd($option);
        $option->delete();
        return redirect('/admin/filters');
    }
	
	//public function update
    public function update(Request $request){
        $id = $request->input('id');;
        $validatedData = request()->validate([
            'o_parameter' => ['required', 'numeric'],
            'o_content' => ['required', 'string'],
        ]);

        $option = option::find($id);
        //dd($option);
        $option->o_parameter = $validatedData['o_parameter'];
        $option->o_content = $validatedData['o_content'];
        //dd($option);
        $option->save();
        return redirect('/admin/filters');
    }

}
