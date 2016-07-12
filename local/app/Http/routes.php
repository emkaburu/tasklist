<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
	

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('home', function () {
        return view('welcome');
    });

    Route::resource('tasks', 'TaskController', ['except' => ['destroy']]);
    Route::post('state/{id}', 'TaskController@changeState');
    Route::post('tasks/delete/{id}', 'TaskController@destroy');

    //download excel
    Route::get('download-singleuser-excel', 'TaskController@downloadExcel')->name('download-excel-s');
    Route::get('download-allusers-excel', 'AdminController@getBigExcel')->name('download-excel-b');

    //download xml
    Route::get('download-singleuser-xml', 'TaskController@downloadXML')->name('download-xml-s');
    Route::get('download-allusers-xml', 'AdminController@getBigXML')->name('download-xml-b');
    
    //Handle account activations ... Do we need to put it under the Route::auth()?? 
	Route::get('user/activation/{token}', ['as' => 'user.activate', 'uses'=>'Auth\AuthController@activateUser']);

	//Administration group
	Route::group(['prefix' => 'admin'], function () {
	    Route::get('home', 'AdminController@index');
	    Route::get('users', 'AdminController@getUsers')->name('users');
	    Route::get('tasks', 'AdminController@getTasks')->name('admin.tasks');
	    Route::get('user/edit/{id}', 'AdminController@editUser')->name('user.edit');
	    Route::post('user/update/', 'AdminController@updateUser')->name('user.update');
	    Route::post('user/delete/{id}', 'AdminController@deleteUser')->name('user.delete');
	    Route::get('task/edit/{id}', 'AdminController@editTask')->name('task.edit');
	    Route::post('task/update/', 'AdminController@updateTask')->name('task.update');
	    Route::post('task/delete/{id}', 'AdminController@deleteTask')->name('task.delete');

	});

	Route::auth();
 