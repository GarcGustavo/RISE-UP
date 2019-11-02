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

Route::get('/group/{id}', function () {
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

//List cases
Route::get('/cases', 'CaseController@index');

//List members of a group
Route::get('/group/{id}/members', 'User_GroupsController@show_members');

//List groups of a user
Route::get('/user_groups/{id}', 'GroupController@show_groups');

//List cases of a group
Route::get('/group/{id}/cases', 'CaseController@show_group_cases');

//List all cases of a user(author and group cases)
Route::get('/user_cases/{id}', 'CaseController@show_all_user_cases');

//Add users to group
Route::post('/group/members/add', 'User_GroupsController@store');

//Remove users from group
Route::delete('/group/members/remove', 'User_GroupsController@destroy');

//Delete group
Route::delete('user_groups/remove', 'GroupController@destroy');


//Create a group
Route::post('/group/create', 'GroupController@store');

//Create a case
Route::post('/case/create', 'CaseController@store');

