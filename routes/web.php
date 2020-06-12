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

 Route::get('/', ['uses' => 'UserController@index']);
 Route::post('/', ['uses' => 'UserController@login']);

 Route::get('/admin', function () {
    return view('admin');
});


Route::get('/dashboard-post', ['uses' => 'AdminController@index']);
Route::post('/dashboard-create', ['uses' => 'AdminController@login']);
Route::post('/dashboard-post', ['uses' => 'AdminController@store']);
Route::get('/dashboard-create', function () {
    return view('dashboardcreate');
});


Route::get('/signup', function () {
    return view('signup');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/comment/{id}',['uses' => 'UserController@createcomment']);
Route::get('/detail/{id}', ['uses' => 'UserController@detail']);

Route::post('/dashboard', ['uses' => 'UserController@login']);
Route::post('/login', ['uses' => 'UserController@store']);
Route::get('/logout', ['uses' => 'UserController@logout']);
// Route::post('/adminlogin', ['uses' => 'AdminController@store']);

Route::post('/update/{id}',['uses' => 'AdminController@update']);
Route::patch('dashboard-update/{id}',['uses' => 'AdminController@executeUpdate']);
Route::delete('delete/{id}',['uses' => 'AdminController@delete']);




