<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redis;
class socketController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest');
    }
    public function index()
    {
        return view('socket');
    }
    public function writemessage()
    {
        return view('writemessage');
    }
    public function sendMessage(){
        $redis = Redis::connection();
        $redis->publish('message', 'esht8l y ws5 y 2bn el ****');
      //  return redirect('writemessage');
    }
}
