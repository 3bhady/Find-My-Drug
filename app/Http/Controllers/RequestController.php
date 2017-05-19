<?php

namespace App\Http\Controllers;

use App\Drug;
use App\DrugRequestPharmacyResponse;
use App\Pharmacy;
use App\User;
use App\DrugRequest;
use Illuminate\Http\Request;
use OAuth2\Exception;
use Redis;

const pharmacies_limit = 2;

class RequestController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
        $this->middleware('jwt.auth',[
            'only'=>[
                'pharmacyAcceptDrug'
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmacies = Pharmacy::select('id','lon','lat','user_id')->with('user')
            ->get();
return $pharmacies;

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



       //return "store function";
        $this->validate($request, [
            "lon"=>'required|numeric',
            "lat"=>'required|numeric',
            "drug_id"=>'required|numeric',
            "user_id"=>'required|numeric'
        ]);

        $customer = User::find($request->input("user_id"))->customer;

        $drug = Drug::where('id',$request->input('drug_id'))->first();


        if($drug == null)
        {
            return "NO Drug found!";
        }

        if($customer == null)
        {
            return "NO Customer found!";
        }

        $customer->drug()->attach($drug);



        //Does not insert updated and created at database table
        //$customer->save();




//        return "s0";



        $response=array();

        $pharmacies = Pharmacy::select('id','lon','lat','user_id')->with('user')
            ->get();
       // return response()->json(['ESHTA'],200);
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
        $pharmacy_local_id_list=array();
        foreach($list as $key)
        {
            foreach($key as $element)
                if($counter<pharmacies_limit)
                {
                    array_push($pharmacy_local_id_list,$element);
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
            "user_id"=>$request->input("user_id"),
            "drug_id"=>$request->input("drug_id"),
            "drug_name"=>$drugName->generic_name
        ];


        //todo:store in database user/request..
        //todo:send  to pharmacies
        //i will do now notifying pharmacy

        $redis=Redis::connection();

        $redis->publish('notification',json_encode($response));


//saving request
        foreach($pharmacy_local_id_list as $pharmacy)
        {
            $pharmacy_ = Pharmacy::where('id',$pharmacy)->first();
            $drug_request = DrugRequest::select('id')
                ->where([
                ['customer_id','=',$customer->id]],
                ['drug_id','=',$drug->id])
                ->orderBy('id', 'desc')
                ->first();

           $dRPR=new DrugRequestPharmacyResponse();
            $dRPR->pharmacy_id=$pharmacy_->id;
            $dRPR->status=0;
            $dRPR->drug_request_id=$drug_request->id;
            $dRPR->save();

          //$pharmacy_->drugrequest()->associate($drug_request);

        }


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
