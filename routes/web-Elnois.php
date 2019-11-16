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

use Illuminate\Support\Facades\Route;

//IReN Routes (Elnois):

//Routes with Gets Methods

//Views
//Get Route to render Landing Page view
Route::get('/', 'IReNViewsController@landingPage');
//Get Route to render Profile Creation view 
Route::get('/user/profile-creation', 'IReNViewsController@createProfile');
//Get Route to render Home view
Route::get('/home', 'IReNViewsController@home');
//Get Route to render Help view
Route::get('/help', 'IReNViewsController@help');
//Get Route to render About view
Route::get('/about', 'IReNViewsController@about');
//Get Route to render About view
Route::get('/case/show', 'CaseController@show');


//Gets
//Get Route to get login choices
Route::get('/shibboleth-login/get-choices', 'ShibbolethLoginController@getLoginChoices');
//Post Route to request collaborator role
Route::get('/user/request-collab', 'UserController@requestCollab');




//Posts
//Post Route to request shibboleth login
Route::post('/shibboleth-login', 'ShibbolethLoginController@Login');
//Post Route to sumbit  profile creation form
Route::post('/user/submition', 'UserController@formSubmit');
//Post Route to verifify if user profile exists
Route::get('/user/verification', 'UserController@find');
//Put Route to create a new user
Route::post('/user/create-user', 'UserController@store');
//Post Route to request collaborator role
Route::post('/case/search', 'CaseController@search');



