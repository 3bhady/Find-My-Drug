<?php

namespace App\Http\Controllers;

use App\Pharmacy;
use Illuminate\Http\Request;
use App\User;

class AdminPharmacyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Pharmacies';
        $data=Pharmacy::all();
        if(count($data)>0)
            return view('AdminPanel')->with('data',$data)->with('title',$title);
        else
            return;
    }
    public function delete($id)
    {
        $pharmacy=Pharmacy::find($id);
        $user=User ::where('email','=',$pharmacy->email);
        $user->delete();
        $pharmacy->delete();
        return redirect('admin/pharmacy/');
    }
    public function edit($id,Request $request)
    {
        $pharmacy = Pharmacy::find($id);

        $pharmacy->name_en = $request->get('name_en');
        $pharmacy->address_en= $request->get('address_en');
        $pharmacy->owner_name= $request->get('owner_name');
        $pharmacy->landline= $request->get('landline');
        $pharmacy->mobile= $request->get('mobile');
        $pharmacy->email= $request->get('email');
        $pharmacy->open= $request->get('open');
        $pharmacy->close= $request->get('close');
        $pharmacy->save();
        return redirect('/admin/pharmacy');


    }
}
