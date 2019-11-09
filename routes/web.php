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












//Admin board
//User Requirement 2.60. The web application will allow an Admin to view the “Admin Dashboard” page

//Provides the admin with a list of users.
//User Requirement 2.62 on Software Requirement Specifications Documents
Route::get('/admin/users-requests', 'AdminUsersRequestsController@index')->name('admin.users-requests');

//Provides the admin with a list of users
//requesting their role to be upgraded from Viewer to Collaborator.
//User Requirement 2.64 on Software Requirement Specifications Documents
//Route::get('/admin/users-requests', 'AdminUsersRequestsController@index')->name('admin.users-requests');

//Log of actions
//User Requirement 2.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/users-actions', 'AdminUsersActionsController@index')->name('admin.users-actions');
Route::get('/admin/groups/actions', 'AdminGroupsActionsController@index')->name('admin.groups.actions');


//List filters
//User Requirement 1.65. The web application will allow an Admin to view a list of search filters for case studies.
Route::get('/admin/filters', 'AdminController@filters')->name('admin.filters');

//List groups
//User Requirement 1.63. The web application will allow an Admin to view the groups of the system.
Route::get('/admin/groups', 'AdminController@groups')->name('admin.groups');



//List activity log
//User Requirement 1.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/users-actions/{id}', 'AdminUsersActionsController@show');

//admin edits a user
//User Requirement 1.69. The web application will allow an Admin to approve the user requests for Collaborator role permissions.
//1.76. The web application will allow an Admin to ban a Collaborator, removing their role permissions.
//1.77. The web application will allow an Admin to unban a Collaborator, restoring their role permissions.
Route::get('/admin/user/{id}/edit', 'AdminController@userEdit');

Route::put('/admin/user/{id}', 'AdminController@userUpdate');

//admin edits a group
//User Requirement 1.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/group/{id}/edit', 'AdminController@groupEdit');

Route::put('/admin/group/{id}', 'AdminController@groupUpdate');

/*
//Falta index y update
//Create an admin
Route::get('/admin/create', 'AdminController@create');

//Post an admin
Route::post('/admin', 'AdminController@store');

//Show an admin
Route::get('/admin/{id}', 'AdminController@show');

//Edit an admin
Route::get('/admin/{id}/edit', 'AdminController@edit');

//Delete an admin
Route::delete('/admin/{id}', 'AdminController@destroy');
*/
