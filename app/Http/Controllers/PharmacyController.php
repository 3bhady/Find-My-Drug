<?php

namespace App\Http\Controllers;

use App\Author;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades;
use JWTAuth;


class PharmacyController extends Controller
{


    public function signIn(Request $request)
    {

        $this->validate($request,[
           'email'=>'required|email',
            'password'=>'required'
        ]);


        $credentials =$request->only('email','password');



        try{
            if(!$token=JWTAuth::attempt($credentials))
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
    public function index()
    {
        //
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
        //
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
