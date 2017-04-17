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


//pharmacy form routes
Route::group(['prefix'=>'v1'],function(){
    Route::resource('pharmacyform','PharmacyFormController',[
   
    ]);



});



Route::group(['prefix'=>'v1'],function(){
        Route::get('drug/category/{id}',[
            'uses' => 'DrugController@category',
            'as' => 'category.drug'
        ]);
    Route::resource('drug','DrugController');

        Route::resource('request','RequestController');
    //,
      //  ['except'=>['edit','create']
       // ]);
  /*  Route::resource('meeting/registration','RegistrationController',[
        'only'=>['store','destroy']
    ]);
    Route::post('user',[
        'uses'=>'AuthController@store'
    ]);
    Route::post('user/signin',[
        'uses'=>'AuthController@signin'
    ]);
  */
});