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

Route::get('/Home', function () {
    return view('home');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//List users
Route::get('/users', 'UserController@index');

//List members of a group
Route::get('/group/{id}/members', 'User_GroupsController@show_members');

//List groups of a user
Route::get('user_groups/{id}', 'GroupController@show_groups');

//List cases of a group
Route::get('group/{id}/cases', 'GroupController@show_group_cases');





//Falta index y update
//Create an admin
Route::get('/admin/create', 'AdminController@create');
//List users with recent activities or requests

//List user's activities and requests
Route::get('/admin/users', 'AdminController@users')->name('admin.users');

//List activity log
Route::get('/admin/log', 'AdminController@log')->name('admin.log');

//List filters
Route::get('/admin/filters', 'AdminController@filters')->name('admin.filters');

//Post an admin
Route::post('/admin', 'AdminController@store');

//Show an admin
Route::get('/admin/{id}', 'AdminController@show');
//Route::get('/admin/users/{}', 'AdminController@users');

//Edit an admin
Route::get('/admin/{id}/edit', 'AdminController@edit');

//Delete an admin
Route::delete('/admin/{id}', 'AdminController@destroy');

