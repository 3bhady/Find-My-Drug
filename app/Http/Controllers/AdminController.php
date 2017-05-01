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
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('AdminLogin','signin');
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

        if ( ! Auth::attempt($credentials))
        {
            return Redirect::back()->withMessage('Invalid credentials');
        }

        if (Auth::user()->admin_id != NULL)
        {
            return   redirect('/admin/home');
        }

        return  redirect('/admin/login');


    }
    public function AdminLogout(Request $request)
    {
        Auth::logout();
        return view('AdminLogin');
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
        $user->pharmacy_id = $pharmacy->id;
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
}
