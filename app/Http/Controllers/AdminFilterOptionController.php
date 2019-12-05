<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class AdminFilterOptionController extends Controller
{
    //public function store
    public function store(Request $request){
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

        $uid = $request->input('uid');;
        return redirect('/admin/filters?uid='.$uid);
    }

    //public function destroy
    public function destroy(Request $request){
        $id = $request->input('id');;
        $option = option::find($id);
        //dd($option);
        $option->delete();

        $uid = $request->input('uid');;
        return redirect('/admin/filters?uid='.$uid);
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

        $uid = $request->input('uid');;
        return redirect('/admin/filters?uid='.$uid);
    }

}
