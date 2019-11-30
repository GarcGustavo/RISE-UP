<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\case_study;

class ViewsController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function help()
    {
        return view('help');
    }

    public function group(Request $request)
    {
        //renaming attributes
        $attributes = array(
        'uid' => 'user id',
        'gid' => 'group id',
    );
        //validation rules
        $validator = Validator::make($request->all(), [

        'uid' => ['bail','exists:User','required','integer',
            //if exist verify user has not been banned
            Rule::exists('User')->where(function ($query) use ($request) {
                return $query->where('uid', $request->input('uid'))->whereNull('deleted_at');
            })],
        'gid' => ['bail','exists:Group','required','integer',
        //if exist verify group has not been removed
          Rule::exists('Group')->where(function ($query) use ($request) {
              return $query->where('gid', $request->input('gid'))->whereNull('deleted_at');
          })]
             ]);
        //apply renaming attributes
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return abort(404);
        }

        return view('group');
    }


    public function userGroups(Request $request)
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
        //custom error message if uid does not exist
    ]);
        //apply validation request
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return abort(404);
        }

        return view('user-groups');
    }


    public function userCases(Request $request)
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
        //custom error message if uid does not exist
    ]);
        //apply validation request
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return abort(404);
        }

        return view('user-cases');
    }

    public function showCaseBody(Request $request)
    {
        //renaming attributes
        $attributes = array(
            'cid' => 'case id',
            );
        //validation rules
        $validator = Validator::make($request->all(), [
            'cid' => ['bail','exists:Case','required','integer',
            //if exist verify user has not been banned
            Rule::exists('Case')->where(function ($query) use ($request) {
                return $query->where('cid', $request->input('cid'))->whereNull('deleted_at');
            })]
            //custom error message if uid does not exist
        ]);
        //apply validation request
        $validator->setAttributeNames($attributes);
        //validate request
        if ($validator->fails()) {
            return abort(404);
        }

        $cid = $request->input('cid');
        return view('case_study_body')->with('cid', $cid);
    }

    public function search(Request $request)
    {
        $validate =Validator::make($request->all(), [
            'q' => 'required|not_in:+'
        ]);


        $q = $request->input('q');
        $case_study_without_content = case_study::where('c_title', 'LIKE', '%'.$q.'%')->orWhere('c_description', 'LIKE', '%'.$q.'%')->get();
        $case_study_with_content = case_study::join('Item', 'Item.i_case', '=', 'Case.cid')
            ->where('i_type', '=', 1)->where('i_content', 'LIKE', '%'.$q.'%')
            ->select('Case.*')->get()->sortByDesc('cid');

        $case_study = $case_study_without_content->concat($case_study_with_content)->sortByDesc('cid');
        if ($validate->fails()) {
            return view('search')
            ->withErrors($validate);
        }
        return view('search', ['case_study' => $case_study]);
    }
}
