<?php

namespace App\Http\Controllers;

use App\Pharmacy;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return "index";
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

      //  return "store function";
        $this->validate($request, [
            "long"=>'required|numeric',
            "lat"=>'required|numeric',
            "drug_id"=>'required|numeric'
        ]);
        $pharmacies = Pharmacy::select('long','lat')->get();
        $list= array();
        foreach($pharmacies as $pharmacy)
        {
            $long1=$pharmacy->long;
            $lat1=$pharmacy->lat;
            $long2=$request->input('long');
            $lat2=$request->input('lat');
            $distance = sqrt(pow((int)$long2-(int)$long1,2)+pow($lat1-$lat2,2));
            if(empty($list[(string)$distance]))
            {
                $list[(string)$distance]=array();
            }
            array_push($list[(string)$distance],$pharmacy->id);
        }
        ksort($list);

        //$list=array_splice($list,15);
        $response=array();
        $counter=0;
        foreach($list as $key)
        {
            foreach($key as $element)
                if($counter<=20)
                {
                    array_push($response,$element);
                    $counter++;
                }
                else
                {
                    return response()->json($response,200);
                }

        }
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
