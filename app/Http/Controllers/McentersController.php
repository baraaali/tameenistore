<?php

namespace App\Http\Controllers;

use App\Balance;
use App\country;
use App\Mcenters;
use App\ServiceCategory;
use App\RangeTimeMcenter;
use App\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class McentersController extends Controller
{


     public function __construct()
      {
        $this->middleware('admin');
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->isMethod('post'))
       {
           $search = $request->all()['search'];
           $country_id = $request->all()['country_id'];
           $status = $request->all()['status'];
           $centers  =Mcenters::where('id','>',0);

           if(!is_null($search))
           $centers= $centers->where([['ar_name','like','%'.$search.'%']])->orWhere([['en_name','like','%'.$search.'%']]);
           
           if(!is_null($country_id))
           $centers= $centers->where('country_id',$country_id);

           if(!is_null($status))
           $centers= $centers->where('status','=',$status);

           $centers=$centers->paginate();
           
           return view('dashboard.mcenters.table',compact('centers'));
       }
       $countries = country::where('status',1)->get();
       $centers = Mcenters::paginate(100);
        return view('dashboard.mcenters.index',compact('countries','centers'));
    }


    public function getRequests(Request $request)
    {
        if($request->isMethod('post'))
        {
            $country_id = $request->all()['country_id'];
            $mcenter_id = $request->all()['mcenter_id'];
            $status = $request->all()['status'];
            $mc_requests  = MaintenanceRequest::where('id','>',0);
 

            if(!is_null($country_id))
            $mc_requests= $mc_requests->whereHas('user',function($q) use ($country_id){
                $q->where('country_id',$country_id);
            });
 
            if(!is_null($mcenter_id))
            $mc_requests = $mc_requests->where('mcenter_id','=',$mcenter_id);

            if(!is_null($status))
            $mc_requests= $mc_requests->where('status','=',$status);
 
            $mc_requests=$mc_requests->paginate();
            
            return view('dashboard.mcenters.requests-table',compact('mc_requests'));
        }
       $mc_requests =  MaintenanceRequest::whereHas('mcenter',function($q){
           $q->where('id','>',0);
       })->paginate();
       $countries = country::where('status',1)->get();
       $centers = Mcenters::get();
       return view('dashboard.mcenters.requests',compact('countries','mc_requests','centers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.mcenters.create')->with('countries',\App\country::where('status',1)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'country_id'=>'required',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent = new Mcenters();

        $agent->country_id = $request->country_id;
        $agent->user_id = auth()->user()->id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $agent->image = $imageName;
        }


        $agent->google_map = $request->google_map;
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;

        $agent->special = $request->specific;
        $agent->status = $request->status;

        $agent->phones = $request->phones;

        $agent->save();



            return redirect('dashboard/mcenters/index')->with('success','تم الحفظ');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mcenters  $mcenters
     * @return \Illuminate\Http\Response
     */
    public function edit($mcenters)
    {
        if($mcenters != null)
        {
            $times = RangeTimeMcenter::where('mcenter_id',$mcenters)->get();
            $center = Mcenters::where('id',$mcenters)->first();
            //dd($center->getServiceMemberShips());
            return view('dashboard.mcenters.edit')
            ->with([
                    'center'=> $center,
                    'countries' => \App\country::where('status',1)->get(),
                    'times' => $times,
                    'categories' => ServiceCategory::where('status','1')->get()
            ]);
          
                    
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mcenters  $mcenters
     * @return \Illuminate\Http\Response
     */
    public function show(Mcenters $mcenters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mcenters  $mcenters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $request->validate([
            'country_id'=>'required',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $mcenter =  Mcenters::where('id',$request->id)->first();
        $data = $request->all();
        // update image
        if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $data['image'] = $imageName;
        }
         // update day times
       if($mcenter->id)
       {
           $days =  $request->day;
           if(!is_null($days) && count($days)){
           $times = [];
           foreach ($days as $i => $day) {
             $start_times = $request->start_time;
             $end_times = $request->end_time;
              if(!is_null($start_times[$i]) && !is_null($end_times[$i]) &&  !is_null($day) ){
              $e = ['mcenter_id'=>$mcenter->id,'day' => $day,'start_time'=> $start_times[$i],'end_time'=>$end_times[$i]];
              array_push($times,$e);
              }
           }
           if(count($times))
           {
            RangeTimeMcenter::where('mcenter_id',$mcenter->id)->delete();
            RangeTimeMcenter::insert($times);
           }
           }
       }
        $mcenter->update($data);

        return redirect('dashboard/mcenters/index')->with('success','تم الحفظ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mcenters  $mcenters
     * @return \Illuminate\Http\Response
     */
     public function destroy($Mcenters)
    {
        if($Mcenters != null)
        {
            Mcenters::where('id',$Mcenters)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($Mcenters)
    {
        if($Mcenters != null)
        {
            Mcenters::where('id',$Mcenters)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($Mcenters)
    {
        if($Mcenters != null)
        {
            Mcenters::where('id',$Mcenters)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
    
    public function renewal(Request $request)
    {
        $id = $request->id;
        $mcenter =Mcenters::where('id',$id)->first();
        
        if ($mcenter->renewal_at < date('Y-m-d'))
        $date =  strtotime(date('Y-m-d'). ' + '.$mcenter->serviceMemberShip->months_number.' Month');
		else
        $date =  strtotime($mcenter->renewal_at. ' + '.$mcenter->serviceMemberShip->months_number.' Month');

        $mcenter->renewal_at =  Date('Y-m-d',$date);

        $user_id = auth()->user()->user_id;
        $balance=Balance::where('user_id',$user_id)->first();
        $membership = $mcenter->serviceMemberShip;
        if((floatval($membership->price) == 0) || auth()->user()->guard == 1 ){
            $mcenter->save();
            Session::flash('success', 'تم تجديد الإشتراك بنجاح');
            return back();
        }else
        if(auth()->user()->guard == 0 && $membership->price >= 0)
        { 
            if ((isset($balance) && $balance->balance >= $membership->price)){
                  $mcenter->save();
                  $user_balance=$balance->balance - $membership->price;
                  $balance->update(['balance'=>$user_balance]);
                  transaction($user_id,'out',$membership->price,'mcenters',$id);
                  Session::flash('success', 'تم تجديد الإشتراك بنجاح');
            }else{
                Session::flash('error', 'لا يوجد لديك رصيد كافي');
            }
            return back();
        }
        else{
            $mcenter->save();
            Session::flash('success', 'تم تجديد الإشتراك بنجاح');
            return back();
        }

    }


    public function archive()
    {
        return view('dashboard.mcenters.archive')->with('centers',Mcenters::onlyTrashed()->paginate(1000));
    }

    public function centerChangeStatus(Request $request)
    {
        //\Log::info($request->all());
        // dd($request->status);
        $center = Mcenters::find($request->center_id);
        $center->status = $request->status;
        $center->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.','status'=>$center->status]);
    }//end catChangeStatus




}//end class
