<?php

use Illuminate\Http\Request;

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
	$request->user()->usertype;
	$request->user()->businessunit;
    return $request->user();
});

Route::middleware('auth:api')->post('/logout','AuthController@logout');
/*=======================================================================================================================
 *Treasury Routes
 *=======================================================================================================================
*/
		Route::middleware('auth:api')->get('forDeposit','Treasury\TreasuryController@forDeposit');
		Route::middleware('auth:api')->get('dailyDep/{date}','Treasury\TreasuryController@dailyDep');
		Route::middleware('auth:api')->get('viewDep/{date}','Treasury\TreasuryController@viewDep');
		Route::middleware('auth:api')->get('checkClass/{checkClass}/{date}','Treasury\TreasuryController@checkClass');
		Route::middleware('auth:api')->post('addLogs','Treasury\TreasuryController@addLogs');
		Route::middleware('auth:api')->post('allLogsData','Treasury\TreasuryController@allLogsData');

/*=======================================================================================================================
 *Liquidation Routes
 *=======================================================================================================================
*/
Route::post('/login','AuthController@login');

Route::get('/getUserData','AuthController@testauth1');

