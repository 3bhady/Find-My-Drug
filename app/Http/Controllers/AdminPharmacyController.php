<?php

namespace App\Http\Controllers;

use App\Pharmacy;
use Illuminate\Http\Request;

class AdminPharmacyController extends Controller
{
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
        $pharmacy->delete();
        return redirect('admin/pharmacy/');
    }

}
