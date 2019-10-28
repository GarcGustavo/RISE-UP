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
    return view('layout.layout');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/help', function () {
    return view('help');
});
Route::get('/group', function () {
    return view('group');
});
Route::get('/user_groups', function () {
    return view('user_groups');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/case', function () {
    return view('case_study');
});

Auth::routes();


//Show case
Route::get('/case_study/{id}', 'CaseController@show');

//List users
Route::get('/users', 'UserController@index');

//List members of a group
Route::get('/group/{id}/members', 'User_GroupsController@show_members');

//List groups of a user
Route::get('/user/{id}/groups', 'GroupController@show_groups');
