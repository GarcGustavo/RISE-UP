<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('posts', 'PostAPIController');

Route::resource('users', 'UserAPIController');

Route::resource('actions', 'ActionAPIController');

Route::resource('action__types', 'Action_TypeAPIController');

Route::resource('cases', 'CaseAPIController');

Route::resource('case__parameters', 'Case_ParametersAPIController');

Route::resource('actions', 'ActionAPIController');

Route::resource('c_s__parameters', 'CS_ParameterAPIController');

Route::resource('groups', 'GroupAPIController');

Route::resource('items', 'ItemAPIController');

Route::resource('item__types', 'Item_TypeAPIController');

Route::resource('options', 'OptionAPIController');

Route::resource('roles', 'RoleAPIController');

Route::resource('user__groups', 'User_GroupsAPIController');