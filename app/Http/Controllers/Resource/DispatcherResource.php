<?php

namespace App\Http\Controllers\Resource;

use App\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use Setting;
use App\Country;

class DispatcherResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => ['store','update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $country_code =Country::wherecode($request->country_code)->first(); 
        $dispatchers = Dispatcher::where('country_id',@$country_code->id)->orderBy('created_at' , 'desc')->get();
        return view('admin.dispatcher.index', compact('dispatchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dispatcher.create');
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
            'mobile' => 'digits_between:6,13',
            'email' => 'required|unique:dispatchers,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try{

            $Dispatcher = $request->all();
            $Dispatcher['password'] = bcrypt($request->password);

            $Dispatcher = Dispatcher::create($Dispatcher);

            return back()->with('flash_success', trans('admin.dispatcher_msgs.dispatcher_saved'));

        } 

        catch (Exception $e) {
            return back()->with('flash_error', trans('admin.dispatcher_msgs.dispatcher_not_found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $dispatcher = Dispatcher::findOrFail($id);
            return view('admin.dispatcher.edit',compact('dispatcher'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
        ]);

        try {

            $dispatcher = Dispatcher::findOrFail($id);
            $dispatcher->name = $request->name;
            $dispatcher->mobile = $request->mobile; 
            if(isset($request->country_id))
                $dispatcher->country_id = $request->country_id; 
            $dispatcher->save();

            return redirect()->route('admin.dispatcher.index')->with('flash_success', trans('admin.dispatcher_msgs.dispatcher_update'));    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.dispatcher_msgs.dispatcher_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            Dispatcher::find($id)->delete();
            return back()->with('message', trans('admin.dispatcher_msgs.dispatcher_delete'));
        } 
        catch (Exception $e) {
            return back()->with('flash_error', trans('admin.dispatcher_msgs.dispatcher_not_found'));
        }
    }

}
