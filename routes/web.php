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

//Route::get('/', function () {
//    echo phpinfo();
//});

Route::get('/', 'CommonController@index');
Route::get('/de', 'CommonController@indexDeutsch');
Route::get('job-builder', 'JobApplicantsController@index');
Route::get('de/job-builder', 'JobApplicantsController@indexDeutsch');


Route::post('build-job', 'JobApplicantsController@postJob');
Route::post('mail', 'CommonController@sendEmail');
