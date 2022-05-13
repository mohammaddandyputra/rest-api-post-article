<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;

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

Route::controller(PostController::class)->group(function () {
    Route::get('/post/{limit}/{offset}', 'index');
    Route::post('/post', 'store');
    Route::get('/post/{id}', 'show');
    Route::post('/post/{id}', 'update');
    Route::delete('/post/{id}', 'destroy');
    Route::get('/post/publish/{limit}/{offset}', 'dataPublish');
    Route::get('/post/filter/{status}/{limit}/{offset}', 'filter');
    Route::post('/post/trash/{id}', 'trash');
    Route::get('/post', 'countStatus');
});
