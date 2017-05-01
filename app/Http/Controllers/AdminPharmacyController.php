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
}
