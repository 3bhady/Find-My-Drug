<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Pharmacy;
use App\PharmacyForm;
use Illuminate\Http\Request;
use JWTAuth;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        {
            $validator = validator([
                'username'=>'required',
                'password'=>'required'
            ]);

            $username = $request->input('username');
            $password =  $request->input('password');

            $Admin = Admin::where('username', '=', $username);
            if(!$validator->fails()) {
                if ($Admin->exists()) {


                    $credentials=[
                        'username' => $username,
                        'password' => $password,
                    ];
                    try
                    {
                        $token =JWTAuth::attempt($credentials);
                    }
                    catch(JWTException $e)
                    {
                        return response()->json(['msg'=>'could not create token'],500);
                    }

                    return response()->json([
                        'msg' => 'logged in',
                        'data' => $Admin->get(),
                        'token'=>$token,
                    ]);

                } else {
                    return response()->json([
                        'msg' => 'Wrong credentials',
                    ], 500);
                }
            }
            else
            {
                return response()->json($validator->messeges() ,500);
            }

        }

    }
    public function index()
    {
        $title='Pharmacy Forms';
        $data=PharmacyForm::all();
        if(count($data)>0)
            return view('AdminPanel')->with('data',$data)->with('title',$title);
        else
            return;
    }
    public function accept($id)
    {
        $pharmacyform=PharmacyForm::find($id);



        $pharmacy= new Pharmacy;
        $pharmacy->name_en=$pharmacyform->name_en;
        $pharmacy->address_en=$pharmacyform->address_en;
        $pharmacy->owner_name=$pharmacyform->owner_name;
        $pharmacy->landline=$pharmacyform->landline;
        $pharmacy->mobile=$pharmacyform->mobile;
        $pharmacy->email=$pharmacyform->email;
        $pharmacy->password=$pharmacyform->password;
        $pharmacy->mobile2=$pharmacyform->mobile2;
        $pharmacy->home_delivery=$pharmacyform->home_delivery;
        $pharmacy->open=$pharmacyform->open;
        $pharmacy->close=$pharmacyform->close;
        $pharmacy->name_ar=$pharmacyform->name_ar;
        $pharmacy->address_ar=$pharmacyform->address_ar;
        $pharmacy->save();

         $pharmacyform->delete();

        return redirect('admin/pharmacyform/');
    }

    public function refuse($id)
    {
        $pharmacyform=PharmacyForm::find($id);
        $pharmacyform->delete();
        return redirect('admin/pharmacyform/');
    }
}
