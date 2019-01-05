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

Route::group(['middleware' => ['auth:api', 'admin']],function(){
    Route::get('/admin', function(){
        return response()->json([
            'message' => "Hello ".auth()->user()->uniNameCN
        ]);
    });

    Route::get('/optimize', function(){
        $exitCode = Artisan::call('optimize');
        return response()->json([
            'message' => "optimized!"
        ]);
    });
    Route::get('/config-cache', function(){
        $exitCode = Artisan::call('config:cache');
        return response()->json([
            'message' => "config cached!"
        ]);
    });
    
    Route::get('time/all', 'WarController@getAllTime');
    Route::get('user/all', 'UserController@getUsers');
    Route::put('time/simulation/set', 'WarController@setSimTime');
    Route::put('time/official/set', 'WarController@setOffTime');
    Route::put('time/official/reset', 'WarController@reset');
    Route::get('time/get', 'WarController@getTimeDiff');
    Route::get('question/all', 'UserController@getDebateQuestions');
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
    //Route::get('time/simulation/get/{uniNameCN}', 'WarController@getSimTimeDiff')
    //Route::get('time/simulation/getDraw', 'WarController@getDraw');

    Route::get('time/official/get', 'WarController@getOffTimeDiff');
    Route::put('time/official/store', 'WarController@storeOffTimePress');
    Route::get('time/official/start', 'WarController@getOffStartTime');
    Route::get('time/official/getDraw', 'WarController@getDraw');
    
});

Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
    Route::post('change', 'PasswordResetController@change');
});

//view all the posts
Route::get('posts', 'PostsController@index');

//show one of the post
Route::get('post/{id}', 'PostsController@show');

//login
Route::post('login', 'AuthController@doLogin');

Route::get('posts/latest','PostsController@showLatest');

//register user with User and initialise uniDetails at the same time!! not uniDetails
Route::post('register','AuthController@createUser');

Route::post('uploadFile', 'AuthController@upload');

Route::get('downloadFile', function(){
    return response()->download(storage_path("app/public/{$filename}"));
});