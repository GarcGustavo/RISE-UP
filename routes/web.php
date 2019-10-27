<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layout');
});
Route::get('/about', function () {
    return view('about');
});
<<<<<<< HEAD


Route::resource('posts', 'PostController');

Route::resource('users', 'UserController');

Route::resource('userGroups', 'User_GroupsController');

Route::resource('roles', 'RoleController');

Route::resource('options', 'OptionController');

Route::resource('migrations', 'MigrationsController');

Route::resource('itemTypes', 'Item_TypeController');

Route::resource('items', 'ItemController');

Route::resource('groups', 'GroupController');

Route::resource('groups', 'GroupController');

Route::resource('cSParameters', 'CS_ParameterController');

Route::resource('caseParameters', 'Case_ParametersController');

Route::resource('cases', 'CaseController');

Route::resource('actionTypes', 'Action_TypeController');

Route::resource('actions', 'ActionController');

Route::resource('users', 'UserController');

Route::resource('actions', 'ActionController');

Route::resource('actionTypes', 'Action_TypeController');

Route::resource('cases', 'CaseController');

Route::resource('caseParameters', 'Case_ParametersController');

Route::resource('actions', 'ActionController');

Route::resource('cSParameters', 'CS_ParameterController');

Route::resource('groups', 'GroupController');

Route::resource('items', 'ItemController');

Route::resource('itemTypes', 'Item_TypeController');

Route::resource('options', 'OptionController');

Route::resource('roles', 'RoleController');

Route::resource('userGroups', 'User_GroupsController');

Route::resource('users', 'UserController');

Route::resource('users', 'UserController');
=======
Route::get('/Home', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
