<?php

namespace App\Http\Controllers;

use Hash;
use App\Cars;
use App\User;
use App\Agents;
use App\models;
use App\Booking;
use App\country;
use App\CarHolder;
use App\carImages;
use App\carPrices;
use Carbon\Carbon;
use App\Exhibition;
use App\membership;
use App\AgentBranches;
use App\ExhibitorBranches;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AgnecyController extends Controller
{
    public function searchAgnecy(Request  $request,$lang){
     // dd($request->all());
        $agent=new agents();
        $type=$request->type;
        if($request->typecar !=null && $request->typecar!=2){
            $agent=$agent->where('car_type',$request->typecar);
        }

        if (getCountry() !=0) $agent=$agent->where('country_id',getCountry());
        $agent=$agent->where('agent_type',$type)->where('status','!=',0)->orderBy('id','desc')->paginate('10');
        $brands=\App\brands::where('status',1)->get();
        $title = 'selling';
        return view('front.all_agency')->with(['brands'=>$brands,'agents'=>$agent,'title'=>$title,'lang'=>$lang,'type'=>$type]);

    }//end searchAgnecy

    public function agency($id,$lang=null){
        $day = date('Y-m-d');
        $agant=Agents::find($id);
        if ($agant==null) return redirect()->back()->with('success','هذا العنصر غير موجود');
        $cars=Cars::with('agents');
        if (getCountry() !=0) $cars=$cars->where('country_id',getCountry());
        $cars=$cars->whereHas('agents', function($q)
        {$q->where('agents.status','!=',0);})->where('agent_id',$id)->where('end_ad_date','>',$day)
            ->paginate('10');
        $lang=$lang;

        return view('front.agency',compact('cars','lang','agant'));
    }

    public function booking(Request  $request){
       // dd($request->all());
        $request->validate([
            'name'=>'required|max:200',
            'from_date'=>'required|date',
            'to_date'=>'required|date|after:from_date',
            'address'=>'required',
            'phone'=>'required|max:20',
        ]);
        $car=Cars::find($request->car_id);
        $owner=$car->agents->owner;
        $book=Booking::create($request->all()+['user_id'=>auth()->user()->id,'owner_id'=>$owner->id]);
        try {
            NotificationEvent::dispatch(["purpose"=>"request_a_rental_car_reservation","params"=>['email'=>$owner->email]]);
        }
        catch (\Exception $e){

        }

        return redirect()->back()->with('success','تم ارسال طلبك بنجاح');
    }//end booking

    public function showOrder($lang=null){

        $items=Booking::where('owner_id',auth()->user()->id)->paginate();
        return view('dashboard.vehicles-booking.index',compact('lang','items'));
    }//end showOrder

    public function deleteOrder($id){
        Booking::find($id)->delete();
       return redirect()->back()->with('success','تم الحذف بنجاح');
    }//deleteOrder

}//end class
