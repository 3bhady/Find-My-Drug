<?php

namespace App\Http\Controllers;

use App\Author;
use App\DrugRequestPharmacyResponse;
use App\Pharmacy;
use App\User;
use Hash;
use Illuminate\Http\Request;
use OAuth2\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades;
use JWTAuth;


class PharmacyController extends Controller
{
    public function setOnline()
    {
        return "asdasdas";
    }

    public function signIn(Request $request)
    {
        /*
        $user=new User();
        $user->pharmacy id=1;
        $user->email="mohamedali@gmail.com";
        $user->password=bcrypt("underworld");
        $user->save();
*/
        
        $this->validate($request,[
           'email'=>'required|email',
            'password'=>'required'
        ]);

            error_log("HIIII");

        $credentials =$request->only('email','password');



        try{
            if(!$token=JWTAuth::attempt(array('email'=>$request->input('email'),
                'password'=>$request->input('password'))))
            {
                return response()->json(['msg'=>'invalid email or password',
                    'credentials'=>$credentials],401);
            }

        }
        catch(JWTException $e)
        {
            return response()->json(['msg'=>'Could not create token'],500);

        }
        $user=User::where('email',$request->input("email"))->first();
        $user->token=$token;
        $response=$user;
        return response()->json($response,200);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //testing endpoint
    public function index()
    {

    }
    public function history()
    {
        if(!$user=JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['msg'=>'user not found'],404);
        }
        $pharmacy=$user->pharmacy;

        $dRPR=   DrugRequestPharmacyResponse::
        where('pharmacy_id',$pharmacy->id)->paginate(8);
        return response()->json($dRPR,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pharmacy = User::find($id)->pharmacy;

       // $pharmacy = Pharmacy::where('id',$id)->get();
        $response=array();
        $response=[
            'name_en'=>$pharmacy->name_en,
            'id'=>$pharmacy->id,
            'landline'=>$pharmacy->landline,
            'open'=>$pharmacy->open,
            'close'=>$pharmacy->close,
            'address_en'=>$pharmacy->address_en,

        ];
        return response()->json($response,200);
    }
    public function updatePharmacyLocation(Request $request)
    {
        try{
        $id=$request->input("id");
        $lat=$request->input("lat");
        $lon=$request->input("lon");
        $pharmacy=User::find($id)->pharmacy;
        $pharmacy->lat=$lat;
        $pharmacy->lon=$lon;
        $pharmacy->save();
            return response()->json($pharmacy,200);
        }
        catch (Exception $E)
        {
            return response()->json(["status"=>"failed"],200);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
