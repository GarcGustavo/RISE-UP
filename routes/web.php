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

Route::get('/home', function () {
    return view('home');
});

// Route::get('/case/{id}/body', function () {
//     return view('case_study_body');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/case/{id}/body', 'CaseController@showCaseBody')->name('case/body');

//List users
Route::get('/users', 'UserController@index');

//List users editing cid
Route::get('/user/edit/{id}', 'UserController@showUsersEditing');

//Update users editing cid
Route::post('/user/{id}/edit', 'UserController@updateUsersEditing');

//List groups
Route::get('/groups', 'GroupController@index');

//List cases
Route::get('/cases', 'CaseController@index');

//List items
Route::get('/items', 'ItemController@index');

//List specific case
Route::get('/case/{id}', 'CaseController@show');

//List specific user
Route::get('/user/{id}', 'UserController@show');

//List case study group
Route::get('/case/group/{id}', 'CaseController@show_case_group');

//List case items
Route::get('/case/{id}/items','ItemController@getCaseItems');

//List parameters
Route::get('/parameters','CS_ParameterController@getParameters');

//List parameter options
Route::get('/parameter/options','CS_ParameterController@getParameterOptions');

//List case parameters
Route::get('/case/{id}/parameters','Case_ParametersController@getCaseParameters');

//List case parameter selected options
Route::get('/case/{id}/options','Case_ParametersController@getCaseSelectedOptions');

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

//Update title/description in a case
Route::post('/case/{id}/update', 'CaseController@updateCaseDetails');

//Update parameters in a case
Route::post('/parameter/update', 'CaseController@updateCaseParameters');

//Add items to a case
Route::post('/item/add', 'ItemController@addCaseItem');

//Update item in a case
Route::post('/item/{id}/update', 'ItemController@update');

//Remove users from group
Route::delete('/group/members/remove', 'User_GroupsController@destroy');

//Delete group
Route::delete('user_groups/remove', 'GroupController@destroy');

//Delete case study
Route::delete('user_cases/remove', 'CaseController@destroy');

//Delete item
Route::delete('/item/{id}/remove', 'ItemController@removeItem');

//Create a group
Route::post('/group/create', 'GroupController@store');

//Create a case
Route::post('/case/create', 'CaseController@store');

