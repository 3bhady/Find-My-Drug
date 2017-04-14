<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\PharmacyForm;

class PharmacyFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmaciesForms=PharmacyForm::all();
        $response = [

           "pharmacies"=>$pharmaciesForms,
             "message"=>"working"
        ];
        return response()->json($response, 200);
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
        $this->validate($request, [

            "name_en"=>'required|min:3',
            "address_en"=>'required|min:3',
            "landline"=>'required|min:5',
            "mobile"=>'required|min:3|numeric',
            "email"=>'required|min:3|email',
            "mobile2"=>'required|min:3|numeric',
            "owner_name"=>'required|min:3',
            "password"=>'required|min:3',
            "home_delivery"=>'required',
            "open"=>'required',
            "close"=>'required',
            "name_ar"=>'required|min:3',
            "address_ar"=>'required|min:3'
        ]);
        $pharmacyForm= new PharmacyForm([
          "name_en"=>$request->input("name_en"),
          "address_en"=> $request->input("address_en"),
          "landline"=> $request->input("landline"),
          "mobile"=>$request->input("mobile"),
          "email"=> $request->input("email"),
          "mobile2"=> $request->input("mobile2"),
          "owner_name"=>$request->input("owner_name"),
          "password"=> $request->input("password"),
          "home_delivery"=> $request->input("home_delivery"),
          "open"=> $request->input("open"),
          "close"=> $request->input("close"),
          "name_ar"=> $request->input("name_ar"),
          "address_ar"=> $request->input("address_ar")

        ]);
        try{
        $pharmacyForm->save();
            $response=[
                "status"=>"success",
                "pharmacyFormInfo"=>$pharmacyForm
            ];
        }
        catch(Exception $e){
            $response=[
                "status"=>"failed",
                "pharmacyFormInfo"=>$pharmacyForm
            ];
    }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pharmacyForm=PharmacyForm::Find($id);
        $response=[
            "pharmacy"=>$pharmacyForm
        ];
        return response()->json($response,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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
        $pharmacyForm=PharmacyForm::Find($id);
        $pharmacyForm->name_en=$request->input("name_en");
        $pharmacyForm->address_en=$request->input("address_en");
        $pharmacyForm->landline=$request->input("landline");
        $pharmacyForm->mobile=$request->input("mobile");
        $pharmacyForm->email=$request->input("email");
        $pharmacyForm->mobile2=$request->input("mobile2");
        $pharmacyForm->owner_name=$request->input("owner_name");
        $pharmacyForm->password=$request->input("password");
        $pharmacyForm->home_delivery=$request->input("home_delivery");
        $pharmacyForm->open=$request->input("open");
        $pharmacyForm->close=$request->input("close");
        $pharmacyForm->name_ar=$request->input("name_ar");
        $pharmacyForm->address_ar=$request->input("address_ar");
        try{
            $pharmacyForm->save();

            $response=[
                "status"=>"success",
                "pharmacyToEdit"=>$pharmacyForm,

            ];
        }
        catch(Exception $e){
            $response=[
                "status"=>"failed",
                "pharmacyToEdit"=>"null",
                "Exception"=>$e->getMessage()
            ];
    }
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pharmacyForm=PharmacyForm::Find($id);
        try{
            $pharmacyForm->delete();
            $response=[
                "status"=>"success"

            ];

        }
        catch (Exception $e)
        {
            $response=[
                "status"=>"failed",
                "Exception"=>$e->getMessage()

            ];
        }
        return response()->json($response,200);
    }
}
