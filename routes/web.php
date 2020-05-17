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


Route::get('/', 'TaskController@index');
Route::get('task/', 'TaskController@index') -> name('task.index');
Route::get('task/create', 'TaskController@create') ->middleware('blocked') -> name('task.create');
Route::get('task/show/{id}', 'TaskController@show') -> middleware('blocked') -> name('task.show');
Route::get('task/edit/{id}', 'TaskController@edit') -> middleware('blocked') -> name('task.edit');
Route::match(['get', 'post'],'task/store', 'TaskController@store') -> middleware('blocked') -> name('task.store');
Route::patch('task/done/{id}', 'TaskController@done') -> middleware('blocked') -> name('task.done');
Route::patch('task/show/{id}', 'TaskController@update') -> middleware('blocked') -> name('task.update');
Route::delete('task/{id}', 'TaskController@destroy') -> middleware('blocked') -> name('task.destroy');

Auth::routes();


Route::get('users/', 'UserController@index') -> name('user.index');
Route::get('user/show/{id}', 'UserController@show') -> name('user.show');
Route::get('user/edit/{id}', 'UserController@edit') -> name('user.edit');
Route::patch('user/show/{id}', 'UserController@update') -> name('user.update');
