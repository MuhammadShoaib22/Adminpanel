<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Setting;
use Exception;
use App\Helpers\Helper;

use App\ServiceType;
use App\ProviderService;
use App\ServiceMapping;
use App\Country;

class ServiceResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => [ 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = ServiceType::all();
        if($request->ajax()) {
            return $services;
        } else {
            return view('admin.service.index', compact('services'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required|max:255',            
            /*'capacity' => 'required|numeric',
            'fixed' => 'required|numeric',
            'price' => 'sometimes|nullable|numeric',
            'minute' => 'sometimes|nullable|numeric',
            'hour' => 'sometimes|nullable|numeric',
            'distance' => 'sometimes|nullable|numeric',*/
            'calculator' => 'required|in:MIN,HOUR,DISTANCE,DISTANCEMIN,DISTANCEHOUR',
            'image' => 'mimes:ico,png'
        ]);

        try {
            $service = new ServiceType;

            $service->name = $request->name;            
            /*$service->fixed = $request->fixed;*/
            $service->description = $request->description;
            $service->calculator  = $request->calculator;

            if($request->hasFile('image')) {
                $service->image = Helper::upload_picture($request->image);
            }

           /* if(!empty($request->price))
                $service->price = $request->price;
            else
                $service->price=0;

            if(!empty($request->minute))
                $service->minute = $request->minute;
            else
                $service->minute = 0;

            if(!empty($request->hour))
                $service->hour = $request->hour;
            else
                $service->hour = 0;

            if(!empty($request->distance))
                $service->distance = $request->distance;
            else
                $service->distance = 0;*/
          
            $service->save();

            return back()->with('flash_success', trans('admin.service_type_msgs.service_type_saved'));
        } catch (Exception $e) {
            dd("Exception", $e);
            return back()->with('flash_error', trans('admin.service_type_msgs.service_type_not_found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return ServiceType::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.service_type_msgs.service_type_not_found'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

            try {
            $service = ServiceType::findOrFail($id);

            
            
            $service_id=$id;

            
           

            

            $list_country =  Country::where('status','1')            
            ->get();

            


            return view('admin.service.edit',compact('service','list_country','service_id'));

            } catch (Exception $e) {
                
            return back()->with('flash_error', 'Service Type Not Found');
            }
    }

    public function service_citywise($code,$serviceId)
    {

        try {
       /* $cities = \DB::table('cities')->where('country_code',$code)->where('status',1)->get();*/
        $country=Country::where('code',$code)->first();
        $service = ServiceType::findOrFail($serviceId);
        
        $wc =  ServiceMapping::with('world')->Where('service_id',$serviceId)->where('country_id',$country->id)->get();

        $cid = array();
        foreach ($wc as $key => $value) {
            // code...
            $cid[] = $value->city_id; 
        }
        
        $list_city=\DB::table('cities')
            ->whereNotIn('id',$cid)
            ->where('status',1)
            ->where('country_code',$country->code)
            ->get();


        
        
            return view('admin.service.city_wise',compact('country','service','list_city','wc'));
       }
        
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }

    public function service_citywise_update(Request $request)
    {


        try 
        {
            if($request->fixed){

                foreach ($request->fixed as $key => $value) { 
                if(!empty($value))
                {   
                    $service_map = ServiceMapping::where('service_id',$request->serviceID)
                                                ->where('city_id',$key) 
                                                ->where('country_id',$request->country_id)
                                                ->update(['fixed'=>$value,'price'=>$request->price[$key],'distance'=>$request->distance[$key],'minute'=>$request->minute[$key],'hour'=>$request->hour[$key],'capacity'=>$request->capacity[$key],'calculator'=>$request->calculator,'status'=>'1']);
                }
                }

            }
         if($request->new_fixed){

                foreach ($request->new_fixed as $key1 => $value1) { 

                if(!empty($value1))
                {
                    $service_map = ServiceMapping::create(['service_id'=>$request->serviceID,'country_id'=>$request->country_id,'city_id'=>$key1,'fixed'=>$value1,'price'=>$request->price[$key1],'distance'=>$request->distance[$key1],'minute'=>$request->minute[$key1],'hour'=>$request->hour[$key1],'capacity'=>$request->capacity[$key1],'calculator'=>$request->calculator,'status'=>'1']);
                } 

                    
                    
                }
        }

         return redirect()->route('admin.service.edit',$request->serviceID)->with('flash_success', 'Service Type Updated Successfully'); 

    }

     catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.service_type_msgs.service_type_not_found'));
        }
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'mimes:ico,png'
        ]);

        try {

            $imgservice=ServiceType::find($id);

            

            $service['name'] = $request->name;

            /*$service['fixed'] = $request->fixed;

            if(!empty($request->price))
                $service['price'] = $request->price;
            else
                $service['price']=0;

            if(!empty($request->minute))
                $service['minute'] = $request->minute;
            else
                $service['minute'] = 0;

            if(!empty($request->hour))
                $service['hour'] = $request->hour;
            else
                $service['hour'] = 0;

            if(!empty($request->distance))
                $service['distance'] = $request->distance;
            else
                $service['distance'] = 0;

            
            $service['capacity'] = $request->capacity; */          
            $service['calculator'] = $request->calculator;
            $service['description'] = $request->description;

            $servicetype=ServiceType::find($id);
            $servicetype->name=$service['name'];
            if($request->hasFile('image')) {
                if($imgservice->image) {
                    Helper::delete_picture($imgservice->image);
                }
            $servicetype->image =Helper::upload_picture($request->image); 
            }
            $servicetype->calculator=$service['calculator'];
            $servicetype->description=$service['description'];
            $servicetype->save();

            return redirect()->route('admin.service.index')->with('flash_success', trans('admin.service_type_msgs.service_type_update'));    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.service_type_msgs.service_type_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
              
        try {
            $provider_service=ProviderService::where('service_type_id',$id)->count();
            if($provider_service>0){
                return back()->with('flash_error', trans('admin.service_type_msgs.service_type_using'));
            }
            
            ServiceType::find($id)->delete();
            return back()->with('flash_success', trans('admin.service_type_msgs.service_type_delete'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.service_type_msgs.service_type_not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('admin.service_type_msgs.service_type_not_found'));
        }
    }
}