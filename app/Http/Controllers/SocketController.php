<?php

namespace App\Http\Controllers;

use App\DrugRequestPharmacyResponse;
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
                'addPharmacy','setOffline','pharmacyAcceptDrug'
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
        
        return response()->json($response,200);
    }

    public function pharmacyAcceptDrug(Request $request )
    {
        //set user_pharmacy_drug_request status from pending to done
        try{
            if(!$user=JWTAuth::parseToken()->authenticate())
            {
                return response()->json(['msg'=>'user not found'],404);
            }
        }
        catch (Exception $e)
        {
            return response()->json($e->getMessage(),404);

        }
        $response=$request->all();

        //send redis request
        $redis=Redis::connection();
        $redis->publish('pharmacyToCustomerResponse',json_encode($response));
        //edit request status from 0 //pending to 1 //done
        //customer drug request pharmacy response
         $request->input("drug_request_pharmacy_response_id");
        $CDRPR =
        DrugRequestPharmacyResponse::find( $request->input("drug_request_pharmacy_response_id"));
        $CDRPR->status=1;
        $CDRPR->save();
        return response()->json($CDRPR,200);
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
