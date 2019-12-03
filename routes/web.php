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



/********VIEWS*********/

//Software requirement 2.2.2.2 - about page
Route::get('/about', 'ViewsController@about');
//Software requirement 2.2.2.3 - help page
Route::get('/help', 'ViewsController@help');
//Software requirement 2.2.3.3 - group page
Route::get('/group', 'ViewsController@group');
//Software requirement 2.2.3.2 - page that displays a user's groups
Route::get('/user/groups', 'ViewsController@userGroups');
//Software requirement 2.2.3.1 - page thaht displays a user's case studies
Route::get('/user/cases', 'ViewsController@userCases');
//Software requirement 2.2.3.4 - case study page
Route::get('/case/body', 'ViewsController@showCaseBody');

Route::any('/search','ViewsController@search');

/********USERS*********/

//List specific user
Route::get('/user', 'UserController@show');

//List all system users
Route::get('/users', 'UserController@index');

//List users editing cid
Route::get('/user/edit', 'UserController@showUsersEditing');

//Update users editing cid
Route::post('/user/edit', 'UserController@updateUsersEditing');


/********GROUPS*********/

//List all system groups
Route::get('/groups', 'GroupController@index');

//List groups of a user
//Software requirement 2.3.2 Group management
//Software requirement 2.37. The web application will allow Collaborators to view the groups they belong to.
Route::get('/group/show', 'GroupController@showGroups');

//List group info
Route::get('/group/info', 'GroupController@info');

//List members of a group
//Software requirement 2.38. The web application will allow Collaborators to view their group members, and
//group case studies in the “Group View” page.
Route::get('/user-groups/show', 'User_GroupsController@showMembers');

//Create a group
//Software requirement 2.36. The web application will allow Collaborators to create a group by providing a
//group name.
Route::post('/group/create', 'GroupController@store');

//Update group name
//Software requirement 2.51. The web application will allow Collaborators to rename a group they have
//created.
Route::put('/group/rename', 'GroupController@update');

//Add users to group
//Software requirement 2.50. The web application will allow Collaborators to add a Collaborator to a group they
//have created.
Route::post('/user-groups/add', 'User_GroupsController@store');

//Delete group
//Software requirement 2.54. The web application will allow Collaborators to delete a group they have created.
Route::delete('group/remove', 'GroupController@destroy');

//Remove users from group
//Software requirement 2.55. The web application will allow Collaborators to remove a Collaborator from a
//group they have created.
Route::delete('/user-groups/remove', 'User_GroupsController@destroy');



/********CASES*********/

//List specific case
Route::get('/case', 'CaseController@show');

//List all system case studies
Route::get('/cases', 'CaseController@index');

//List cases of a group
//Software requirement 2.38. The web application will allow Collaborators to view their group members, and
//group case studies in the “Group View” page.
Route::get('/case/group/show', 'CaseController@showGroupCases');

//List all case studies of a user(author and group cases)
//Software requirement 2.3.3 Case study management
Route::get('/case/user/show', 'CaseController@showAllUserCases');

//Show case study groups
Route::get('/case/group', 'CaseController@show_case_group');

//Create a case study
//Software requirement 2.33. The web application will allow Collaborators to create a new independent case
//study by providing a case name, and description.
//Software requirement 2.34. The web application will allow Collaborators to create a new case study in a
//group they belong to by providing a case name, and description.
Route::post('/case/create', 'CaseController@store');

//Delete case study
//Software Requirement 2.53. The web application will allow Collaborators to delete a case study that they have
//created.
Route::delete('case/remove', 'CaseController@destroy');



/********CASE ITEMS*********/

//List items
Route::get('/items', 'ItemController@index');

//List case items
Route::get('/case/items','ItemController@getCaseItems');

//Add items to a case
Route::post('/item/add', 'ItemController@addCaseItem');

//Update item in a case
Route::post('/item/update', 'ItemController@update');

//Delete item
Route::delete('/item/remove', 'ItemController@removeItem');


/********CASE PARAMETERS*********/

//List parameters
Route::get('/parameters','CS_ParameterController@getParameters');

//List parameter options
Route::get('/parameter/options','CS_ParameterController@getParameterOptions');

//List case parameters
Route::get('/cs-parameters', 'Case_ParametersController@getParameters');

//List case parameters of a case study
Route::get('/case/parameters','Case_ParametersController@getCaseParameters');

//List case parameter selected options
Route::get('/case/{id}/options','Case_ParametersController@getCaseSelectedOptions');


//Update title/description in a case
Route::post('/case/update', 'CaseController@updateCaseDetails');

//Update parameters in a case
Route::post('/parameter/update', 'Case_ParametersController@updateCaseParameters');

//Create default parameters in a case
Route::post('/parameter/create/defaults', 'Case_ParametersController@createDefaultParameters');

//Admin board
//Software Requirement 2.60. The web application will allow an Admin to view the “Admin Dashboard” page


//Provides the admin with a list of users.
//Software Requirement 2.62 on Software Requirement Specifications Documents
Route::get('/admin/users-requests', 'AdminUsersRequestsController@index')->name('admin.users-requests');


//Provides the admin with a list of users
//requesting their role to be upgraded from Viewer to Collaborator.
//Software Requirement 2.64 on Software Requirement Specifications Documents
//Route::get('/admin/users-requests', 'AdminUsersRequestsController@index')->name('admin.users-requests');


//Presents latest action for each user
//User Requirement 2.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/users-actions', 'AdminUsersActionsController@index')->name('admin.users-actions');


//Presents recent actions for a particular user
//Software Requirement 2.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/users-actions/{id}', 'AdminUsersActionsController@show');


//Presents group name, the group owner, the latest action, and creation date for each group.
//Software Requirement 2.63. The web application will allow an Admin to view the groups of the system.
Route::get('/admin/groups', 'AdminGroupsController@index')->name('admin.groups');


//Presents recent actions for a particular group
//Software Requirement 2.61. The web application will allow an Admin to view the recent activity of users
//and groups in the system, the activities are:
//1. Creation of case studies   2. Updates to case studies   3. Deletion of case studies
Route::get('/admin/groups-actions/{id}', 'AdminGroupsActionsController@show');


//List filters
//Software Requirement 2.65  The web application will allow an Admin to view a list of search filters for case studies.
//Software Requirement 2.67  The web application will allow an Admin to view a list of search filter categories for case studies.
Route::get('/admin/filters', 'AdminFiltersController@index')->name('admin.filters');


//Add new filter
//User Requirement: 2.70.  The web application will allow an Admin to add new filters to the list of search filters for case studies.
Route::post('/admin/filter-option', 'AdminFilterOptionController@store');


//Remove filter
//Software Requirement: 2.74.  The web application will allow an Admin to remove search filters they have created for case studies
Route::delete('/admin/filter-option/{id}', 'AdminFilterOptionController@destroy');

//Edit filter 
//User Requirement: (2.xx)  The web application will allow an Admin to modify search filter they have created for case studies
Route::put('/admin/filter-option/{id}', 'AdminFilterOptionController@update');

//Add new filter category
//Software Requirement: 2.71.  The web application will allow an Admin to add new categories to the list of search filters for case studies.
Route::post('/admin/filter-category', 'AdminFilterCategoryController@store');


//Remove filter category
//Software Requirement: 2.75.  The web application will allow an Admin to remove search filter categories they have created for case studies
Route::delete('/admin/filter-category/{id}', 'AdminFilterCategoryController@destroy');


//Edit filter category
//User Requirement: (2.xx)  The web application will allow an Admin to modify search filter categories they have created for case studies
Route::put('/admin/filter-category/{id}', 'AdminFilterCategoryController@update');


//Admin Edits a User
//Software Requirement 2.69. The web application will allow an Admin to approve the user requests for Collaborator role permissions.
//Software Requirement 2.76. The web application will allow an Admin to ban a Collaborator, removing their role permissions.
//Software Requirement 2.77. The web application will allow an Admin to unban a Collaborator, restoring their role permissions.
Route::get('/admin/user/{id}/edit', 'AdminUserController@edit');


//Admin Edits a User
//Software Requirement 2.69. The web application will allow an Admin to approve the user requests for Collaborator role permissions.
//Software Requirement 2.76. The web application will allow an Admin to ban a Collaborator, removing their role permissions.
//Software Requirement 2.77. The web application will allow an Admin to unban a Collaborator, restoring their role permissions.
Route::put('/admin/user/{id}', 'AdminUserController@update');


