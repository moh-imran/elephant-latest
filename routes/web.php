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
//Route::get('job-builder', 'JobApplicantsController@index');
//Route::get('de/job-builder', 'JobApplicantsController@indexDeutsch');


Route::post('build-job', 'JobApplicantsController@postJob');
Route::post('mail', 'CommonController@sendEmail');
Route::get('get-tweets', 'CommonController@getTweets');
Route::get('get-linkedin-feeds', 'CommonController@getLinkedInFeeds');
Route::get('get-home-content', 'CommonController@getHomeContent');
Route::get('drop-down-options', 'CommonController@getDropDownOptions');


Route::get('job-builder', 'JobApplicantsNewController@index');
Route::get('de/job-builder', 'JobApplicantsNewController@indexDeutsch');
Route::post('post-job-application', 'JobApplicantsNewController@postJobApplication');
Route::post('de/post-job-application', 'JobApplicantsNewController@postJobApplication');

