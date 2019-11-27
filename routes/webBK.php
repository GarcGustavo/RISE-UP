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



/********CASES*********/

//List specific case
Route::get('/case', 'CaseController@show');

//List all case studies
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
