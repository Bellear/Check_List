<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// (POST)   http://localhost:8000/api/v1/register - Регистрация API
// (POST)   http://localhost:8000/oauth/token - Вход в API
// (GET)    http://localhost:8000/api/v1/tasks - Список заданий
// (POST)   http://localhost:8000/api/v1/tasks - Добавить задание
// (GET)    http://localhost:8000/api/v1/tasks/{id} - Показать задание
// (PUT)    http://localhost:8000/api/v1/tasks/{id} - Редактировать задание
// (DELETE) http://localhost:8000/api/v1/tasks/{id} - Удалить задание

Route::post('register', 'API\RegisterController@register');
Route::middleware('auth:api')->group( function () {
    Route::resource('tasks', 'API\ProductController');
});
