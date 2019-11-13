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


//Presents latest action for each user
//User Requirement 2.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/users-actions', 'AdminUsersActionsController@index')->name('admin.users-actions');


//Presents recent actions for a particular user
//User Requirement 2.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/users-actions/{id}', 'AdminUsersActionsController@show');


//Presents group name, the group owner, the latest action, and creation date for each group.
//User Requirement 2.63. The web application will allow an Admin to view the groups of the system.
Route::get('/admin/groups', 'AdminGroupsController@index')->name('admin.groups');


//Presents recent actions for a particular group
//User Requirement 2.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/groups-actions/{id}', 'AdminGroupsActionsController@show');


//List filters
//User Requirement 2.65  The web application will allow an Admin to view a list of search filters for case studies.
//User Requirement 2.67  The web application will allow an Admin to view a list of search filter categories for case studies.
Route::get('/admin/filters', 'AdminFiltersController@index')->name('admin.filters');


//Add new filter
//User Requirement: 2.70.  The web application will allow an Admin to add new filters to the list of search filters for case studies.
Route::post('/admin/filter-option', 'AdminFilterOptionController@store');


//Remove filter
//User Requirement: 2.74.  The web application will allow an Admin to remove search filters they have created for case studies
Route::delete('/admin/filter-option/{id}', 'AdminFilterOptionController@destroy');


//Add new filter category
//User Requirement: 2.71.  The web application will allow an Admin to add new categories to the list of search filters for case studies.
Route::post('/admin/filter-category', 'AdminFilterCategoryController@store');


//Remove filter category
//User Requirement: 2.75.  The web application will allow an Admin to remove search filter categories they have created for case studies
Route::delete('/admin/filter-category/{id}', 'AdminFilterCategoryController@destroy');


//Admin Edits a User
//User Requirement 2.69. The web application will allow an Admin to approve the user requests for Collaborator role permissions.
//User Requirement 2.76. The web application will allow an Admin to ban a Collaborator, removing their role permissions.
//User Requirement 2.77. The web application will allow an Admin to unban a Collaborator, restoring their role permissions.
Route::get('/admin/user/{id}/edit', 'AdminUserController@edit');


//Admin Edits a User
//User Requirement 2.69. The web application will allow an Admin to approve the user requests for Collaborator role permissions.
//User Requirement 2.76. The web application will allow an Admin to ban a Collaborator, removing their role permissions.
//User Requirement 2.77. The web application will allow an Admin to unban a Collaborator, restoring their role permissions.
Route::put('/admin/user/{id}', 'AdminUserController@update');
//









//Admin Edits a Group  ()
Route::get('/admin/group/{id}/edit', 'AdminGroupController@edit');
Route::put('/admin/group/{id}', 'AdminGroupController@update');

/*
 * Not required.
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
