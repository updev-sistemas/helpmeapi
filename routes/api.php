<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'dashboard','middleware'=>['auth:api', \App\Http\Middleware\DashboardMiddleware::class]], function() {

    Route::get('users','UserController@index')->name('user.list'); // List
    Route::get('user/{id}','UserController@show')->name('user.show'); // Find
    Route::post('user','UserController@store')->name('user.store'); // Save

    Route::get('enterprises','EnterpriseController@index')->name('enterprise.list'); // List
    Route::get('enterprise/{id}','EnterpriseController@show')->name('enterprise.show'); // Find
    Route::post('enterprise','EnterpriseController@store')->name('enterprise.store'); // Save
    Route::put('enterprise/{id}','EnterpriseController@update')->name('enterprise.update'); // Update

    Route::get('projects', 'ProjectController@index')->name('project.list');
    Route::get('project/{id}', 'ProjectController@show')->name('project.show');
    Route::post('project','ProjectController@store')->name('project.store'); // Save
    Route::put('project/{id}','ProjectController@update')->name('project.update'); // Update


    Route::any("/", function(){
        return response()->json([
            'message'=>"Plataforma Versão " . env('APP_VERSION'),
            'app'=>'Help me',
            'description'=>'Software Helpdesk'
        ]);
    });
});

Route::group(['prefix'=>'customer','middleware'=>['auth:api',\App\Http\Middleware\CustomerMiddleware::class]], function() {
    Route::any("/", function(){
        return response()->json([
            'message'=>"Plataforma Versão " . env('APP_VERSION'),
            'app'=>'Help me',
            'description'=>'Software Helpdesk'
        ]);
    });
});

Route::group(['prefix'=>'supervisor','middleware'=>['auth:api',\App\Http\Middleware\SupervisorMiddleware::class]], function() {
    Route::any("/", function(){
        return response()->json([
            'message'=>"Plataforma Versão " . env('APP_VERSION'),
            'app'=>'Help me',
            'description'=>'Software Helpdesk'
        ]);
    });
});

Route::group(['prefix'=>'technician','middleware'=>['auth:api', \App\Http\Middleware\TechnicianMiddleware::class]], function() {
    Route::any("/", function(){
        return response()->json([
            'message'=>"Plataforma Versão " . env('APP_VERSION'),
            'app'=>'Help me',
            'description'=>'Software Helpdesk'
        ]);
    });
});

Route::get('profile','UserController@getProfile')->name('user.get_profile')->middleware('auth:api');
Route::post('profile','UserController@setProfile')->name('user.set_profile')->middleware('auth:api');
Route::post('profile/change/password','UserController@changePassword')->middleware('auth:api');

Route::any("/", function(){
    return response()->json([
        'message'=>"Plataforma Versão " . env('APP_VERSION'),
        'app'=>'Help me',
        'description'=>'Software Helpdesk'
    ]);
});
