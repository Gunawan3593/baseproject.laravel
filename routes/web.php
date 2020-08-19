<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/', 'DashboardController@index');

//USER
Route::get('/user', 'UserController@index')->name('user');
Route::get('/userData', 'UserController@showAll')->name('user.data');
Route::get('/user/create', 'UserController@create')->name('user.create');
Route::post('/user', 'UserController@store');
Route::get('/user/{id}/edit', 'UserController@edit');
Route::get('/user/show/{id}', 'UserController@show');
Route::post('/user/update', 'UserController@update');
Route::delete('/user/{id}', 'UserController@destroy');
//END USER

//PERMISSION SPATIE
Route::get('/permission', 'PermissionController@index')->name('permission');
Route::get('/permission/show', 'PermissionController@show');
Route::get('/permissionData', 'PermissionController@showAll')->name('permission.data');
Route::post('/permission', 'PermissionController@store')->name('permission.add');
Route::get('/permission/{id}/edit', 'PermissionController@edit');
Route::post('/permission/update', 'PermissionController@update')->name('permission.update');
Route::delete('/permission/{id}', 'PermissionController@destroy');

//ROLE SPATIE
Route::get('/role', 'RoleController@index')->name('role');
Route::get('/role/show/{id}', 'RoleController@show');
Route::get('/roleData', 'RoleController@showAll')->name('role.data');
Route::get('/role/create', 'RoleController@create')->name('role.create');
Route::post('/role', 'RoleController@store')->name('role.add');
Route::get('/role/{id}/edit', 'RoleController@edit');
Route::post('/role/update', 'RoleController@update');
Route::delete('/role/{id}', 'RoleController@destroy');
Route::get('/role/list', 'RoleController@roleList');

//PAGE
Route::get('/page', 'PageController@index')->name('page');
Route::get('/pageData', 'PageController@showAll')->name('page.data');
Route::post('/page', 'PageController@store')->name('page.add');
Route::get('/page/{id}/edit', 'PageController@edit');
Route::post('/page/update', 'PageController@update');
Route::delete('/page/{id}', 'PageController@destroy');
//END PAGE

