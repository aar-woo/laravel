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

use App\Http\Controllers\UserController;
/**
  * Route for POST requests at /users/create
  *
  * store method of the UserController class then handles the request
  */
Route::post('/users/create', [UserController::class, 'store']);

/**
  * Route for POST request at /users/update/id
  *
  * update method of the UserController then handles the request
  */
Route::post('/users/update/{id}', [UserController::class, 'update']);

/**
  * Route for GET requests at /users/update/id
  *
  * getUsers method of the UserController class then handles the request
  */
Route::get('/users', [UserController::class, 'getUsers']);
