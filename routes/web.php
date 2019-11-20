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


Route::get('/Home', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');





/********VIEWS*********/

Route::get('/about', 'ViewsController@about');

Route::get('/help', 'ViewsController@help');

Route::get('/group', 'ViewsController@group');

Route::get('/user/groups', 'ViewsController@userGroups');

Route::get('/user/cases', 'ViewsController@userCases');




/********USERS*********/

//List users
Route::get('/users', 'UserController@index');



/********GROUPS*********/

//List all groups
Route::get('/groups', 'GroupController@index');

//List groups of a user
Route::get('/user-groups/show', 'GroupController@showGroups');

//List group info
Route::get('/group/info', 'GroupController@info');

//List members of a group
Route::get('/group/members', 'User_GroupsController@showMembers');

//List cases of a group
Route::get('/group/cases', 'CaseController@showGroupCases');

//Create a group
Route::post('/group/create', 'GroupController@store');

//Update group name
Route::put('/group/name/update', 'GroupController@update');

//Add users to group
Route::post('/group/members/add', 'User_GroupsController@store');

//Delete group
Route::delete('user-groups/remove', 'GroupController@destroy');

//Remove users from group
Route::delete('/group/members/remove', 'User_GroupsController@destroy');


/********CASES*********/

//List all case studies
Route::get('/cases', 'CaseController@index');

//List all case studies of a user(author and group cases)
Route::get('/user-cases/show', 'CaseController@showAllUserCases');

//Create a case study
Route::post('/case/create', 'CaseController@store');

//Delete case study
Route::delete('user-cases/remove', 'CaseController@destroy');


