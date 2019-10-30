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
