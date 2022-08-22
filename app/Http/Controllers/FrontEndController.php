<?php

namespace App\Http\Controllers;
use Auth;
use Mail;
use App\Cat;
use Session;
use App\Cars;
use App\Like;
use App\User;
use App\items;
use App\Agents;
use App\brands;
use App\models;
use App\SubCat;
use App\country;
use App\Vehicle;
use App\Addition;
use App\Mcenters;
use App\CarHolder;
use App\Categories;
use App\Exhibition;
use App\CompleteDoc;
use App\NewServices;
use App\AgentBranches;
use App\userinsurance;
use App\McenterService;
use App\McenterVehicle;
use App\ServiceCategory;
use App\CompleteDocSubmit;
use App\ExhibitorBranches;
use App\InsuranceDocument;
use App\Insurancetemplate;
use Illuminate\Support\Str;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use App\CompleteDocSubmitAddition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontEndController extends Controller
{
    use GeneralTrait;
    public function home()
    {  
        $conditions = [];
        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
            $country_id = intval( session()->get('selected_value'));
            array_push($conditions,['items.country_id','=',$country_id] );
        }

        $commercial_ads = items::join('departmentmemberships','items.special','=','departmentmemberships.id')
        ->select('items.*','departmentmemberships.type')
        ->where($conditions)
        ->where('status','1')
        ->whereDate('items.end_ad_date', '>', date('Y-m-d'))
        ->orderBy('departmentmemberships.type','desc');
        $commercial_ads_count = $commercial_ads->count();
        $commercial_ads = $commercial_ads->limit(20)->get();

        
        $vehicles = Vehicle::where('status','1')->get();
        $vehicles_sell_count = Cars::where('sell',1)->where('status','1')->count();
        $vehicles_rent_count = Cars::where('sell',0)->where('status','1')->count();
        $services_categories = Cat::where('status','1')->get();
        $estates_services = SubCat::where('status','1')->where('cat_id','11')->get();
        $services_vehicles = ServiceCategory::where('status','1')->paginate();
        $insurances_single =   Insurancetemplate::where('status',1)->get()->pluck('id','logo');
        $insurances_complete =   CompleteDoc::where('status',1)->get()->pluck('id','logo');
        $insurances = $insurances_single->merge($insurances_complete);

        $banners = $this->getBanners(0);

        return view('welcome',compact('commercial_ads','banners','insurances','services_vehicles','estates_services','services_categories','vehicles_sell_count','vehicles_rent_count','commercial_ads_count','vehicles'));
        
    }

    public function setCountry($country_id = null,$lang = null)
    {
        if(isset($country_id)){
            session()->put('selected_value',$country_id);
            return back();
        }
    }

    /* ----------- Commercial Ads   ----------  */

    public function showCommercialAd($id)
    { 
        $ad = items::where('id',$id)->where('status','1')->first();
        if(is_null($ad)) abort(404);
        $related_ads = items::join('departmentmemberships','items.special','=','departmentmemberships.id')
        ->select('items.*','departmentmemberships.type')
        ->where('status','1')
        ->orderBy('departmentmemberships.type','desc')->limit(20)->get();
        // update views
        $ad->update(['visitors'=>intval($ad->visitors) + 1]);

        // ->where('id','!=',$id)
        // ->where('category_id','!=',$ad->category_id)
        return view('front.commercial-ads.view',compact('ad','related_ads'));
    }

    public function allCommercialAds($category_id = null)
    {    
        $conditions = !is_null($category_id)? [['category_id','=',$category_id]]  : [];

        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
            $country_id = intval( session()->get('selected_value'));
            array_push($conditions,['country_id','=',$country_id] );
        }

        $commercial_ads = items::join('departmentmemberships','items.special','=','departmentmemberships.id')
        ->select('items.*','departmentmemberships.type')
        ->where('status','1')
        ->whereDate('items.end_ad_date', '>', date('Y-m-d'))
        ->where($conditions)
        ->orderBy('departmentmemberships.type','desc');
        $categories  = Categories::where('status','1')->get();
        $commercial_ads_count = $commercial_ads->count();
        $commercial_ads = $commercial_ads->paginate();
        $banners = $this->getBanners(7);

      //  dd($commercial_ads->get(4)->membership->type);
        return view('front.commercial-ads.index',compact('commercial_ads','banners','commercial_ads_count','categories'));
    }
     /* ----------- end commercial Ads   ----------  */

     /* ----------- vehicles sell  ----------  */

    public function vehiclesSell($vehicle_id)
    {
       // $cars = Cars::where('sell',1)->where('vehicle_id',$vehicle_id);
       $conditions = [];
       if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
        $country_id = intval( session()->get('selected_value'));
        array_push($conditions,['country_id','=',$country_id] );
    }
      if(!empty($vehicle_id) && $vehicle_id != 'all')
       {
           array_push($conditions,['vehicle_id','=',$vehicle_id] );
       }
       $cars = Cars::join('ads_membership','cars.special','=','ads_membership.id')
       ->select('cars.*','ads_membership.type')
       ->where('sell',1)
       ->whereDate('cars.end_ad_date', '>', date('Y-m-d'))
       ->where($conditions)
       ->orderBy('ads_membership.type','desc');
        $vehicle  = Vehicle::where('id',$vehicle_id)->first();
        $cars_count = $cars->count();
        $cars = $cars->paginate();
        // dd($cars->count());
        $banners = $this->getBanners(1);

         return view('front.vehicles-sell.index',compact('cars','banners','cars_count','vehicle'));
    }
    public function searchvehicles(Request $request)
    {
        $filters = [];
        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
            $country_id = intval( session()->get('selected_value'));
            array_push($filters,['country_id','=',$country_id] );
        }
        //array_push($filters,['sell','=',1]);
        foreach ($request->all() as $filter => $value) {
            if($value  && $filter != 'care_shape_id'  )
                array_push($filters,[$filter,'=',$value]);
        }
        // to do care_shape_id filter !!
        $cars = Cars::where($filters)
        ->whereDate('end_ad_date', '>', date('Y-m-d'))
        ->paginate();
        return view('front.vehicles-sell.items',compact('cars'));
    }

    public function viewVehicleSell($id = null,$lang = null)
    {
        $car = Cars::where('id',$id)
        ->whereDate('end_ad_date', '>', date('Y-m-d'))
        ->first();
        if(!$car) abort(404);
        $car->visitors = $car->visitors + 1;
        $car->save();
        // return view('content.adv')->with(['car'=>$car,'lang'=>$lang]);
        return view('front.vehicles-sell.view')->with(['car'=>$car,'lang'=>$lang]);
    }

    /* -----------  end vehicles sell  ----------  */

    /* -----------  vehicles rent  ----------  */
    public function vehiclesRent($vehicle_id)
    {
      //  $cars = Cars::where('sell',0)->where('vehicle_id',$vehicle_id);
      $conditions = [];
      if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
       $country_id = intval( session()->get('selected_value'));
       array_push($conditions,['country_id','=',$country_id] );
      }
      if(!empty($vehicle_id) && $vehicle_id != 'all')
       {
           array_push($conditions,['vehicle_id','=',$vehicle_id] );
       }

        $cars = Cars::join('ads_membership','cars.special','=','ads_membership.id')
        ->select('cars.*','ads_membership.type')
        ->whereDate('cars.end_ad_date', '>', date('Y-m-d'))
        ->where('sell',0)
        ->whereHas('agents',function($q){
            $q->where('id','>',0);
        })
        ->where($conditions)
        ->orderBy('ads_membership.type','desc');
       
      //  dd($cars->count());
        $vehicle  = Vehicle::where('id',$vehicle_id)->first();
        $cars_count = $cars->count();
        $cars = $cars->paginate();
        $banners = $this->getBanners(2);

        return view('front.vehicles-rent.index',compact('cars','banners','cars_count','vehicle'));
    }
    
    public function viewVehicleRent($id = null,$lang = null)
    {
        $car = Cars::where('id',$id)
        ->whereDate('end_ad_date', '>', date('Y-m-d'))
        ->first();
        $car->visitors = $car->visitors + 1;
        $car->save();
        return view('front.vehicles-rent.view')->with(['car'=>$car,'lang'=>$lang]);
    }

    /* ----------- services ----------  */

    public function services($cat_id = null, $sub_cat = null ,$lang = null)
    {
        $conditions = [];
        if(empty($cat_id)) abort(404);
         if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
         $country_id = intval( session()->get('selected_value'));
         array_push($conditions,['country_id','=',$country_id] );
        }
        

        $services = NewServices::join('service_membership','services_new.type','=','service_membership.id')
        ->select('services_new.*')
        ->whereDate('services_new.end_date', '>', date('Y-m-d'));
        
        if(!empty($cat_id) && $cat_id != 'all')
        $services = $services->where('cat_id',$cat_id);

        if(!empty($sub_cat) && $sub_cat != 'all')
        $services = $services->where('sub_cat',$sub_cat);
        
        $services = $services->where($conditions)
        ->orderBy('service_membership.type','desc');
        $services_count = $services->count();
        $services = $services->paginate();
        $services_categories = Cat::where('status','1')->get();
        $banners = $this->getBanners(5);

        return view('front.services.index',compact('services','banners','services_count','services_categories'));
    }   
 
    
    public function serviceSingle($id = null,$lang = null)
    {
        $conditions = [];
        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
         $country_id = intval( session()->get('selected_value'));
         array_push($conditions,['country_id','=',$country_id] );
        }
        $ad = NewServices::with(['images','users'])
        ->where($conditions)
        ->whereDate('end_date', '>', date('Y-m-d'))
        ->where('id',$id)->first();
        if(!$ad) abort(404);
         // $ad= NewServices::join('service_membership','services_new.type','=','service_membership.id')
        // ->select('services_new.*')
        // ->where('services_new.id',$id)
        // ->where($conditions)->first();
        //  dd($ad);
        $ad->update(['visitor'=> intval($ad->visitor) + 1]);
        return view('front.services.view',compact('ad'));
    }  

    public function searchServices(Request $request)
    {
        //$filters = [];
        $services = NewServices::whereDate('end_date', '>', date('Y-m-d'));
        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
            $country_id = intval( session()->get('selected_value'));
            $services->where('country_id','=',$country_id);
        }
        foreach ($request->all() as $filter => $value) {
            if($value  && $filter != 'search'  )
             $services->where($filter,'=',$value);
        }
        if(!empty($request->search))
        {
            $value = $request->search;
            $services->where('name_ar','like','%'.$value.'%');
            $services->orWhere('name_en','like','%'.$value.'%');
            $services->orWhere('ar_description','like','%'.$value.'%');
            $services->orWhere('en_description','like','%'.$value.'%');
        }
     // return $services->toSql();
        $services = $services->paginate();
        return view('front.services.items',compact('services'));
    }

    /* ---------------- services-vehicles ------------------ */
        
    public function mcenterProfil($id,$lang=null)
    {
        $mcenter = Mcenters::where('status','1')
        ->whereDate('renewal_at', '>', date('Y-m-d'))
        ->where('id',$id)
        ->first();

        if(!$mcenter) abort(404);
        
        $services = McenterService::where('mcenter_id',$mcenter->id)->where('status','1')->get();
        $mcenter->update(['visitors'=>($mcenter->visitors + 1)]);
        $currency = isset($mcenter->country) ? $mcenter->country->getCurrency() : '';
        return view('front.services-vehicles.profil',compact('mcenter','lang','services','currency'));
    }

    public function servicesVehicles(Request $request,$cat_id,$lang = null){
        $conditions = [];
        if(empty($cat_id))  abort(404);

        if($request->isMethod('post'))
        {
            $category = $request->all()['category'];
            $sub_category = $request->all()['sub_category'];
            $child_category = $request->all()['child_category'];
            $country = $request->all()['country'];
            $governorate = $request->all()['governorate'];
            $city = $request->all()['city'];
            $mcenter_vehicle_id = $request->all()['mcenter_vehicle_id'];
            $mcenters  = Mcenters::where('status','1')->whereDate('renewal_at', '>', date('Y-m-d'));
            
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
            return view('front.services-vehicles.mcenters-items',compact('mcenters','lang'));
        }
        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
            $country_id = intval( session()->get('selected_value'));
            array_push($conditions,['country_id','=',$country_id] );
        }
        $countries = country::where('status','1')->get();
        $vehicles = McenterVehicle::where('status','1')->get();
        $categories = ServiceCategory::where('status','1')->get();

        $mcenters = Mcenters::where('mcenters.status','1')
        ->whereDate('renewal_at', '>', date('Y-m-d'))
        
        ->whereHas('owner',function($q) use ($conditions) {
            $q->where($conditions);
        });
        if(!empty($cat_id) && $cat_id != 'all')
        $mcenters = $mcenters->where('mcenters.category',$cat_id);
        
        $mcenters = $mcenters->select('mcenters.*')
        ->join('mcenter_services','mcenter_services.mcenter_id','=','mcenters.id')
        ->join('service_member_ships','service_member_ships.id','=','mcenters.special')
        ->orderBy('service_member_ships.type','desc')
        ->groupBy('mcenters.id');
        $mcenters = $mcenters->paginate();
        $mcenters_count = $mcenters->count();
        $banners = $this->getBanners(6);
        // dd($mcenters->count());
        //  dd($banners);
        return view('front.services-vehicles.mcenters',compact('lang','banners','mcenters_count','countries','categories','mcenters','vehicles'));
     }

   


    public function setLike(Request $request)
    {
        $user_id = auth()->user()->id;
        $like = Like::where('user_id',$user_id)->where('model',$request->model)->where('ad_id',$request->ad_id)->first();
        if(empty($like))
        {  // create new like
            $like = ['model'=>$request->model,'user_id'=>$user_id,'ad_id'=>$request->ad_id,'is_liked'=>1];
            Like::create($like);
            $count = Like::where('model',$request->model)->where('ad_id',$request->ad_id)->where('is_liked',1)->count();
            return response()->json(['heart'=>1,'count'=>$count], 200);
        }else{
            $is_liked = $like->is_liked == 1 ? 0 : 1 ;
            $like->update(['is_liked'=>$is_liked]);
            $count = Like::where('model',$request->model)->where('ad_id',$request->ad_id)->where('is_liked',1)->count();
            return response()->json(['heart'=>$is_liked,'count'=>$count], 200);
        }
    }

// ------------------------------ insurance requests single

 public function insuranceSingle($lang = null)
 {
    $insurance_doc = \App\InsuranceDocument::get();
    $com_insurance = \App\CompleteDoc::get();
    $merge_insurance =$insurance_doc->merge( $com_insurance);
    $insurance_document = \App\InsuranceDocument::where('id',5000000)->get();
    $complete_insurance = \App\CompleteDoc::where('id',5000000)->get();

    $brands = \App\brands::where('status',1)
    ->whereIn('id',array_unique($merge_insurance->pluck('brand_id')->toArray()))
    ->get();
    
    return view('front.insurance.single')
    ->with([
            'banners'=> $this->getBanners(8),
            'countries' => \App\country::get(),'lang'=> $lang,'merge_insurance'=>$merge_insurance,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>$brands,'models'=>\App\models::get(),'type'=>0]);
  }
  
  public function dcFilter(Request $request ,$lang=null)
  {

            $request->validate([
                'type_of_use' =>'required',
                'brand_id' =>'required',
                'model_id' =>'required',
            ]);
            session()->put('type_of_use',$request->type_of_use);
            session()->put('brand_id',$request->brand_id);
            session()->put('model_id',$request->model_id);
            
          $insurance_doc = \App\InsuranceDocument::get();
          $type = $request->type;
          $insurance_document = \App\InsuranceDocument::where([
              'brand_id'=>$request->brand_id,
              'model_id'=>$request->model_id,
              'type_of_use'=>$request->type_of_use,
              'status' => 1])->where('end_date','>=',date('Y-m-d'));

          if (getCountry()>0)  $insurance_document=$insurance_document->where('country_id',getCountry());

          $insurance_document=$insurance_document->get();
          $specific_year = $request->year;
          $now_year = Date('Y');
          return view('front.insurance.single')
              ->with(['insurance_document'=>$insurance_document,
              'banners' =>  $this->getBanners(8) ,
              'carprice'=>$request->carprice,'request_year'=>$specific_year,'now_year'=>$now_year,'countries' => \App\country::get(),'lang'=>$lang,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get(),'type'=>$type]);
  }

  public function userinsurance(Request $request,$lang=null)
  {

      $req = new userinsurance();
      $req->type = $request->type1;
      $req->type_of_use = $request->typeofuse1;
      $req->brand_id = $request->brand1;
      $req->model_id = $request->model1;
      $req->year = $request->year;
      $req->insurance_id = $request->insurance_id;
      $req->price = $request->price;
      $req->inDuration = $request->inDuration;
      $req->companynameen = $request->companynameen;
      $req->companynamear = $request->companynamear;
      $req->start_in = $request->date;
      $files_array = [];
      if($request->file('files')) {
          foreach($request->file('files') as $file){

                   $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                   $file->move(public_path('uploads'), $imageName);

                   array_push($files_array,$imageName);
          }
      }

      $req->files = json_encode($files_array);

      if(Auth::check())
      {
          $req->user_id =auth()->user()->id;
          $req->save();

          $doc = \App\Insurance::where('id',$request->insurance_id)->select('user_id')->first();

          $user = \App\User::where('id',$doc->user_id)->select('email')->first();

          NotificationEvent::dispatch(["purpose"=>"third_party_insurance_claim_for_traders","params"=>['email'=>$user->email]]);

          return view('front.insurance.insurancethanks')->with(['lang'=>$lang,'userinsuranceid'=>$req->id]);
      }
      else{
      //$req->save();
      return redirect()->route('user-login');
    //   return view('front.insurance.userinsurance')->with(['lang'=>$lang,'id'=>$req->id]);
      }

  }
     

     
     
     // ------------------------------ insurance requests complete
 public function insuranceComplete($lang = null)
 {
    $insurance_doc = \App\InsuranceDocument::get();
    $com_insurance = \App\CompleteDoc::get();
            $merge_insurance =$insurance_doc->merge( $com_insurance);

    $insurance_document = \App\InsuranceDocument::where('id',5000000)->get();
    $complete_insurance = \App\CompleteDoc::where('id',5000000)->get();
    $brands = \App\brands::where('status',1)
    ->whereIn('id',array_unique($merge_insurance->pluck('brand_id')->toArray()))
    ->get();

    return view('front.insurance.complete')
    ->with([
        'banners' =>  $this->getBanners(9) ,
        'countries' => \App\country::get(),'lang'=>$lang,
        'merge_insurance'=>$merge_insurance,
        'insurance_document'=>$insurance_document,
        'complete_insurance'=>$complete_insurance,
        'brands'=>$brands,
        'models'=>\App\models::get(),'type'=>0]);
   }

   public function ComFilter(Request $request ,$lang=null)
   {
       $min_year=gmdate("Y",strtotime("+1 year"));

        $request->validate([
            'carprice' =>'required',
            'type_of_use' =>'required',
           'brand_id' =>'required',
            'model_id' =>'required',
        ]);
            session()->put('carprice',$request->carprice);
            session()->put('type_of_use',$request->type_of_use);
            session()->put('brand_id',$request->brand_id);
            session()->put('model_id',$request->model_id);
            session()->put('year',$request->year);

          $insurance_doc = \App\InsuranceDocument::get();
           $com_insurance = \App\CompleteDoc::get();
           $merge_insurance =$insurance_doc->merge( $com_insurance);
           $type = $request->type;
          $insurance_document = \App\InsuranceDocument:: where(['type_of_use'=>$request->type_of_use,'status'=>0])->get();
           $typeOfUse = $request->type_of_use;

           $complete_insurance = \App\CompleteDoc::where([
               'type_of_use' => $typeOfUse,
               'brand_id' => $request->brand_id,
               'model_id' => $request->model_id,
               'status'=>1,
               'search_show'=>1,
           ])->where('max_value','>=',$request->carprice)->where('max_year_search','<=',$request->year)
               ->where('end_date','>=',date('Y-m-d H:i:s'));
           if (getCountry() >0){
               $complete_insurance= $complete_insurance->where('country_id',getCountry());
           }

           $complete_insurance=$complete_insurance->orderBy('OpenFileMinimumFirstSlide',$request->sort)
               ->get();

           foreach($insurance_document as $key=>$indocument){
               $indocument->specific_year= $request->year;
               $indocument->save();
           }
           $specific_year = $request->year;
           $now_year = Date('Y');
          $brands=brands::where('status',1)->get();
          $models=models::get();

           return view('front.insurance.complete')
           ->with(['carprice'=>$request->carprice,
           'banners' =>  $this->getBanners(9) ,
           'models'=>$models,'lang'=>$lang,
                   'request_year'=>$specific_year,'now_year'=>$now_year,'countries' => \App\country::get(),'lang'=>$lang,'merge_insurance'=>$merge_insurance,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>$brands,'type'=>$type]);
   }
   public function submitCompleteDoc(Request $request,$lang=null){

             $request->validate([
                 'start_date' => 'required|date',
                 'file' => 'required|image',
             ]);
             $id=$request->req_id;
             $addion='addition'.$id;
    
            if (isset($request->$addion)) $plus=array_sum($request->$addion);
            else $plus=0;
            $net_price=$request->net_price+$plus;
    
            foreach($request->complete_doc_id as $complete_doc_id){
                if(Auth::check()){
                    $user_id = auth()->user()->id;
                }
                if($request->has('file')){
                    $imageName = time().'.'.request()->file->getClientOriginalExtension();
                    request()->file->move(public_path('uploads'), $imageName);
                }
                $com=CompleteDoc::find($complete_doc_id);
                $first_row=CompleteDoc::where(['user_id'=>$com->user_id,'Insurance_Company_ar'=>$com->Insurance_Company_ar])
                    ->first()->id;
    
                $CompleteDocSubmit = CompleteDocSubmit::create([
                    'complete_doc_id' =>  $complete_doc_id,
                    'price' =>  $request->price,
                    'user_id' => $user_id,
                    'net_price'=>$net_price,
                    'file'=>$imageName,
                    'owner_id'=>$com->user_id,
                    'start_date'=>$request->start_date
                ]);
                $add = 'addition'.$complete_doc_id;
                $additions = $request->$add;
                if($additions){
                     if(count((array) $additions) >= 1){
                            foreach($additions as $addition){
                                $add_id=Addition::where('insurance_document_id',$first_row)->
                                    where('FeatureCost',$addition)->first()->id;
                                CompleteDocSubmitAddition::create([
                                    'complete_doc_submit_id' => $CompleteDocSubmit->id,
                                    'addition_id'=>$add_id
                                ]);
                            }
                        }
                }
    
    
            }
    
            if(Auth::check())
            {
                $doc = \App\CompleteDoc::where('id',$complete_doc_id)->select('user_id')->first();
    
                $user = \App\User::where('id',$doc->user_id)->select('email')->first();
    
                NotificationEvent::dispatch(["purpose"=>"comprehensive_insurance_request_for_merchants","params"=>['email'=>$user->email]]);

                return view('front.insurance.insurancethanks')->with(['lang'=>$lang,'complete_id'=>$CompleteDocSubmit->id]);
            }
            else{
                return redirect()->route('user-login');

               /// return view('content.user_complete_doc')->with(['lang'=>$lang,'complete_id'=>$CompleteDocSubmit->id]);
            }
        }


    // ------------------------------ sales agencies

    public function salesAgencies()
    {
        $conditions = [['status','=',1]];
        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
            $country_id = intval( session()->get('selected_value'));
            array_push($conditions,['country_id','=',$country_id] );
           }
        $agencies = Agents::where($conditions)->where('agent_type','0')->paginate();
        $banners = $this->getBanners(3);

        return view('front.sales-agencies.index',compact('agencies','banners'));
    }  
      public function singleSalesAgencies($id = null)
    {
        $agency =  Agents::where('id',$id)->first();
        if(empty($agency)) abort($id);
        return view('front.sales-agencies.view',compact('agency'));
    }  
    
    // ------------------------------ rental agencies

    public function rentalAgencies()
    {
        $conditions = [['status','=',1]];
        if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
            $country_id = intval( session()->get('selected_value'));
            array_push($conditions,['country_id','=',$country_id] );
           }
        $agencies = Agents::where($conditions)->where('agent_type','1')->paginate();
        $banners = $this->getBanners(4);
        return view('front.rental-agencies.index',compact('agencies','banners'));
    }  
      public function singleRentalAgencies($id = null)
    {
        $agency =  Agents::where('id',$id)->first();
        if(empty($agency)) abort($id);
        return view('front.rental-agencies.view',compact('agency'));
    } 
    
    public function getStaticPage($page)
    {
        return view('front.static.'.$page);
    }

    public function searchByKeyWord(Request $request){
        $searchValue = $request->searchValue;
       // $searchValue = "سي";
        /*
        items |  ar_desciption * en_description
        cars | en_description* ar_description
        mcenters | ar_description * en_description
        services | ar_description * en_description
        */
        $itemsResults = DB::table('items')
        ->where([['ar_desciption','like','%'.$searchValue.'%'],['status','=',1]])
        ->orWhere([['en_description','like','%'.$searchValue.'%']])
        ->orWhere([['ar_name','like','%'.$searchValue.'%']])
        ->orWhere([['en_name','like','%'.$searchValue.'%']])
        ->get()->toArray();
        foreach ($itemsResults as $e) {
            $e->_target = 'items';
        }

        $carsResults = DB::table('cars')
        ->where([['ar_description','like','%'.$searchValue.'%'],['status','=',1]])
        ->orWhere([['en_description','like','%'.$searchValue.'%']])
        ->orWhere([['ar_name','like','%'.$searchValue.'%']])
        ->orWhere([['en_name','like','%'.$searchValue.'%']])
        ->get()->toArray();
        foreach ($carsResults as $e) {
            $e->_target = 'cars';
        }

        $mcentersResults = DB::table('mcenters')
        ->where([['ar_description','like','%'.$searchValue.'%'],['status','=',1]])
        ->orWhere([['en_description','like','%'.$searchValue.'%']])
        ->orWhere([['ar_name','like','%'.$searchValue.'%']])
        ->orWhere([['en_name','like','%'.$searchValue.'%']])
        ->get()->toArray();
        foreach ($mcentersResults as $e) {
            $e->_target = 'mcenters';
        }

        $servicesResults = DB::table('services')
        ->where([['ar_description','like','%'.$searchValue.'%'],['status','=',1]])
        ->orWhere([['en_description','like','%'.$searchValue.'%']])
        ->orWhere([['ar_name','like','%'.$searchValue.'%']])
        ->orWhere([['en_name','like','%'.$searchValue.'%']])
        ->get()->toArray();
        foreach ($servicesResults as $e) {
            $e->_target = 'services';
        }

        $data = array_merge($itemsResults,$carsResults,$mcentersResults,$servicesResults);
        return  response()->json($data, 200);
    }

    }



?>
