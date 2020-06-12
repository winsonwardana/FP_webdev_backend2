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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });










Route::post('/login','AuthController@userLogin');
Route::post('/signup','AuthController@signUp');

Route::post('/admin','AuthController@adminLogin');
Route::get('/getUserDetail/{id}','AuthController@getUserDetail');