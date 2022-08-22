<?php

namespace App\Http\Controllers;

use Session;
use App\Cars;
use App\Agents;
use App\Notify;
use App\country;
use App\Mcenters;
use App\Exhibition;
use App\McenterService;
use App\McenterVehicle;
use App\ServiceCategory;
use App\RangeTimeMcenter;
use App\UserNotification;
use App\MaintenanceRequest;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function index($lang = null){
//
//        $day = date('Y-m-d');
//        $cars = Cars::where(['status'=>1])->where('end_ad_date','>',$day);
//        if (getCountry() !=0) $cars=$cars->where('country_id',getCountry());
//        $cars=$cars->whereHas('agents', function($q)
//        {$q->where(['agents.agent_type'=>2,'status'=>1]);})->orderBy('id','desc')->paginate(18);

        $day = date('Y-m-d');
        $cars=Cars::join('ads_membership', 'cars.special', '=', 'ads_membership.id')
            ->join('agents', 'cars.agent_id', '=', 'agents.id')
            ->where(['cars.status'=>1])
            ->where(['agents.agent_type'=>2,'agents.status'=>1])
            ->where('cars.end_ad_date','>',$day)
            ->orderBy('ads_membership.type', 'desc')
            ->select('cars.*');
        if (getCountry() !=0) $cars=$cars->where('cars.country_id',getCountry());
       $cars=$cars->paginate(12);

		return view('content.advertisment')->with(['lang'=>$lang,'cars'=>$cars,'shapes'=>$this->getCareShapes()]);
    }//end index

    public function searchAds($lang=null,Request  $request){
        $day = date('Y-m-d');
//        $cars = Cars::where(['status'=>1])->where('end_ad_date','>',$day);
//        if (getCountry() !=0) $cars=$cars->where('country_id',getCountry());
//        $cars=$cars->whereHas('agents', function($q)
//        {$q->where(['agents.agent_type'=>2,'status'=>1]);})->orderBy('id','desc');

        $cars=Cars::join('ads_membership', 'cars.special', '=', 'ads_membership.id')
            ->join('agents', 'cars.agent_id', '=', 'agents.id')
            ->where(['cars.status'=>1])
            ->where(['agents.agent_type'=>2,'agents.status'=>1])
            ->where('cars.end_ad_date','>',$day)
            ->orderBy('ads_membership.type', 'desc');


        if ($request->agent_id && $request->agent_id>0) $cars=$cars->where('agents.agent_id',$request->agent_id);
        if ($request->brand_id){
            $cars=$cars->where('cars.ar_brand',$request->brand_id);
        }
        if ($request->model_id){
            $cars=$cars->where('cars.en_model',$request->model_id);
        }
        if ($request->year){
            $cars=$cars->where('cars.year',$request->year);
        } 
        if ($request->talap){
            $cars=$cars->where('cars.talap',$request->talap);
        } 
        if ($request->vehicle_id){
            $vehicle_id = $request->vehicle_id;
            $cars=$cars->whereHas('vehicle',function($q) use ($vehicle_id){
                $q->where('vehicle_id',$vehicle_id);
            });
        } 
         if ($request->care_shape_id){
            $care_shape_id = $request->care_shape_id;
            $cars=$cars->whereHas('model',function($q) use ($care_shape_id){
                $q->where('care_shape_id',$care_shape_id);
            });
        }
        if (getCountry() !=0) $cars=$cars->where('cars.country_id',getCountry());
       // $cars=$cars->whereHas('agents', function($q)
       // {$q->where('agents.agent_type','!=',2)->where('status',1);})->where('status',1)->paginate('18');
         $cars=$cars->select('cars.*')->paginate(12);
         $shapes   = $this->getCareShapes();
        return view('content.advertisment',compact('cars','lang','shapes'));
    }//end searchCar

   public function getCareShapes()
   {
    $ar=\App\CareShape::where('status','1')->get()->pluck('ar_name','id');
    $en=\App\CareShape::where('status','1')->get()->pluck('en_name','id');
     $data = [];
     foreach ($ar as  $id => $name) {
         $e['id'] = $id;
         $e['name'] = $name .' - '. $en[$id];
         array_push($data,$e);
        }
     return $data;
   }
    public function viewad($id = null,$lang = null)
    {
        $car = Cars::where('id',$id)->first();
        $car->visitors = $car->visitors + 1;
        $car->save();
        return view('content.adv')->with(['car'=>$car,'lang'=>$lang]);
    }

     public function sales($lang = null){
         //         with(['memberships' => function ($query) use ($sortDirection) {
//             $query->orderBy('type', $sortDirection);
//         }])->
//         $cars = Cars::where(['status'=>1,'rent_type'=>'0']);
//        if (getCountry() !=0) $cars=$cars->where('country_id',getCountry());
//         $cars = $cars->whereHas('agents', function($q)
//         {$q->where(['agents.agent_type'=>0,'status'=>1]);});
//         $cars=$cars->with(['memberships' => function ($query) {
//             $query->orderBy('type', 'desc');
//         }]);
         $day = date('Y-m-d');
         $cars=Cars::join('ads_membership', 'cars.special', '=', 'ads_membership.id')
             ->join('agents', 'cars.agent_id', '=', 'agents.id')
             ->where(['cars.status'=>1,'cars.rent_type'=>'0'])
             ->where(['agents.agent_type'=>0,'agents.status'=>1])
             ->where('cars.end_ad_date','>',$day)
             ->orderBy('ads_membership.type', 'desc')
         ->select('cars.*');
         if (getCountry() !=0) $cars=$cars->where('cars.country_id',getCountry());
         $cars=$cars->paginate(12);
         $shapes   = $this->getCareShapes();
         return view('content.sale')->with(['lang'=>$lang,'cars'=>$cars,'shapes'=>$shapes]);
        }
        
     public function rent($lang = null){
         
         //        $cars = Cars::where(['status'=>1,'used'=>1])->orderBy('id','desc')->take(4)->get();
         //        $cars2 = Cars::where(['status'=>1,'used'=>2])->orderBy('id','desc')->take(4)->get();
         //		return view('content.rent')->with(['lang'=>$lang,'cars'=>$cars,'cars2'=>$cars]);
         $brands=\App\brands::where('status',1)->get();
         $title='Rent';
         $agents=Agents::where('agent_type',1)->where('status','!=',0);
         if (getCountry() !=0)  $agents=$agents->where('country_id',getCountry());
         $agents=$agents->orderBy('id','desc')->paginate('10');
         $type=1;
         $shapes   = $this->getCareShapes();
         return view('front.all_agency',compact('agents','lang','title','brands','type','shapes'));

     }//end fun

     public function mcenters(Request $request,$lang = null){
        if($request->isMethod('post'))
        {
            $category = $request->all()['category'];
            $sub_category = $request->all()['sub_category'];
            $child_category = $request->all()['child_category'];
            $country = $request->all()['country'];
            $governorate = $request->all()['governorate'];
            $city = $request->all()['city'];
            $mcenter_vehicle_id = $request->all()['mcenter_vehicle_id'];
            $mcenters  = Mcenters::where('status','1');
            if(!is_null($category))
            $mcenters = $mcenters->where('category','=',$category);

            if(!is_null($sub_category))
            $mcenters = $mcenters->where('sub_category','=',$sub_category);
            
            if(!is_null($child_category))
            $mcenters = $mcenters->where('child_category','=',$child_category);
            
            if(!is_null($country))
            $mcenters = $mcenters->whereHas('owner',function($q)use($country){
                $q->where('country_id','=',$country);
            });
            
            if(!is_null($governorate))
            $mcenters = $mcenters->whereHas('owner',function($q)use($governorate){
                $q->where('governorate_id','=',$governorate);
            });
            
            if(!is_null($city))
            $mcenters = $mcenters->whereHas('owner',function($q)use($city){
                $q->where('city_id','=',$city);
            }); 

            if(!is_null($mcenter_vehicle_id))
            $mcenters = $mcenters->whereHas('services',function($q)use($mcenter_vehicle_id){
                $q->whereHas('vehicle',function($w) use($mcenter_vehicle_id) {
                    $w->where('id',$mcenter_vehicle_id);
                });
            });

            $mcenters =   $mcenters->paginate();
            return view('front.mcenters-items',compact('mcenters','lang'));
        }
        $countries = country::where('status','1')->get();
        $vehicles = McenterVehicle::where('status','1')->get();
        $categories = ServiceCategory::where('status','1')->get();
        $mcenters = Mcenters::where('mcenters.status','1')
        ->select('mcenters.*')
        ->join('mcenter_services','mcenter_services.mcenter_id','=','mcenters.id')
        ->join('service_member_ships','service_member_ships.id','=','mcenters.special')
        ->orderBy('service_member_ships.type','desc')
        ->groupBy('mcenters.id')
        ->paginate();
      //  dd($mcenters);
        return view('front.mcenters',compact('lang','countries','categories','mcenters','vehicles'));
     }
    
     public function checkAvailability($mcenter_id,$day,$delivery_day)
     {
         $availability = [];
         $delivery_day = str_replace('-','/',$delivery_day);
         $rangeTimeMcenter = RangeTimeMcenter::where('mcenter_id',$mcenter_id)
         ->where('day',$day)->first();

         if(empty($rangeTimeMcenter))
         $rangeTimeMcenter = RangeTimeMcenter::where('mcenter_id',$mcenter_id)
         ->where('day','all_days')->first();

         if(!empty($rangeTimeMcenter)){
         $start_time = intVal($rangeTimeMcenter->start_time);
         $end_time = intVal($rangeTimeMcenter->end_time);
         $s_time = $start_time;
         $e_time = $start_time  + 1;
          while( $e_time  <=  $end_time )
          {
          $s_period = $s_time < 12 ? "am" : "pm";
          $e_period = $e_time < 12 ? "am" : "pm";
          $s_time_toString = $s_time."_".$s_period."-";
          $e_time_toString = $e_time."_".$e_period;
          if($s_time > 12)   $s_time_toString = ($s_time - 12)."_".$s_period."-";
          if($e_time > 12)   $e_time_toString = ($e_time - 12)."_".$s_period;
          array_push($availability,$s_time_toString.$e_time_toString);
          $s_time++;
          $e_time = $s_time + 1;
         }
         }
         // remove taken times
         $time_requests = MaintenanceRequest::where('mcenter_id',$mcenter_id)
         ->where('delivery_day',$delivery_day)
         ->where('status','!=','finished')
         ->get()->pluck('delivery_time')->toArray();
         if(is_array($time_requests) && count($time_requests))
         return array_values(array_diff($availability,$time_requests));
         return  $availability;
         

     }
    public function getMcenter($id,$lang = null){
        $mcenter = Mcenters::where('status','1')->where('id',$id)->first();
        $services = McenterService::where('mcenter_id',$mcenter->id)->where('status','1')->get();
        $mcenter->update(['visitors'=>($mcenter->visitors + 1)]);
        $currency = $mcenter->country->getCurrency();
        return view('front.mcenter-profil',compact('mcenter','lang','services','currency'));
    }
    
    public function saveMaintenanceRequest(Request $request){
        $request->validate([
            'services' => 'required|array',
            'delivery_to' => 'required ',
            'delivery_day' => 'required ',
            'price' => 'required ',
            'mcenter_id' => 'required ',
            'delivery_time' => 'required',
        ]);
        $data = $request->all();

        if(is_null(auth()->user()))
        {
            session()->put('save-request-mcenter',$data);
            return redirect('user/login');
        }else
        {
        $data['user_id'] = auth()->user()->id;
        $data['services'] = implode('-',$data['services']);
        $data['additional_services'] = isset( $data['additional_services']) ? implode('-',$data['additional_services']) : null;
        MaintenanceRequest::create($data);
        session()->flash('success','تم إرسال الطلب نجاح');
        return redirect('/cp/mcenter-requests');
        }
        
    }


    public function userNotify(Request  $request,$type=0){
      $row=new Notify();
      $row->ads_id=$request->ads_id;
      $row->status=1;
      $row->type=$type;
      $row->save();

      return redirect()->back()->with('success','تم تبليغ الادارة');
    }//end userNotify

    public function searchCar($lang=null,Request  $request){
        $cars=new Cars();
       // dd($request->all());
        if ($request->car_type!=2) {
            $type=$request->car_type;
            $cars=$cars->where('used',$type);
        }
       // dd($cars->where('rent_type','0')->where('status',1)->get());
        if (getCountry() !=0) $cars=$cars->where('country_id',getCountry());

        if ($request->agent_id && $request->agent_id>0) $cars=$cars->where('agent_id',$request->agent_id);

        if ($request->brand_id){
            $cars=$cars->where('ar_brand',$request->brand_id);
        }
        if ($request->model_id){
            $cars=$cars->where('en_model',$request->model_id);
        }
        if ($request->year){
            $cars=$cars->where('year',$request->year);
        }
        if ($request->talap){
            $cars=$cars->where('cars.talap',$request->talap);
        } 
        if ($request->vehicle_id){
            $vehicle_id = $request->vehicle_id;
            $cars=$cars->whereHas('vehicle',function($q) use ($vehicle_id){
                $q->where('vehicle_id',$vehicle_id);
            });
        } 
         if ($request->care_shape_id){
            $care_shape_id = $request->care_shape_id;
            $cars=$cars->whereHas('model',function($q) use ($care_shape_id){
                $q->where('care_shape_id',$care_shape_id);
            });
        }
      //  dd($request->all());
        $cars=$cars->whereHas('agents', function($q) {
            $q->where('agents.status',1);   })
            ->where('status',1)->where('rent_type','0')->paginate('12');
          $shapes   = $this->getCareShapes();
         return view('content.sale',compact('cars','lang','shapes'));
    }//end searchCar

    public function searchCarRent($lang=null,Request  $request){

        $cars=Cars::where(['status'=>1]);
        if ($request->has('car_type')){
           $cars=$cars->where('rent_type',$request->car_type);
        }
        if ($request->has('agent_id') && $request->agent_id !=0){
         //dd($request->agent_id);
            $cars=$cars->where('agent_id',$request->agent_id);
        }
        $cars=$cars->whereIn('rent_type',['1','2','3','4']);
        if (getCountry() !=0) $cars=$cars->where('country_id',getCountry());
        if ($request->brand_id){
            $cars=$cars->where('ar_brand',$request->brand_id);
        }
        if ($request->model_id){
            $cars=$cars->where('en_model',$request->model_id);
        }
        if ($request->year){
            $cars=$cars->where('year',$request->year);
        }
        if ($request->talap){
            $cars=$cars->where('cars.talap',$request->talap);
        } 
        if ($request->vehicle_id){
            $vehicle_id = $request->vehicle_id;
            $cars=$cars->whereHas('vehicle',function($q) use ($vehicle_id){
                $q->where('vehicle_id',$vehicle_id);
            });
        } 
         if ($request->care_shape_id){
            $care_shape_id = $request->care_shape_id;
            $cars=$cars->whereHas('model',function($q) use ($care_shape_id){
                $q->where('care_shape_id',$care_shape_id);
            });
        }
        $cars=$cars->whereHas('agents', function($q)
        {$q->where('agents.status',1);})->paginate('6');
        $shapes   = $this->getCareShapes();

        return view('content.agent',compact('cars','lang','shapes'));
    }
    //end searchCar

    public function leasingAgent(Request $request)
    {
    $title='leasing';
    $lang = $request->lang;
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
//    $cars = Cars::where(['status'=>1]);
//    if (getCountry() !=0) $cars=$cars->where('country_id',getCountry());
//    $cars=$cars->whereHas('agents', function($q)
//    {$q->where(['agents.agent_type'=>1,'status'=>1]);})
//        ->orderBy('id','desc')->paginate(6);
    //dd($cars);
    $day = date('Y-m-d');
    $cars=Cars::join('ads_membership', 'cars.special', '=', 'ads_membership.id')
        ->join('agents', 'cars.agent_id', '=', 'agents.id')
        ->where(['cars.status'=>1])
        ->where(['agents.agent_type'=>1,'agents.status'=>1])
        ->whereDate('cars.end_ad_date','>',$day)
        ->orderBy('ads_membership.type', 'desc')
        ->select('cars.*');
    if (getCountry() !=0) $cars=$cars->where('cars.country_id',getCountry());
    $cars=$cars->paginate(12);

    $lang=App::getLocale();
    $shapes   = $this->getCareShapes();

    //return view('content.agent')->with(['agents'=>\App\Agents::where('agent_type',1)->orderBy('id','desc')->paginate(5),'title'=>$title]);
    return view('content.agent')->with(['cars'=>$cars,'title'=>$title,'lang'=>$lang,'shapes'=>$shapes]);
    }

}//end class

