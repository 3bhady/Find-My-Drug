<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Pharmacy;
use App\PharmacyForm;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('AdminLogin', 'signin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AdminLogin(Request $request)
    {
        return view('AdminLogin');

    }

    public function AdminHome(Request $request)
    {
        return view('AdminHome');
    }

    public function signin(Request $request)
    {
        $credentials = Input::only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return Redirect::back()->with('invalid_input', ['error']);;
        }

        if (Auth::user()->type == 2) {
            return redirect('/admin/pharmacy');
        }

        return redirect('/admin/login');


    }

    public function AdminLogout(Request $request)
    {
        try {
            Auth::logout();
            return view('AdminLogin');
        }
        catch (\Exception $exceptione) {
            return view('AdminLogin');
        }
    }

    public function index()
    {

        $title = 'Pharmacy Forms';
        $data = PharmacyForm::all();
        if (count($data) > 0)
            return view('AdminPanel')->with('data', $data)->with('title', $title);
        else
            return;
    }

    public function accept($id)
    {


        $pharmacyform = PharmacyForm::find($id);

        $pharmacy = new Pharmacy;
        $pharmacy->name_en = $pharmacyform->name_en;
        $pharmacy->address_en = $pharmacyform->address_en;
        $pharmacy->owner_name = $pharmacyform->owner_name;
        $pharmacy->landline = $pharmacyform->landline;
        $pharmacy->mobile = $pharmacyform->mobile;
        $pharmacy->email = $pharmacyform->email;
        $pharmacy->password = $pharmacyform->password;
        $pharmacy->mobile2 = $pharmacyform->mobile2;
        $pharmacy->home_delivery = $pharmacyform->home_delivery;
        $pharmacy->open = $pharmacyform->open;
        $pharmacy->close = $pharmacyform->close;
        $pharmacy->name_ar = $pharmacyform->name_ar;
        $pharmacy->address_ar = $pharmacyform->address_ar;
        $pharmacy->save();

        $user = new User;
        $user->type = 0;
        $user->name = $pharmacy->name_en;
        $user->email = $pharmacy->email;
        $user->password = bcrypt($pharmacy->passwrod);
        $user->save();

        $pharmacyform->delete();

        return redirect('admin/pharmacyform/');
    }

    public function refuse($id)
    {

        $pharmacyform = PharmacyForm::find($id);
        $pharmacyform->delete();
        return redirect('admin/pharmacyform/');
    }

    public function edit($id,Request $request)
    {
        $pharmacyform = PharmacyForm::find($id);

        $validator =  Validator::make($request->all(), [

            'address_en' => 'required|max:255|min:10',
            'owner_name' => 'required|max:255',
            'landline' => 'required|max:255|digits:8',
            'mobile' => 'required|max:255|digits:11',
            'email' => 'required|max:255|email',
            'open' => 'required|max:255',
            'close' => 'required|max:255',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('submit_error', ['Invalid Input']);
           // return response()->json('Invalid Input',200);
        }
        $pharmacyform->name_en = $request->get('name_en');
        $pharmacyform->address_en= $request->get('address_en');
        $pharmacyform->owner_name= $request->get('owner_name');
        $pharmacyform->landline= $request->get('landline');
        $pharmacyform->mobile= $request->get('mobile');
        $pharmacyform->email= $request->get('email');
        $pharmacyform->open= $request->get('open');
        $pharmacyform->close= $request->get('close');


        try {
            $pharmacyform->save();
        }
        catch (\Exception $exception)
                {
                    return redirect()->back()->with('submit_error', ['Invalid Input']);
                    //return response()->json('Invalid Input',200);
                }
        return redirect()->back()->with('submit_success', ['succes']);


    }

}
