<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'HomeController@index');

    Route::get('/tasks/{id}', 'TaskController@index');
    Route::post('/task', 'TaskController@store');
    Route::delete('/task/{task}', 'TaskController@destroy');
    //Route::put('/task/{task}', 'TaskController@edit');
    Route::post('/edit', 'TaskController@edit');
    Route::post('/delete', 'TaskController@destroyAjax');
    Route::get('/test', function(){
        return view('test.test');
    });
    
    Route::post('/project/{id}', 'ProjectController@store');
    
    Route::any('/organization', 'OrgController@index');
    Route::any('/organization/{id}', 'OrgController@manage');
    Route::any('/organization/{id}/leave', 'OrgController@leave');
    Route::get('/createorg', 'OrgController@create');
    Route::post('/neworg', 'OrgController@newOrg');
    
    Route::any('/organization/{id}/roles', 'RoleController@manage');
    Route::post('/organization/{id}/roles/save', 'RoleController@store');
    
    Route::post('/message/remove/{id}', 'MessageController@remove');
    Route::post('/message/accept/{id}', 'MessageController@accept');
    Route::post('/organization/{id}/invite', 'MessageController@invite');
    
    Route::get('/users/{id}', 'UserController@getUsers');
    Route::auth();

});
