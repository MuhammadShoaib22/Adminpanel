<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller; 
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Subscriptions;
use App\SubscriptionHistories;
use DB;
use Exception;
use Setting;
use Storage;
class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscriptions::all();
        return view('admin.subscription.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscription.create');
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
            'name' => 'required|max:100|unique:subscriptions',
            'description' => 'required', 
            'image' => 'required', 
            'amount' => 'required', 
            'provider_commission' => 'required',
            'no_of_days' => 'required|numeric', 
        ]);

        try{
 
            $insert =array( 
                'name' => $request->name,
                'description' => $request->description,
                'image' => Storage::putFile('admin/subscription', $request->image, 'public'),
                'amount' => $request->amount,
                'no_of_days' => $request->no_of_days, 
                'rides_per_period' => $request->rides_per_period,
                'provider_commission' => $request->provider_commission,
              /*  'order_fee_booking' => $request->order_fee_booking, 
                'order_fee_dispatch' => $request->order_fee_dispatch,
                'transaction_fee_cash' => $request->transaction_fee_cash,
                'transaction_fee_terminal' => $request->transaction_fee_terminal,
                'transaction_fee_third_party' => $request->transaction_fee_third_party,
                'transaction_fee_bank_card' => $request->transaction_fee_bank_card,*/
                );  

            Subscriptions::create($insert);
            return back()->with('flash_success','Subscription Saved Successfully');

        } 

        catch (ModelNotFoundException $e) {
            \Log::info($e);
            return back()->with('flash_error', 'Subscription Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $promocode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Subscriptions::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $subscription = Subscriptions::findOrFail($id);
            return view('admin.subscription.edit',compact('subscription'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'required',  
            'amount' => 'required', 
            'no_of_days' => 'required|numeric', 
            'provider_commission' => 'required',
        ]);

        try {

            $subscription = Subscriptions::findOrFail($id);

            $subscription->name = $request->name;
            $subscription->description = $request->description;
            $subscription->provider_commission = $request->provider_commission;

            if($request->image)
                $subscription->image = Storage::putFile('admin/subscription', $request->image, 'public');

            $subscription->amount = $request->amount;
            $subscription->no_of_days = $request->no_of_days;
            $subscription->rides_per_period = $request->rides_per_period;
            /*$subscription->order_fee_booking = $request->order_fee_booking;
            $subscription->order_fee_dispatch = $request->order_fee_dispatch;
            $subscription->transaction_fee_cash = $request->transaction_fee_cash;
            $subscription->transaction_fee_terminal = $request->transaction_fee_terminal;
            $subscription->transaction_fee_third_party = $request->transaction_fee_third_party;
            $subscription->transaction_fee_bank_card = $request->transaction_fee_bank_card;*/
            $subscription->save();

            return redirect()->route('admin.subscription.index')->with('flash_success', 'Subscription Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Subscription Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Subscriptions::find($id)->delete();
            return back()->with('message', 'Subscription deleted successfully');
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Subscription Not Found');
        }
    }

    /**
     * Histories
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function subscription_histories(Request $request)
    {
        try {
            if(isset($request->id))
                $histories = SubscriptionHistories::with('provider')->whereprovider_id($request->id)->get();
            else
                $histories = SubscriptionHistories::with('provider')->get(); 

            return view('admin.subscription.histories',compact('histories'));
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Subscription Not Found');
        }
    }
}
