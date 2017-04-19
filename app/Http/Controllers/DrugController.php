<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Database\Seeder;
use App\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\MagicConst\File;
use TomLingham\Searchy\Facades\Searchy;
use Illuminate\Routing\Route;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    //return categories of every drug
       $categories= Drug::select('category')->groupBy('category')->paginate(20);
//link to get all drugs in it
        //
        foreach($categories as $cat)
        {

            $cat->href=$request->getUri()."/category/".preg_replace('/ /', "%20", $cat->category);
        }
       return response()->json($categories,200);

    }
    public function category($id)
    {
        $drugs = Drug::select('id','generic_name')->where('category',$id)->paginate(20);
        return $drugs;
    }

    public function translate()
    {
        $drugs=Drug::all();
        $out="";
        $shit="";
        $count=0;
        foreach($drugs as $drug)
        {
            $count++;
            $temp=$drug->slug_en;
            $temp=preg_replace('/[0-9]+/', '', $temp);
            $temp=preg_replace("/&/", ' ', $temp);
            $arr=explode(' ',$temp);
            foreach($arr as $bit)
            {
                $size = strlen($bit)-1;

                /*if($size>=0)
                {
                    $out.=$bit;
                    for($i=0;$i<3;$i++)
                    $out.=$bit[$size];
                    $out.=" ";
                }*/
                $out.="pok".$bit."pok"." ";
            }
            $out.="\n";
            if($count%1000==0)
            {
                file_put_contents('translate'.($count/1000).'.txt',$out);
                $out="";
            }
        }

        $response = ['test'=>'go to show route'];
        return response()->json($response,200);
    }

        public function slug_en()
    {


    $drugs = Drug::all();
//$counter=0;
    foreach($drugs as $drug)
    {
       // $counter++;
       // if($counter>=30)
         //   return "done 30 successfully";
        /*
         * 2t
         * 160mcg
         * 100c
         * */
        $name = $drug->generic_name;
        $slug="";
        $arr = explode(' ',$name);
        foreach($arr as $element)
        {
            $size = strlen($element);
            if($size==1)
            {
                if(!is_numeric($element))
                {
                    $slug=$slug.$element.' ';
                    continue;
                }
            }
            if($size>3)
            {
                if($element[$size-1]=='g'&&$element[$size-2]=='c'&&$element[$size-3]=='m')
                {
                    $test=false;
                    for($i=0;$i<$size-3;$i++)
                    {
                        if(!is_numeric($element[$i]))
                        {
                            $test=true;
                        }
                    }
                    if(!$test)
                        continue;
                }
            }

            $invalid = strpos($element, '/')
                + strpos($element,'.')
                + strpos($element,'%')
                + strpos($element,'(')
                + strpos($element,')')
                + strpos($element,'*')
                + strpos($element,'+')
            ;
            if($invalid!=0||$invalid!==0)
            {
                continue;
            }

            if(substr($element,-1)=='a'||substr($element,-1)=='s'||substr($element,-1)=='t')
            {
                $test = false;
                if($size-1==0||$element=='3s')
                {
                    $slug=$slug.$element.' ';
                    continue;
                }
                for($i=0;$i<$size-1;$i++)
                {
                    if(!is_numeric($element[$i]))
                    {
                        $test=true;
                    }
                }
                if(!$test)
                    continue;

            }

            if(strlen($element)==3)
             if($element[2]=='v'||$element[2]=='t'||$element[2]=='c')
            {
                if(is_numeric($element[0])&&$element[1]=='s'&&$element[2]=='t')
                    continue;
                if(is_numeric($element[0])&&is_numeric($element[1]))
                    continue;

            }

            if(($element[$size-1]=='g'&&$element[$size-2]=='m')||($element[$size-1]=='l'&&$element[$size-2]=='m')
            ||($element[$size-1]=='m'&&$element[$size-2]=='g')
                ||($element[$size-1]=='x'&&$element[$size-2]=='b'))
            {
                $test = false;
                for($i=0;$i<$size-2;$i++)
                {
                    if(!is_numeric($element[$i]))
                    {
                        $test=true;
                    }
                }
                if(!$test)
                    continue;
            }

        $slug=$slug.$element.' ';
          //  return $element;

        }
        $drug->slug_en=$slug;
        $drug->save();

    }
            /*
             * 120ml
                30gm
             *
             *
             * */
     /*   for($i=0;$i<18900;++$i)
        {
            levenshtein('test','t');
        }*/

      //  $response = ['Drugs'=>$i];

      //  $json = file_get_contents("text.json");
      //  $data = json_decode($json,true);

        // $i = 0;
//return response()->json($data,200);
          //  foreach($data as $bite) {
        //        foreach ($data as $byte) {

                    // $i++;
                    // if($i%2)
                    //{
                    /*
                     * "id": 1,
        "tradename": "123 120ml",
        "form": "syrup",
        "company": "hikma pharmaceuticals plc",
        "price": 10.5,
        "howmany": "120ml",
        "maingp": "influenza &common cold",
        "activeingredient": "1 mg chlorpheniramine\n15 mg pseudoephedrine\n160 mg paracetamol - acetaminophen"
      },
                     */
               /*     $byte='';
                    $name = $byte['tradename'];
                    $form = $byte['form'];
                    $company = $byte['company'];
                    $price = $byte['price'];
                    $howmany = $byte['howmany'];
                    $category = $byte['maingp'];
                    $activeingredient = $byte['activeingredient'];

                    $drug = new Drug(['generic_name' => $name, 'form' => $form,
                        'company' => $company, 'price' => $price,
                        'category' => $category, 'howmany' => $howmany,
                        'active_ingredient' => $activeingredient
                    ]);
                    try {
                 //       $drug->save();
                    }
                    catch(Exception $e)
                    {

                    } */
                    //}
                    // $category = $byte['Direction'];
          //      }

        //select all the drugs
        /*
           $meetings = Meeting::all();
        foreach ($meetings as $meeting)
        {
            $meeting->view_meeting=[
                'href'=>'api/v1/meeting/'.$meeting->id,
                'method'=>'GET'
            ];
        }
        $response = [
            'msg' => 'List of all Meetings',
            'meetings' => [
                $meetings

            ]
        ];
        return response()->json($response, 200);*/



$response = ['test'=>'go to show route'];
        return response()->json($response,200);
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
        //
        /*
         * $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'time' => 'required|date_format:YmdHie',
            'user_id' => 'required'
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $time = $request->input('time');
        $user_id = $request->input('user_id');

        $meeting = [
            'title' => $title,
            'description' => $description,
            'time' => $time,
            'user_id' => $user_id,
            'view_meeting' => [
                'href' => 'api/v1/meeting/1',
                'method' => 'GET'
            ]
        ];

        $response = [
            'msg' => 'Meeting created',
            'meeting' => $meeting
        ];

        return response()->json($response, 201);*/
        $this->validate($request,[
            'generic_name'=>'required',
            'price'=>'numeric|min:0'
        ]);
        $generic_name=$request->input('generic_name');
        $chemical_name=$request->input('chemical_name');
        $price=$request->input('price');
        $image=$request->input('image');
        $category=$request->input('category');


        $Drug = Drug::findOrFail($generic_name);


        $drug=[
            'generic_name'=>$generic_name,
            'chemical_name'=>$chemical_name,
            'price'=>$price,
            'image'=>$image,
            'category'=>$category,
            'view_drug'=>[
                'href'=>'api/v1/drug/',
                'method'=>'GET'
            ]
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response=Drug::select('active_ingredient','generic_name','price','image','category','form')->where('id',$id)->get();
        return response()->json($response,200);
    }

    public function search($id)
    {
        /* $users = Searchy::driver('fuzzy')->drugs('slug_en')->query($id)->select('generic_name','id')->get();
         $counter=0;

         $response = "";
         foreach($users as $user)
         {
             $counter++;
             if($counter>10)
                 break;
         $response[$user->generic_name]=$user->id;
         }
         return response()->json($response,200);

        */
        $drugs = Drug::select('slug_en')->get();
        $list =array();
        foreach($drugs as $drug)
        {
            $arr = explode(" ",$drug->slug_en);

            $l=1000;
            $test = false;
            foreach($arr as $element)
            {

                $current = levenshtein($id,$element);

                if($current<$l)
                    $l=$current;


            }

                if(empty($list[$l]))
                {
                    $list[$l] = array();

                }

                array_push($list[$l],$drug->slug_en);

        }

        ksort($list);
        $response1=array();
        $counter=0;
        foreach($list as $key)
        {
            foreach($key as $element)
            {

                if($counter<=20)
                {
                    $drugs=Drug::select('generic_name','id')->where('slug_en',$element)->get();

                    foreach($drugs as $drug)
                    {
                        if($response1[$drug->id]!=0) {
                            $response1[$drug->id] = $drug->generic_name;
                            $counter++;
                        }
                    }

                }
                else
                {
                    $response=array();
                    foreach(array_keys() as $i)
                    {
                        $value = $response1[$i];
                        $response[$value]=$i;
                    }
                    return response()->json($response,200);
                }
            }

        }
        return response()->json($list,200);

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
        return response()->json("destroy",200);
    }
}
