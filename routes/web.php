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
use App\Events\EventName;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return view('home.index');
});


    Route::get('socket', 'SocketController@index');
Route::get('sendmessage', 'SocketController@sendMessage')->name('sendmessages');
Route::get('writemessage', 'SocketController@writemessage');


Route::group(['prefix'=>'notifications'],function() {
    Route::get('/', 'NotificationController@getIndex');
    Route::post('/post', 'NotificationController@postNotify')->name("notifications.post");
    Route::post('/poll', 'NotificationController@poll')->name("notifications.poll");


});

Route::get('/bridge', function() {
    $pusher = App::make('pusher');

    $pusher->trigger( 'test-channel',
        'test-event',
        array('text' => 'Preparing the Pusher Laracon.eu workshop!'));

    return view('welcome');
});

    //Admin

//Pharmacy Forms
Route::post('/admin/signin', 'AdminController@signin');

Route::get('/admin/pharmacyform','AdminController@index');
Route::get('/admin/pharmacyform/accept/{id}','AdminController@accept');
Route::get('/admin/pharmacyform/refuse/{id}','AdminController@refuse');
Route::post('/admin/pharmacyform/edit/{id}', 'AdminController@edit');

//Pharmacies
Route::get('/admin/pharmacy','AdminPharmacyController@index');
Route::get('/admin/pharmacy/delete/{id}','AdminPharmacyController@delete');
Route::post('/admin/pharmacy/edit/{id}', 'AdminPharmacyController@edit');


Auth::routes();
Route::get('admin/login', 'AdminController@AdminLogin');
Route::get('admin/home', 'AdminController@AdminHome');
Route::get('admin/logout', 'AdminController@AdminLogout');


