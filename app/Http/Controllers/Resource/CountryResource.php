<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\Cities;
use App\ServiceType;
use App\ServiceMapping;
use App\TimeZone;
use Setting;
use Exception;
use App\Helpers\Helper;

class CountryResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    public function index()
    {
       
 
        $countries = Country::get();
        return view('admin.country.index',compact('countries'));
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
        echo 'show';

       die();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('admin.country.edit', compact('country'));
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
 

        try{

            $country = Country::find($id);
            $country->name = $request->name;
            $country->code = $request->code;
            $country->dial_code = $request->dial_code;
            $country->currency_name = $request->currency_name;
            $country->currency_symbol = $request->currency_symbol;
            $country->currency_code = $request->currency_code;
            $country->save();

            return redirect()->back()->with('flash_success','Country Updated');
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
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

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    { 

         try {
   
            $country = Country::findOrFail($id);
            if($country->status == 0){
                $country->status = 1;
                $message = 'Country Activated Successfully';
            }else{
                $country->status = 0;
                $message = 'Country De-activated Successfully';
            }
            $country->update();

            return redirect()->back()->with('flash_success', $message);

             
        } catch (ModelNotFoundException $e) {

            return back()->with('flash_error', 'Something Went Wrong');
        }


        }

        public function time_zone($code)
        { 
    
            $time_zone = TimeZone::where('country_code', $code)->get();
            return $time_zone;
    
    
            }
    
        public function active() {


            try {           
                $wc = Country::where('status','1')->get();
                
                // dd($wc);
                return view('admin.country.active',compact('wc'));
                // echo "sdf";
                 
    
            } catch (Exception $e) {
                 return back()->with('flash_error','Something Went Wrong!');
            }
        
        }
        public function respective_timezone($id)
        {
          
            $country = Country::findOrFail($id);
            $time_zone = TimeZone::where('country_code', $country->code)->get();
            $array = array(                
                'time_zone' => $time_zone
            );
            return $array;
        }

         public function respective_city($id)
        {
          
            $country = Country::findOrFail($id);                     
            $countryname=$country->name;
            $cities = \DB::table('cities')->where('country_code',$country->code)->get();
            
            return view('admin.country.city',compact('cities','countryname','country'));
        }

        public function city_edit($id)
        {

            $cities = \DB::table('cities')->where('id',$id)->get();          
            $country = Country::where('code',$cities[0]->country_code)->first();
            $country_code=$country->code;           
            return view('admin.country.city_edit',compact('cities','country','country_code')); 
        }

    public function city_status($id)
    { 

         try {
   
            $city = \DB::table('cities')->where('id',$id)->get();
            if(!empty($city))
                {

                    if($city[0]->status == 0)
                    {
                        $updatesServiceMapping = ServiceType::all();
                        foreach ($updatesServiceMapping as $key => $servicemapping) {
                            $insertempty = new ServiceMapping;
                            $insertempty->service_id =$servicemapping->id;
                            $insertempty->country_id =@Country::wherecode($city[0]->country_code)->first()->id;
                            $insertempty->city_id =$city[0]->id;
                            $insertempty->fixed =0;
                            $insertempty->price =0;
                            $insertempty->capacity =0;
                            $insertempty->minute =0;
                            $insertempty->distance =0;
                            $insertempty->hour =0;
                            $insertempty->calculator =0;
                            $insertempty->status =0;
                            $insertempty->save();

                        } 

                        $city[0]->status = 1;
                        $message = 'City Activated Successfully';
                    }
                    else
                    {
                        $updatesServiceMapping = ServiceType::all();
                        foreach ($updatesServiceMapping as $key => $servicemapping) { 
                            $insertempty = ServiceMapping::wherecountry_id(@Country::wherecode($city[0]->country_code)->first()->id)->wherecity_id($city[0]->id)->whereservice_id($servicemapping->id)->delete();  
                        } 
                        $city[0]->status = 0;
                        $message = 'City De-activated Successfully';
                    }
                    

                        \DB::table('cities')
                        ->where('id',$id) 
                        ->limit(1)  
                        ->update(array('status' => $city[0]->status));    

                    return redirect()->back()->with('flash_success', $message);


                } 
                

            }
            catch (ModelNotFoundException $e) 
            {

                return back()->with('flash_error', 'Something Went Wrong');
            }
            


    }

        public function city_update(Request $request)
        {
            

                $explodeCityname=explode(" ",$request->city);
                if(count($explodeCityname)>2)
                {
                    $explodeCityname[0]=$explodeCityname[0].' '.$explodeCityname[1];

                }
                    $Cities=\DB::table('cities')
                        ->where('name','like','%'. $explodeCityname[0] .'%') 
                         ->where('country_code',$request->code) 
                         ->where('id','!=',$request->CityId) 
                        ->get();
                if(count($Cities) ==0)
                {

                    \DB::table('cities')
                    ->where('id',$request->CityId) 
                    ->limit(1)  
                    ->update(array('name' => $request->city)); 
                    $message = 'City Name Updated Successfully';
                    return redirect()->back()->with('flash_success', $message);
                }
                else
                {

                    $message = 'City Name Alreday Exist';
                    return redirect()->back()->with('flash_error', $message);
                }
           
        }

        public function city_add($id)
        {                
                    
            $country = Country::find($id);
            $country_code=$country->code;           
            return view('admin.country.city_add',compact('country','country_code')); 
           
        }

        public function city_save(Request $request)
        {

          
                $explodeCityname=explode(" ",$request->city);
                if(count($explodeCityname)>2)
                {
                    $explodeCityname[0]=$explodeCityname[0].' '.$explodeCityname[1];

                }
                $Cities=\DB::table('cities')
                        ->where('name','like','%'. $explodeCityname[0] .'%') 
                         ->where('country_code',$request->code) 
                        ->get();




                        if(count($Cities) ==0)
                        {
                             
                             \DB::table('cities')->insert(
                                ['country_code' => $request->code, 
                                'name' => $request->city]
                            );

                            $message = 'City Name Saved Successfully';
                             return redirect()->back()->with('flash_success', $message);
                        }
                        else
                        {
                           
                            
                            $message = 'City Name Alreday Exist';
                            return redirect()->back()->with('flash_error', $message);
                        }
                        
                
           
        }


        
        public function active_dispatcher_city(Request $request) {

           $country_id=$request->country_id;
           if($country_id=="Select Country")
           {
               return 0;
           }
           else
           {
               $country = Country::findOrFail($country_id);
               return Cities::where('country_code', $country->code)->where('status',1)->get();
           }
       } 
       public function active_dispatcher() {

           return Country::where('status','1')->get();

       }
    
        

        

}
