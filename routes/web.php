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