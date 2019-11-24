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

Route::get('/Home', function () {
    return view('home');
});

Auth::routes();

<<<<<<< HEAD
Route::get('/user/{id}/groups', function () {
    return view('user_groups');
});

Route::get('/user/{id}/cases', function () {
    return view('user_cases');
});

Route::get('/home', function () {
    return view('home');
});

// Route::get('/login', function () {
//     return view('login');
// });

//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
=======


/********VIEWS*********/

Route::get('/about', 'ViewsController@about');

Route::get('/help', 'ViewsController@help');

Route::get('/group', 'ViewsController@group');

Route::get('/user/groups', 'ViewsController@userGroups');

Route::get('/user/cases', 'ViewsController@userCases');

Route::get('/case/body', 'ViewsController@showCaseBody');


/********USERS*********/

//List specific user
Route::get('/user', 'UserController@show');
>>>>>>> 34140abe639af7d6b49c39f387b701dd525ddd1d

//List users
Route::get('/users', 'UserController@index');

//List users editing cid
Route::get('/user/edit/{id}', 'UserController@showUsersEditing');

//Update users editing cid
Route::post('/user/{id}/edit', 'UserController@updateUsersEditing');

/********GROUPS*********/

//List all groups
Route::get('/groups', 'GroupController@index');

//List groups of a user
Route::get('/group/show', 'GroupController@showGroups');

//List group info
Route::get('/group/info', 'GroupController@info');

//List members of a group
Route::get('/user-groups/show', 'User_GroupsController@showMembers');

//Create a group
Route::post('/group/create', 'GroupController@store');

//Update group name
Route::put('/group/rename', 'GroupController@update');

//Add users to group
Route::post('/user-groups/add', 'User_GroupsController@store');

//Delete group
Route::delete('group/remove', 'GroupController@destroy');

//Remove users from group
Route::delete('/user-groups/remove', 'User_GroupsController@destroy');



<<<<<<< HEAD
//List cases
=======
/********CASES*********/

//List specific case
Route::get('/case', 'CaseController@show');

//List all case studies
>>>>>>> 34140abe639af7d6b49c39f387b701dd525ddd1d
Route::get('/cases', 'CaseController@index');

//List cases of a group
Route::get('/case/group/show', 'CaseController@showGroupCases');

//List all case studies of a user(author and group cases)
Route::get('/case/user/show', 'CaseController@showAllUserCases');

//Show case study groups
Route::get('/case/group/{id}', 'CaseController@show_case_group');

//Create a case study
Route::post('/case/create', 'CaseController@store');

//Delete case study
Route::delete('case/remove', 'CaseController@destroy');



<<<<<<< HEAD
//Delete case study
Route::delete('user_cases/remove', 'CaseController@destroy');

//List of login choices
Route::get('/login', 'LoginController@list_of_choices');

//Redirect to UPRM IDP
Route::get('/login_shibboleth', 'LoginController@shibboleth');

//Create profile
Route::put('/profile_creation/{', 'UserController@store');

//Find user if has been create before
Route::get('user_match/{email}', 'UserController@find');

//Find user if has been create before
Route::get('home/{id}', 'HomeController@set');

//Find user if has been create before
Route::get('request_collab/{id}', 'UserController@request_collab');

//Find user if has been create before
Route::get('request_collab/{id}', 'UserController@request_collab');
=======
/********CASE ITEMS*********/

//List items
Route::get('/items', 'ItemController@index');

//List case items
Route::get('/case/{id}/items','ItemController@getCaseItems');

//Add items to a case
Route::post('/item/add', 'ItemController@addCaseItem');

//Update item in a case
Route::post('/item/{id}/update', 'ItemController@update');

//Delete item
Route::delete('/item/{id}/remove', 'ItemController@removeItem');


/********CASE PARAMETERS*********/

//List parameters
Route::get('/parameters','CS_ParameterController@getParameters');

//List parameter options
Route::get('/parameter/options','CS_ParameterController@getParameterOptions');

//List case parameters
Route::get('/case/{id}/parameters','Case_ParametersController@getCaseParameters');

//List case parameter selected options
Route::get('/case/{id}/options','Case_ParametersController@getCaseSelectedOptions');

//Update title/description in a case
Route::post('/case/{id}/update', 'CaseController@updateCaseDetails');

//Update parameters in a case
Route::post('/parameter/update', 'CaseController@updateCaseParameters');
>>>>>>> 34140abe639af7d6b49c39f387b701dd525ddd1d
