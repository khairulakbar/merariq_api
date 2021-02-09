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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');

/* Route Controller Front End */

//Route::get('/users', 'UsersController@index');
//Route::get('/usersname/{namaUser}', 'UsersController@filterNama');

Route::group(['namespace' => 'Front', 'prefix' => 'front'], function () {
    Route::get('/usersname/{namaUser}', 'UsersController@filterNama');

    //view undangan
    Route::get('/undangan/{kodeUndangan}', 'UndanganController@filterKode');
    Route::get('/map/{kodeUndangan}', 'UndanganController@mapdata');
    Route::get('/galeri/{kodeUndangan}', 'UndanganController@galeridata');
});

//edit undangan 
Route::group(['namespace' => 'Back', 'prefix' => 'editor'], function () {
    Route::get('/undangan', 'UndanganController@undanganData')->middleware('jwt.verify');
    Route::get('/map', 'UndanganController@mapdata')->middleware('jwt.verify');
    Route::get('/galeri', 'UndanganController@galeridata')->middleware('jwt.verify');
    Route::put('/updatehome', 'UndanganController@updateHome')->middleware('jwt.verify');
    Route::put('/updateundangan', 'UndanganController@updateUndangan')->middleware('jwt.verify');
    Route::put('/updatelokasi', 'UndanganController@updateLokasi')->middleware('jwt.verify');
    Route::put('/updatemap', 'UndanganController@updateMap')->middleware('jwt.verify');
    Route::put('/updatesocmed', 'UndanganController@updateSocmed')->middleware('jwt.verify');
    Route::put('/updatestory', 'UndanganController@updateStory')->middleware('jwt.verify');
    Route::post('/upmanimg', 'UndanganController@postImageMan')->middleware('jwt.verify');
    Route::post('/upwomanimg', 'UndanganController@postImageWoman')->middleware('jwt.verify');
    Route::post('/postgaleri', 'UndanganController@postGaleri')->middleware('jwt.verify');
    Route::delete('/deletegaleri/{id}', 'UndanganController@deletegaleri')->middleware('jwt.verify');
});
