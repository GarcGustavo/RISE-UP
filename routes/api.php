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

Route::resource('users', 'UserAPIController');

Route::resource('actions', 'ActionAPIController');

Route::resource('action_types', 'Action_TypeAPIController');

Route::resource('cases', 'CaseAPIController');

Route::resource('case_parameters', 'Case_ParametersAPIController');

Route::resource('actions', 'ActionAPIController');

Route::resource('cs_parameters', 'CS_ParameterAPIController');

Route::resource('groups', 'GroupAPIController');

Route::resource('items', 'ItemAPIController');

Route::resource('item_types', 'Item_TypeAPIController');

Route::resource('options', 'OptionAPIController');

Route::resource('roles', 'RoleAPIController');

Route::resource('user_groups', 'User_GroupsAPIController');