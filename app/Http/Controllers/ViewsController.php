<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
}

