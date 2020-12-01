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

Route::post('register','Api\UserController@register');
Route::post('login','Api\LoginController@login');
Route::post('refresh', 'Api\LoginController@refresh');

// Email Verification

Route::get('email/verify/{id}', 'Api\VerificationController@verify')->name('verification.verify');
Route::get('email/resend/{id}', 'Api\UserController@resend')->name('verification.resend');

// UserController

Route::get('user', 'Api\UserController@index');
Route::get('user/{id}', 'Api\UserController@show');
Route::post('user', 'Api\UserController@store');
Route::post('user/{id}', 'Api\UserController@update');
Route::post('deleteUser/{id}', 'Api\UserController@destroy');

// PelangganController

Route::get('pelanggan/{nama}', 'Api\PelangganController@index');
Route::get('pelanggan/{id}', 'Api\PelangganController@show');
Route::post('pelanggan', 'Api\PelangganController@store');
Route::post('pelanggan/{id}', 'Api\PelangganController@update');
Route::post('deletePelanggan/{id}', 'Api\PelangganController@destroy');

// RoomController

Route::get('room', 'Api\RoomController@index');
Route::get('room/{id}', 'Api\RoomController@show');
Route::post('room', 'Api\RoomController@store');
Route::post('room/{id}', 'Api\RoomController@update');
Route::post('deleteRoom/{id}', 'Api\RoomController@destroy');







