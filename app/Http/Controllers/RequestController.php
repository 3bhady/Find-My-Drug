<?php

namespace App\Http\Controllers;

use App\Drug;
use App\Pharmacy;
use App\User;
use Illuminate\Http\Request;
use Redis;

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
        $pharmacies = Pharmacy::select('id','name_en')->get();

        return response()->json($pharmacies,200);
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
            "lon"=>'required|numeric',
            "lat"=>'required|numeric',
            "drug_id"=>'required|numeric'
        ]);

        $response=array();

        $pharmacies = Pharmacy::select('id','lon','lat','user_id')->with('user')
            ->get();
        $i=0;
        foreach($pharmacies as $pharmacy)
        {
            $i++;
            if($pharmacy["user"]["online"]=='1')
            {
                array_push($response,$pharmacy);
            }
        }
        $pharmacies=$response;


     //   return $pharmacies;
        $list= array();
        foreach($pharmacies as $pharmacy)
        {
            $long1=$pharmacy->lon;
            $lat1=$pharmacy->lat;
            $long2=$request->input('lon');
            $lat2=$request->input('lat');
            $distance = sqrt(pow((int)$long2-(int)$long1,2)+pow($lat1-$lat2,2));
            $distance=strval($distance);
            if(empty($list[$distance]))
            {
                $list[$distance]=array();
            }
            array_push($list[$distance],$pharmacy->id);
        }
        ksort($list);
       //     return $list;
        //$list=array_splice($list,15);
        $response=array();
        $counter=0;
        foreach($list as $key)
        {
            foreach($key as $element)
                if($counter<2)
                {
                    //select id from  users where pharmacy_id=$element
                    $user_id=Pharmacy::find($element)->user;

                    array_push($response,$user_id->id);

                    $counter++;
                }


        }
        //get user id to be send to the pharmacy
        $drugName=Drug::select('generic_name')
            ->where('id',$request->input('drug_id'))->first();
        $response=[
            "pharmacies"=>$response,
            "user_id"=>$request->input("id"),
            "drug_name"=>$drugName->generic_name
        ];
        //todo:store in database user/request..
        //todo:send  to pharmacies
        //i will do now notifying pharmacy

        $redis=Redis::connection();

        $redis->publish('notification',json_encode($response));
        return response()->json($response,200);


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
