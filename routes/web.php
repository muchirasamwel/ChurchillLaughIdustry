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
Route::get('login', function () {
    return view('login');
});
Route::get('myevents', function () {
    return view('myEvents');
});

Route::post('/incrticket','databaseController@incrticket');
Route::get('home', function () {
    return view('home');
});
Route::get('profile', function () {
    return view('profile');
});
Route::post('/insert','databaseController@insert');
Route::get('/select','databaseController@select');
Route::post('/select','databaseController@select');
Route::post('/update','databaseController@update');
Route::post('/delete','databaseController@delete');

Route::post('/login','databaseController@login');
Route::post('uploadfile','uploadFileController@UploadImageFile');
 // <!-- copy rights reserved by Smb -->