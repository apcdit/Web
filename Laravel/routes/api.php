<?php

use Illuminate\Http\Request;
use App\uniDetails;

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

//routing for admin
Route::middleware('auth:api', 'admin')->group(function(){

    Route::get('/admin', function(){
        return response()->json([
            'message' => "Hello ".auth()->user()->uniNameCN
        ]);
    });

    Route::put('time/simulation/set', 'WarController@setSimTime');
    //update a certain post
    Route::put('post/{id}', 'PostsController@update');

    //destroy a certain post
    Route::delete('post/{id}','PostsController@destroy');

    //store a new post
    Route::post('post', 'PostsController@store');
});

//routing for user
Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {

        return response()->json([
            'user' => auth()->user(),
            'uniDetails' => auth()->user()->where('uniNameCN',auth()->user()->uniNameCN)->first()->uniDetails
        ]);
    });

    Route::post('logout', 'AuthController@logout');
    Route::put('editUser', 'UserController@updateDetails');
    //Route::get('time/simulation/get/{uniNameCN}', 'WarController@getSimTimeDiff');
    Route::get('time/simulation/get', 'WarController@getSimTimeDiff');
    Route::put('time/simulation/store', 'WarController@storeSimTimePress');
});


//view all the posts
Route::get('posts', 'PostsController@index');

//show one of the post
Route::get('post/{id}', 'PostsController@show');

//login
Route::post('login', 'AuthController@doLogin');

//register user with User and initialise uniDetails at the same time!! not uniDetails
Route::post('register','AuthController@createUser');



