<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redis;
use JWTAuth;
class SocketController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest');
        $this->middleware('jwt.auth',[
            'only'=>[
                'addPharmacy'
            ]
        ]);
    }

    public function addPharmacy(Request $request)
    {

        if(!$user=JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['msg'=>'user not found'],404);
        }

        $response=$request->all();
        //authentication..
        $redis=Redis::connection();
        $redis->publish('addPharmacy',json_encode($response));
        return response()->json($response,200);
    }
    public function notifyPharmacy()
    {
        $response=[
            "id"=>"4"
        ];
        $redis=Redis::connection();
        $redis->publish('notification',json_encode($response));

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
