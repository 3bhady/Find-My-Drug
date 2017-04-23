<?php

namespace App\Http\Controllers;

use App\User;
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
                'addPharmacy','setOffline'
            ]
        ]);
    }
    public function setOffline(Request $request)
    {
        if(!$user=JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['msg'=>'user not found'],404);
        }
        $user->online=0;
        $user->save();
        $response=json_encode($request->all());

        return $response;

    }

    public function addPharmacy(Request $request)
    {

        if(!$user=JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['msg'=>'user not found'],404);
        }
        $user=User::where('email',$request->input('email'))->first();
        $user->online=1;
        $user->save();

        $response=$request->all();
        $response["isOnline"]=$user->online;
        //authentication..
        $redis=Redis::connection();
        $redis->publish('addPharmacy',json_encode($response));
        return $request->all();
        return response()->json($response,200);
    }
    public function notifyPharmacy()
    {

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
      
    }
}
