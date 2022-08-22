<?php

namespace App\Http\Controllers;

use App\McenterRate;
use App\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{



    public function rate(Request $request)
    {
        $rating = $request->all();
        $rating['user_id'] = auth()->user()->id;
        $request_id = $rating['maintenance_request_id'];
        $order = MaintenanceRequest::where('id',$request_id
        )->where('user_id',auth()->user()->id)->first();
        $status = ['rejected','canceled','finished'];
        if(!empty($order) && in_array($order->status,$status))
        {
            McenterRate::where('maintenance_request_id',$request_id
            )->where('user_id',auth()->user()->id)->delete();
            McenterRate::create($rating);
            return back()->with(['success','تم التقيم بنجاح  ']);

        }
        return back()->with('error', 'لا تملك صلاحية');

    }


        public function getRating(Request $request)
    {
        $request_id = $request->maintenance_request_id;
        $order = MaintenanceRequest::where('id',$request_id
        )->where('user_id',auth()->user()->id)->first();
        $ratingResults = $order['quality'] + $order['delivery_time'] + $order['delay_again'];
        $ratingResults /= 3 ;
        return response()->json(compact('ratingResults'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceRequest $maintenanceRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        //
    }
}
