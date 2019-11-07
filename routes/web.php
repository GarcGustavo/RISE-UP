<?php
use App\Http\Controllers\User_GroupsController;

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

Route::get('/user/{uid}/group/{gid}', function () {
   return view('group');
})->name('group');


Route::get('/user/{id}/groups', function () {
    return view('user_groups');
});


Route::get('/user/{id}/cases', function () {
    return view('user_cases');
});

Route::get('/Home', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//List users
Route::get('/users', 'UserController@index');

//List groups
Route::get('/groups', 'GroupController@index');

//List group info
Route::get('/group/{id}/info', 'GroupController@info');

//List members of a group
Route::get('/group/{id}/members', 'User_GroupsController@showMembers');

//List cases of a group
Route::get('/group/{id}/cases', 'CaseController@showGroupCases');

//Create a group
Route::post('/group/create', 'GroupController@store');

//Update group name
Route::post('/group/{id}/update', 'GroupController@update');

//Add users to group
Route::post('/group/members/add', 'User_GroupsController@store');

//Remove users from group
Route::delete('/group/members/remove', 'User_GroupsController@destroy');



//List cases
Route::get('/cases', 'CaseController@index');

//Create a case
Route::post('/case/create', 'CaseController@store');

//List groups of a user
Route::get('/user_groups/{id}', 'GroupController@showGroups');

//Delete group
Route::delete('user_groups/remove', 'GroupController@destroy');

//List all cases of a user(author and group cases)
Route::get('/user_cases/{id}', 'CaseController@showAllUserCases');


//Delete case study
Route::delete('user_cases/remove', 'CaseController@destroy');


