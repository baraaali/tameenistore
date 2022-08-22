<?php

namespace App\Http\Controllers;

use App\brands;
use App\CompleteDocSubmit;
use App\Exhibition;
use App\Agents;
use App\carImages;
use App\Cars;
use App\CarHolder;
use App\carPrices;
use App\country;
use App\AgentBranches;
use App\ExhibitorBranches;
use App\Style;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\membership;
use App\User;
use App\Insurance;
use App\InsuranceDocument;
use App\CompleteDoc;
use App\models;
use App\Condition;
use App\ConditionItem;
use App\Addition;
use App\InsuranceDocumentBrand;
use Hash;

class ControlPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function index($lang=null)
    {
            $agent = \App\Agents::where('user_id',auth()->user()->id)->first();
            $agent_branch = \App\AgentBranches::where('agent_id',auth()->user()->id)->get();
            $exhibitor = \App\Exhibition::where('user_id',auth()->user()->id)->first();
            $Exhibition_branch = \App\ExhibitorBranches::where('exhibitor_id',auth()->user()->id)->get();
            return view('Cdashboard.index3')
            ->with(['lang'=>$lang,'agent_branch'=>$agent_branch,'Exhibition_branch'=>$Exhibition_branch]);
    }
    public function controlPanel ($lang = null)
    {
         if(auth()->user()->ended_at != null)
         {
             $today = Carbon::now();
             $endDate = Carbon::parse(auth()->user()->ended_at);

             if($today >= $endDate)
            {
             return view('Cdashboard.expired')->with(['lang'=>$lang]);
             }
             else
             {
                 return view('Cdashboard.index')->with(['lang'=>$lang]);
             }
         }
         else
         {
             $memberships = membership::orderBy('cost','asc')->get();
             return view('Cdashboard.membership')->with(['lang'=>$lang,'memberships'=>$memberships]);
         }
    }


    public function index2($lang=null)
    {
            $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
            $insurance_document = \App\InsuranceDocument::where('user_id',auth()->user()->id)->get();
            $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
            $merge_insurance =$insurance_document->merge( $complete_insurance);

            return view('Cdashboard.insurance')
            ->with(['lang'=>$lang,'merge_insurance'=>$merge_insurance ,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }
     public function index3($lang=null)
    {
            $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
            $insurance_document = \App\InsuranceDocument::where('user_id',auth()->user()->id)->get();
            $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
            $merge_insurance =$insurance_document->merge( $complete_insurance);

            return view('Cdashboard.Completeinsurance')
            ->with(['lang'=>$lang,'merge_insurance'=>$merge_insurance ,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }

    public function joinMembership($id,$lang=null){
        $selectMembership = membership::where('id',$id)->first();

        $user = User::where('id',auth()->user()->id)->first();

        if($selectMembership){
            $user->membership_id = $selectMembership->id;
            $user->started_at = Date('Y-m-d h:i:s');
            $user->ended_at = date('Y-m-d h:i:s', strtotime(Date('Y-m-d h:i:s'). ' + '.$selectMembership->duration.' days'));
            $user->save();
        }

       return redirect('/cp/index/'.$lang);

    }


    public function adsView($lang = null){

        return view('Cdashboard.index2')->with('labg',$lang);
    }
    public function AdRenew(Request $request , $lang=null){
        $selectMembership = membership::where('id',$request->membership)->first();

        $user = User::where('id',auth()->user()->id)->first();

        if($selectMembership){
            $user->membership_id = $selectMembership->id;
            $user->started_at = Date('Y-m-d h:i:s');
            $user->ended_at = date('Y-m-d h:i:s', strtotime(Date('Y-m-d h:i:s'). ' + '.$selectMembership->duration.' days'));
            $user->save();
        }
        $ads= \App\Cars::where('id' , $request->id)->fisrt();
        $ads->end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + '.$selectMembership->duration.' days'));
        $ads->save();
        return response(['message' => 'success'] , 200);
    }

    public function incInsuranceRenew(){
       $selectMembership = membership::where('id',$request->membership)->first();

        $user = User::where('id',auth()->user()->id)->first();

        if($selectMembership){
            $user->membership_id = $selectMembership->id;
            $user->started_at = Date('Y-m-d h:i:s');
            $user->ended_at = date('Y-m-d h:i:s', strtotime(Date('Y-m-d h:i:s'). ' + '.$selectMembership->duration.' days'));
            $user->save();
        }
        $ins= \App\InsuranceDocument::where('id' , $request->id)->fisrt();
        $ins->end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + '.$selectMembership->duration.' days'));
        $ins->save();
        return response(['message' => 'success'] , 200);
    }

      public function CompInsuranceRenew(){
       $selectMembership = membership::where('id',$request->membership)->first();

        $user = User::where('id',auth()->user()->id)->first();

        if($selectMembership){
            $user->membership_id = $selectMembership->id;
            $user->started_at = Date('Y-m-d h:i:s');
            $user->ended_at = date('Y-m-d h:i:s', strtotime(Date('Y-m-d h:i:s'). ' + '.$selectMembership->duration.' days'));
            $user->save();
        }
        $ins= \App\CompleteDoc::where('id' , $request->id)->fisrt();
        $ins->end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + '.$selectMembership->duration.' days'));
        $ins->save();
        return response(['message' => 'success'] , 200);
    }
    public function getModels($id){
        return models::where('brand_id',$id)->get();
    }
    public function updateMyInfo (Request $request){
//        dd($request->all());
        $user = Auth::user();
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                //'password' => ['required', 'string', 'min:8'],
            ]);
          //  $user = User::where('id',auth()->user()->id)->first();
             $user->name = $request->name;
             $user->email = $request->email;
             $user->phones = $request->phone;
            if($request->img){
                $file =  $request->file('img');
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $imageName);
                $user->image = $imageName;
            }
            //dd($request->password);
            if ($request->password) $user->password= Hash::make($request->password);
            $user->save();

            return back()->with(['message'=>'تم التعديل بنجاح']);
//            if(Hash::check($request->password,$user->password)){
//                 if($request->ar_name){
//                     $user->name = $request->ar_name;
//                 }
//                 if($request->phone){
//                     $user->phones = $request->phone;
//                 }
//                if($request->email){
//                    $user->email = $request->email;
//                }
//                 if($request->img){
//                     $file =  $request->file('img');
//                     $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
//                     $file->move(public_path('uploads'), $imageName);
//                     $user->image = $imageName;
//                }
//
//                    $user->update();
//
//                    return back()->with(['message'=>'Ok..']);
//            }
//            else{
//               return back()->with(['message'=>'Password is incorrect']);
//            }
    }

    public function updateMyAgnecyInfo(Request $request){
//dd($request->all());
        $Agency = Agents::find($request->agent_id);
       // dd($Agency);
        $Agency->fill($request->except(['image','_token','agent_id']));
        if($request->image){
            $file =  $request->file('image');
            $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);
            $Agency->image = $imageName;
        }
        $Agency->save();

        return redirect()->back()->with(['message' => 'Banner updated successfully']);

    }

    public function updateMyExhibitorInfo(Request $request){
//dd($request->all());
        $Agency = Exhibition::where('id',$request->agent_id)->first();

        if($request->country_id){
            $Agency->country_id = $request->country_id;
        }

        if($request->en_name){
            $Agency->en_name  = $request->en_name;
        }


        if($request->ar_name){
            $Agency->ar_name  = $request->ar_name;
        }

        if($request->en_description){
            $Agency->en_description  = $request->en_description;
        }

         if($request->ar_description){
            $Agency->ar_description  = $request->ar_description;
        }

        //  if($request->phones){
        //     $Agency->phones  = $request->phones;
        // }


         if($request->fb_page){
            $Agency->fb_page  = $request->fb_page;
        }


         if($request->instagram){
            $Agency->instagram  = $request->instagram;
        }



         if($request->twitter_page){
            $Agency->twitter_page  = $request->twitter_page;
        }

     if($request->website){
            $Agency->website  = $request->website;
        }



     if($request->email){
            $Agency->email  = $request->email;
        }


     if($request->google_map){
            $Agency->google_map  = $request->google_map;
        }

         if($request->days_on){
            $Agency->days_on  = $request->days_on;
        }


         if($request->times_on){
            $Agency->times_on  = $request->times_on;
        }



         if($request->car_type){
            $Agency->car_type  = $request->car_type;
        }


         if($request->image){
                     $file =  $request->file('image');
                     $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                     $file->move(public_path('uploads'), $imageName);
                     $Agency->image = $imageName;
                }
                     $Agency->save();
         return back()->with(['message'=>'Ok..']);


    }


    public function AddNewAgencyBranch(Request $request){

    }

    public function EditAgencyBranch(Request $request){

    }

    public function SoftDeleteAgencyBranch($id){

    }

    public function ForceDeleteAgencyBranch($id){

    }


    public function MyAds($lang = null)
    {
        $carHolder = CarHolder::where('is_user',auth()->user()->id)->get();

        $cars = Cars::whereIn('id',$carHolder->pluck('car_id'))->get();

        return view('Cdashboard.index2')->with(['ads'=>$cars,'lang'=>$lang,'countries'=>\App\country::where('status',1)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }
     public function CrAds($lang = null)
    {
        $carHolder = CarHolder::where('is_user',auth()->user()->id)->get();


        $cars = Cars::whereIn('id',$carHolder->pluck('car_id'))->get();
        //dd($cars);
        return view('Cdashboard.index2C')->with(['ads'=>$cars,'lang'=>$lang,'countries'=>\App\country::where('status',1)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }
    public function Adedit($Ad ,$lang=null)
    {
        $Ad = Cars::where('id',$Ad)->first();

        if($Ad)
        {
            return view('Cdashboard.index2U')->with(['Ads'=>$Ad,'lang'=>$lang,'countries'=>country::where('parent',0)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
        }
        else{
            return back();
        }


    }
     public function Adstore(Request $request)
    {
        //dd($request->all());
        $user_id=auth()->user()->id;
        $agent_id=Agents::where('user_id',$user_id)->first()->id;
        //dd($agent_id);
        $request->validate([
            'country_id'=>'required|int',
            'ar_brand'=>'required|int',
            'ar_model'=>'required|int',
            'ar_name' => 'required',
            'main_image' => 'required|image|max:7000',
            'en_name' => 'required',
            'ar_description' => 'required',
            'en_description' => 'required',
            'images' => 'min:1',
            'cost' => 'required',
            'year' => 'required',
            // 'type_of_car' => 'required',
            'used' => 'required',
            'en_features' => 'required',
            'ar_features' => 'required',
            'sell' => 'required',
            'talap' => 'required',
        ]);


        $today = Date('Y-m-d');

        if(auth()->user()->membership_id != null) {
            $membership = \App\membership::where('id',auth()->user()->membership_id)->first();

            if(auth()->user()->ended_at > $today) {

                $total_ads_in_membership_duration = \App\Cars::where(['special'=>$membership->special])
                ->where('created_at','>',auth()->user()->started_at)
                ->where('created_at','<',auth()->user()->ended_at)->count();

                if($total_ads_in_membership_duration != $membership->limit_posts && $total_ads_in_membership_duration < $membership->limit_posts ) {
                    if($request->file('main_image')){
                        $imageName = $request->en_name.'.'.request()->main_image->getClientOriginalExtension();
                        request()->main_image->move(public_path('uploads'), $imageName);
                    }
                      $car = new Cars();

                $car->en_name = $request->en_name;
                $car->ar_name = $request->ar_name;
                $car->ar_model = $request->ar_model;
                $car->en_model = $request->ar_model;
                $car->ar_brand = $request->ar_brand;
                $car->main_image = $imageName;
                $car->agent_id =  $agent_id;
                $car->category_id = $request->category_id;
                $car->year = $request->year;
                if($request->country_id !=null ){
                    $car->country_id = $request->country_id;
                }
                elseif($request->goverment!=null)
                {
                  $car->country_id=$request->goverment;
                }
                elseif($request->department!=null)
                {
                  $car->department = $request->department;
                }
                elseif($request->category_id!=null)
                {
                    $car->department = $request->department;
                }
                $car->color = $request->color;
                $car->transmission = $request->transmission;
                $car->fuel = $request->fuel;
                $car->used = $request->used;
                $car->en_description = $request->en_description;
                $car->ar_description = $request->ar_description;
                $car->en_features = $request->en_features;
                $car->ar_features = $request->ar_features;
                $car->max = $request->maxSpeed;
                $car->engine = $request->engine;
                $car->kilo_meters = $request->kilometers;
                $car->special = $request->special;
                $car->status = 1;
                $car->talap = $request->talap;
                $car->sell = $request->sell;
                if (auth()->user()->type==3){
                    $car->rent_type = $request->rent_type;
                }
                $car->end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + '.$membership->duration.' days'));
                $car->save();

                if($request->images)
                {
                    $files = $request->file('images');

                    foreach($files as $file)
                    {

                        $newImage = new carImages();
                        $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();



                    $file->move(public_path('uploads'), $imageName);

                        $newImage->car_id = $car->id;
                        $newImage->image = $imageName;
                        $newImage->save();
                    }
                }

                $holder = new CarHolder();

                $holder->car_id = $car->id;
                $holder->is_user = auth()->user()->id;
                $Agent = Agents::where('user_id',auth()->user()->id)->first();
                $Exhibitor = Exhibition::where('user_id',auth()->user()->id)->first();
                if($Agent){
                    $holder->is_agent = $Agent->id;
                }
                if($Exhibitor){
                    $holder->is_exhibitor = $Exhibitor->id;
                }
                $holder->save();


                $country = country::where('id',$request->country_id)->first();
                $price = new carPrices();

                $price->car_id = $car->id;

                $price->currency = $country->en_currency;

                $price->cost = $request->cost;

                $price->discount_amount = $request->discount_amount;

                $price->discount_percent = $request->discount_percent;

                $price->discount_start_date = $request->discount_start_date;

                $price->discount_end_date = $request->discount_end_date;

                $price->save();

              return redirect()->back()->with('success','تم الحفظ');

                } else {
                  return redirect()->back()->with('success','تم استنفاذ عدد الاعلانات المسموحة');
                }
            } else {
          return redirect()->back()->with('success','للاسف .. اشتركك انتهئ يؤجى التجديد');
            }


        } else {
        return redirect()->back()->with('success','انت غير مشترك فى الوقت الحالى');
        }




    }
     public function Adupdate(Request $request)
    {   //dd($request->all());

        $request->validate([
            'country_id'=>'required|int',
            'ar_brand'=>'required|int',
            'ar_model'=>'required|int',
            'ar_name' => 'required',
            'en_name' => 'required',
            'ar_description' => 'required',
            'en_description' => 'required',
            'cost' => 'required',
            'year' => 'required',
            // 'type_of_car' => 'required',
            'used' => 'required',
            'en_features' => 'required',
            'ar_features' => 'required',
            'sell' => 'required',
            'talap' => 'required',
        ]);

        $car =  Cars::where('id',$request->id)->first();
        if(auth()->user()->type==3){
            $car->rent_type = $request->rent_type;
        }
        $car->en_name = $request->en_name;
        $car->ar_name = $request->ar_name;
        $car->ar_model = $request->ar_model;
        $car->talap =$request->talap ;
        $car->en_model = $request->ar_model;
        $car->ar_brand = $request->ar_brand;
        $car->year = $request->year;
        $car->country_id = $request->country_id;
        $car->color = $request->color;
        $car->transmission = $request->transmission;
        $car->fuel = $request->fuel;
        $car->used = $request->used;
        $car->en_description = $request->en_description;
        $car->ar_description = $request->ar_description;
        $car->en_features = $request->en_features;
        $car->ar_features = $request->ar_features;
        $car->max = $request->maxSpeed;
        $car->engine = $request->engine;
        $car->kilo_meters = $request->kilometers;
        $car->special = $request->special;
        $car->status = 1;

        if($request->file('main_image')){
            $imageName = $request->en_name.'.'.request()->main_image->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
            $car->main_image=$imageName;
        }
        $car->save();
        if($request->images)
        {

            $olds = carImages::where('car_id',$car->id)->get();

            if(count($olds) >= 1)
            {
                foreach ($ols as $key => $old) {
                    $old->delete();
                }
            }

            $files = $request->file('images');

            foreach($files as $file)
            {

                $newImage = new carImages();
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();



            $file->move(public_path('uploads'), $imageName);

                $newImage->car_id = $car->id;
                $newImage->image = $imageName;
                $newImage->save();
            }
        }

        $holder =  CarHolder::where('car_id',$car->id)->first();

        $holder->car_id = $car->id;
        $holder->is_user = auth()->user()->id;

        $Agent = Agents::where('user_id',auth()->user()->id)->first();
        $Exhibitor = Exhibition::where('user_id',auth()->user()->id)->first();
        if($Agent){
            $holder->is_agent = $Agent->id;
        }
        if($Exhibitor){
            $holder->is_exhibitor = $Exhibitor->id;
        }
        $holder->save();

        $oldPrice = carPrices::where('car_id',$car->id)->first();

        if($oldPrice)
        {
            $oldPrice->forceDelete();
        }
        $country = country::where('id',$request->country_id)->first();
        $price = new carPrices();

        $price->car_id = $car->id;

        $price->currency = $country->en_currency;

        $price->cost = $request->cost;

        $price->discount_amount = $request->discount_amount;

        $price->discount_percent = $request->discount_percent;

        $price->discount_start_date = $request->discount_start_date;

        $price->discount_end_date = $request->discount_end_date;

        $price->save();



        return redirect('/cp/ads/ar');
    }
      public function Adforce($country)
    {
        if($country != null)
        {
            Cars::where('id',$country)->forceDelete();
            return redirect('/cp/ads/ar')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }





    public function agBranchStore(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent = new AgentBranches();
        $agent->agent_id = $request->agent_id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $agent->image = $imageName;
        }
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;
        $agent->car_type = $request->car_type;
        $agent->special = 1;
        $agent->status = 1;
        $agent->phones = $request->phones;
        $agent->save();
        return redirect('Cdashboard/branches')->with('success','تم الحفظ');
    }
     public function agBranchUpdate(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent =  AgentBranches::where('id',$request->id)->first();
        $agent->agent_id = auth()->user()->id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $agent->image = $imageName;
        }
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;
        $agent->car_type = $request->car_type;
        $agent->special = 1;
        $agent->status = 1;
        $agent->phones = $request->phones;
        $agent->save();
        return redirect('Cdashboard/branches')->with('success','تم الحفظ');

    }


    public function exBranchStore(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);
        $exhibitor = new ExhibitorBranches();
        $exhibitor->exhibitor_id = $request->exhibitor_id;
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;
         if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $exhibitor->image = $imageName;
        }
        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_type;
        $exhibitor->special = $request->specific;
        $exhibitor->status = $request->status;
        $exhibitor->instagram = $request->instagram;
        $exhibitor->special = 0;
        $exhibitor->status = 1;
        $exhibitor->save();
        return redirect('Cdashboard/branches')->with('success','تم الحفظ');
    }

    public function exBranchUpdate(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $exhibitor = ExhibitorBranches::where('id',$request->id)->first();
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;
         if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $exhibitor->image = $imageName;
        }
        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_type;
        $exhibitor->special = 0;
        $exhibitor->status = 1;
        $exhibitor->instagram = $request->insta_page;

        $exhibitor->save();


        return redirect('Cdashboard/branches')->with('success','تم الحفظ');

    }
     public function agforce($id)
    {
        if($id != null)
        {
            AgentBranches::where('id',$id)->forceDelete();
            return redirect('Cdashboard/branches')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
     public function exforce($id)
    {
        if($id != null)
        {
            ExhibitorBranches::where('id',$id)->forceDelete();
            return redirect('Cdashboard/branches')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
    public function generalDocCreateUpdate_old(Request $request){

        $request->validate([
            'type_of_use' =>'required',
            'Insurance_Company_ar' =>'required',
            'Insurance_Company_en' =>'required',
            'deliveryFee' =>'required',
            'ar_term' =>'required',
            'max_value' =>'required|int',
            'en_term' =>'required',
            'start_disc' =>'required|date',
            'end_disc' =>'required|date',
            'ToleranceratioCheck' =>'required',
            'Tolerance_ratio'  =>'required',
            'ToleranceYearPerecenteage' =>'required' ,
            'ConsumptionRatio'  => 'required',
            'ConsumptionFirstRatio' =>'required',
            'YearPerecenteage' =>'required',
            'ConsumptionYearPerecenteage' =>'required',
            'last_percent'=>'required',
        ]);

        $user=auth()->user()->id;
        $document=CompleteDoc::where('user_id',$user)->first();
        //dd($user);
        $insurance=Insurance::where('user_id',$user)->first();
        if ($request->create=='create'){
            $request->validate([
                'logo'=>'required|image|max:5000|mimes:jpeg,jpg,png'
            ]);
            $model=models::first()->id;
            $brand=brands::first()->id;
        }else{
            $model=$document->model_id;
            $brand=$document->brand_id;
        }
        if($request->file('logo')){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads'), $imageName);
        }
        $year = date("Y");
        $logo = $imageName??$document->logo;
        $end_date = auth()->user()->ended_at;
        $requestData=[
            'type_of_use' =>$request->type_of_use,
            'Insurance_Company_ar' =>$request->Insurance_Company_ar,
            'Insurance_Company_en' =>$request->Insurance_Company_en,
            'deliveryFee' =>$request->deliveryFee,
            'ar_term' =>$request->ar_term,
            'en_term' =>$request->en_term,
            'start_disc' =>$request->start_disc,
            'end_disc' =>$request->end_disc,
            'max_value' =>$request->max_value,
            'price'=>0,
            'insurance_id'=>$insurance->id,
            'logo'=>$logo,
            'year'=>$year,
            'user_id'=>$user,
            'end_date'=>$end_date,
            'model_id'=>$model,
            'brand_id'=>$brand,
        ];
        if($document !=null)  {
            $document->update($requestData);
            $row=$document;
        }
        else{
            $row = CompleteDoc::updateOrCreate($requestData);
        }
        $arrCon=[
            'ToleranceratioCheck' =>  $request->ToleranceratioCheck,
            'Tolerance_ratio'  =>  $request->Tolerance_ratio,
            'ToleranceYearPerecenteage' =>  $request->ToleranceYearPerecenteage ,
            'ConsumptionRatio'  =>  $request->ConsumptionRatio,
            'ConsumptionFirstRatio' =>  $request->ConsumptionFirstRatio,
            'YearPerecenteage' =>  $request->YearPerecenteage,
            'ConsumptionYearPerecenteage' =>  $request->ConsumptionYearPerecenteage,
            'last_percent'=>$request->last_percent,
            'insurance_document_id' =>  $row->id
        ];
        $con=Condition::where('insurance_document_id',$row->id)->first();
        if ($con !=null){
            $con->update($arrCon);
            $rowCon=$con;
        }else{
            $rowCon = Condition::create($arrCon);
        }
       $deleted=ConditionItem::where('condition_id',$rowCon->id)->delete();
        foreach($request->AddonNameAR as $keyConditionItem => $AddonNameAR){
            $ConditionItem = ConditionItem::create(
                [
                    'AddonNameAR' => $AddonNameAR,
                    'AddonNameEn'  => $request->AddonNameEn[$keyConditionItem],
                    'AddonMaxYear'  => $request->AddonMaxYear[$keyConditionItem],
                    'AddonUnkownMaxmum'  => $request->AddonUnkownMaxmum[$keyConditionItem],
                    'condition_id' => $rowCon->id
                ]
            );
        }
        $addition=Addition::where('insurance_document_id',$row->id)->delete();
        foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
            $Addition = Addition::create(
                [
                    'FeatureNameAr' => $FeatureNameAr,
                    'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                    'FeatureCost' => $request->FeatureCost[$keyAddition],
                    'FeatureNotices' => $request->FeatureNotices[$keyAddition],
                    'insurance_document_id' =>  $row->id
                ]
            );
        }
        return redirect()->back()->with('success','تم الحفظ');

    }//end generalDocCreateUpdate
    public function saveCompleteData(Request $request){
//dd($request->start_disc);
        $request->validate([
            'type_of_use' =>'required',
            'Insurance_Company_ar' =>'required',
            'Insurance_Company_en' =>'required',
            'deliveryFee' =>'required',
            'precent' =>'required',
            'ar_term' =>'required',
            'en_term' =>'required',
            'max_value' =>'required',
            'max_year' =>'required',
            'start_disc' =>'required|date',
            'end_disc' =>'required|date',
            'ToleranceratioCheck' =>'required',
            'Tolerance_ratio'  =>'required',
            'ToleranceYearPerecenteage' =>'required' ,
            'ConsumptionRatio'  => 'required',
            'ConsumptionFirstRatio' =>'required',
            'YearPerecenteage' =>'required',
            'ConsumptionYearPerecenteage' =>'required',
            'last_percent'=>'required',
            'last_percent_en'=>'required',
            'logo'=>'required|image|max:5000|mimes:jpeg,jpg,png'
        ]);

        $user=auth()->user()->id;
        $document=CompleteDoc::where('user_id',$user)->first();
        //dd($user);
        $insurance=Insurance::where('id',$request->insurance_id)->first();
            $model=models::first()->id;
            $brand=brands::first()->id;
        if($request->file('logo')){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads'), $imageName);
        }
        $year = date("Y");
        $logo = $imageName;
        $end_date = auth()->user()->ended_at;
        $mix=$year-$request->max_year;
        $requestData=[
            'type_of_use' =>$request->type_of_use,
            'Insurance_Company_ar' =>$request->Insurance_Company_ar,
            'Insurance_Company_en' =>$request->Insurance_Company_en,
            'deliveryFee' =>$request->deliveryFee,
            'ar_term' =>$request->ar_term,
            'en_term' =>$request->en_term,
            'start_disc' =>$request->start_disc,
            'precent' =>$request->precent,
            'end_disc' =>$request->end_disc,
            'max_value' =>$request->max_value,
            'max_year' =>$request->max_year,
            'max_year_search' =>$mix,
            'price'=>0,
            'insurance_id'=>$insurance->id,
            'logo'=>$logo,
            'year'=>$year,
            'user_id'=>$user,
            'end_date'=>$end_date,
            'model_id'=>$model,
            'brand_id'=>$brand,
        ];

            $row = CompleteDoc::create($requestData);

        $arrCon=[
            'ToleranceratioCheck' =>  $request->ToleranceratioCheck,
            'Tolerance_ratio'  =>  $request->Tolerance_ratio,
            'ToleranceYearPerecenteage' =>  $request->ToleranceYearPerecenteage ,
            'ConsumptionRatio'  =>  $request->ConsumptionRatio,
            'ConsumptionFirstRatio' =>  $request->ConsumptionFirstRatio,
            'YearPerecenteage' =>  $request->YearPerecenteage,
            'ConsumptionYearPerecenteage' =>  $request->ConsumptionYearPerecenteage,
            'last_percent'=>$request->last_percent,
            'last_percent_en'=>$request->last_percent_en,
            'insurance_document_id' =>  $row->id
        ];
            $rowCon = Condition::create($arrCon);

        foreach($request->AddonNameAR as $keyConditionItem => $AddonNameAR){
            $ConditionItem = ConditionItem::create(
                [
                    'AddonNameAR' => $AddonNameAR,
                    'AddonNameEn'  => $request->AddonNameEn[$keyConditionItem],
                    'AddonMaxYear'  => $request->AddonMaxYear[$keyConditionItem],
                    'AddonUnkownMaxmum'  => $request->AddonUnkownMaxmum[$keyConditionItem],
                    'condition_id' => $rowCon->id
                ]
            );
        }
        foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
            $Addition = Addition::create(
                [
                    'FeatureNameAr' => $FeatureNameAr,
                    'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                    'FeatureCost' => $request->FeatureCost[$keyAddition],
                    'FeatureNotices' => $request->FeatureNotices[$keyAddition],
                    'insurance_document_id' =>  $row->id
                ]
            );
        }
        return redirect()->route('all_complete')->with('success','تم الحفظ');

    }//end generalDocCreateUpdate
    public function generalDocCreateUpdate(Request $request){
//dd($request->all());
        $request->validate([
            'type_of_use' =>'required',
            'Insurance_Company_ar' =>'required',
            'Insurance_Company_en' =>'required',
            'precent' =>'required',
            'deliveryFee' =>'required',
            'ar_term' =>'required',
            'en_term' =>'required',
            'max_value' =>'required',
            'start_disc' =>'required|date',
            'end_disc' =>'required|date',
            'ToleranceratioCheck' =>'required',
            'Tolerance_ratio'  =>'required',
            'ToleranceYearPerecenteage' =>'required' ,
            'ConsumptionRatio'  => 'required',
            'ConsumptionFirstRatio' =>'required',
            'YearPerecenteage' =>'required',
            'ConsumptionYearPerecenteage' =>'required',
            'last_percent'=>'required',
            'last_percent_en'=>'required',
            'max_year'=>'required',
            'FeatureNameAr'=>'required|array',
            'FeatureNameEn'=>'required|array',
            'FeatureCost'=>'required|array',
            'FeatureNotices'=>'required|array',
            'AddonNameAR'=>'required|array',
            'AddonNameEn'=>'required|array',
            'AddonMaxYear'=>'required|array',
            'AddonUnkownMaxmum'=>'required|array',
        ]);

        $user=auth()->user()->id;
        $document=CompleteDoc::where('id',$request->id)->first();
       // dd($document);
        $insurance=Insurance::where('id',$request->insurance_id)->first();
            $model=$document->model_id;
            $brand=$document->brand_id;
        if($request->file('logo')){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads'), $imageName);
        }
        $year = date("Y");
        $logo = $imageName??$document->logo;
        $end_date = auth()->user()->ended_at;
        $mix=$year-$request->max_year;
        $requestData=[
            'type_of_use' =>$request->type_of_use,
            'Insurance_Company_ar' =>$request->Insurance_Company_ar,
            'Insurance_Company_en' =>$request->Insurance_Company_en,
            'deliveryFee' =>$request->deliveryFee,
            'ar_term' =>$request->ar_term,
            'en_term' =>$request->en_term,
            'start_disc' =>$request->start_disc,
            'end_disc' =>$request->end_disc,
            'max_value' =>$request->max_value,
            'max_year' =>$request->max_year,
            'price'=>0,
            'precent'=>$request->precent,
            'insurance_id'=>$insurance->id,
            'logo'=>$logo,
            'year'=>$year,
            'max_year_search'=>$mix,
            'user_id'=>$user,
            'end_date'=>$end_date,
//            'model_id'=>$model,
//            'brand_id'=>$brand,
        ];

        ///to do
            $docs=CompleteDoc::where(['Insurance_Company_en'=>$document->Insurance_Company_en,
                'user_id'=>$document->user_id])->get();
           foreach ($docs as $doc){
               $doc->update($requestData);
           }
           // $row = $document->update($requestData);

        $arrCon=[
            'ToleranceratioCheck' =>  $request->ToleranceratioCheck,
            'Tolerance_ratio'  =>  $request->Tolerance_ratio,
            'ToleranceYearPerecenteage' =>  $request->ToleranceYearPerecenteage ,
            'ConsumptionRatio'  =>  $request->ConsumptionRatio,
            'ConsumptionFirstRatio' =>  $request->ConsumptionFirstRatio,
            'YearPerecenteage' =>  $request->YearPerecenteage,
            'ConsumptionYearPerecenteage' =>  $request->ConsumptionYearPerecenteage,
            'last_percent'=>$request->last_percent,
            'last_percent_en'=>$request->last_percent_en,
            'insurance_document_id' =>  $document->id
        ];
        $con=Condition::where('insurance_document_id',$document->id)->first();
        if ($con !=null){
            $con->update($arrCon);
            $rowCon=$con;
        }else{
            $rowCon = Condition::create($arrCon);
        }
       $deleted=ConditionItem::where('condition_id',$rowCon->id)->delete();
        foreach($request->AddonNameAR as $keyConditionItem => $AddonNameAR){
            $ConditionItem = ConditionItem::create(
                [
                    'AddonNameAR' => $AddonNameAR,
                    'AddonNameEn'  => $request->AddonNameEn[$keyConditionItem],
                    'AddonMaxYear'  => $request->AddonMaxYear[$keyConditionItem],
                    'AddonUnkownMaxmum'  => $request->AddonUnkownMaxmum[$keyConditionItem],
                    'condition_id' => $rowCon->id
                ]
            );
        }
        $addition=Addition::where('insurance_document_id',$document->id)->delete();
        foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
            $Addition = Addition::create(
                [
                    'FeatureNameAr' => $FeatureNameAr,
                    'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                    'FeatureCost' => $request->FeatureCost[$keyAddition],
                    'FeatureNotices' => $request->FeatureNotices[$keyAddition],
                    'insurance_document_id' =>  $document->id
                ]
            );
        }
        //return redirect()->back()->with('success','تم الحفظ');
        return redirect()->route('all_complete')->with('success','تم الحفظ');


    }//end generalDocCreateUpdate

    public function docChangeStatus(Request $request)
    {
        $row=CompleteDoc::find($request->company_id);
        $coms = CompleteDoc::where(['user_id'=>$row->user_id,'Insurance_Company_ar'=>$row->Insurance_Company_ar])->get();
        foreach ($coms as $com){
            $com->status = $request->status;
            $com->save();
        }

        return response()->json(['success'=>'Status change successfully.']);
    }


    public function docChangeShowStatus(Request $request)
    {  //dd($request->status);
        $row=CompleteDoc::find($request->company_id);
      //dd($row);
            $row->search_show = $request->status;
            $row->save();
           // dd($row);
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function deleteDoc($id){
      //  $row=$request->row_id;
        $row=CompleteDoc::where('id',$id)->first();
        if ($row){
            $name=$row->Insurance_Company_ar;
            $user_id=auth()->user()->id;
            $coms=CompleteDocSubmit::where('complete_doc_id',$id)->get();
            if (count($coms)>0) CompleteDocSubmit::where('complete_doc_id',$id)->forceDelete();
            CompleteDoc::where(['Insurance_Company_ar'=>$name,'user_id'=>$user_id])->forceDelete();
          $adds=Addition::where('insurance_document_id',$id)->get();
          if (count($adds)>0){
              $adds->delete();
          }
            return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
        }
        return redirect()->back()->with(['success'=>'هذا العنصر غير موجود']);

    }

    public function deleteDocAddon(Request  $request){
        $id=$request->id;
       Addition::where('id',$id)->forceDelete();
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function deletecondition(Request  $request){
        $id=$request->id;
       ConditionItem::where('id',$id)->forceDelete();
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function storeDocBrand(Request  $request){
        //$is_empty = current(array_filter($request->firstSlidePrice));

        $res = null;
        foreach ($request->firstSlidePrice as $key=>$v) {
            if ($v !== null) {
                $res = $key;
                break;
            }
        }

        $request->validate([
            'model_id'=>'required|array|min:1'
        ]);
//
      $doc= $request->nameOfDoc;
        $increment=$res;
        $slides=$this->arr($request,$increment);
        $find=CompleteDoc::find($doc);
        $find->update(['display'=>1]);

        $newDoc=CompleteDoc::where(['id'=>$doc,'model_id'=>$request->model_id[0]])->first();
        //dd($newDoc);
        if ($newDoc !=null){

            $newDoc->update($slides);
        }else{
          //  dd('rr');
            $newRow=CompleteDoc::where(['id'=>$doc])->first();
            $newRow->update($slides+[
                'model_id'=>$request->model_id[0],
                'brand_id'=>$request->brand_id
            ]);
        }

        $compDocument=CompleteDoc::where(['id'=>$doc])->selectionExcpt()->toArray();
        //dd($compDocument);
        for ($i=1;$i<count($request->model_id);$i++){
            $con=['model_id'=>$request->model_id[$i],'brand_id'=>$request->brand_id];
            //$a=CompleteDoc::where(['id'=>$doc,'model_id'=>$request->model_id[$i],'brand_id'=>$request->brand_id])->first();
             $arr=$this->arr($request,$i);
            $createRow=$arr+$compDocument[0]+$con;
             CompleteDoc::create($createRow);
        }
        return redirect()->route('all_complete')->with('success','تم الحفظ');

        //return redirect()->back()->with('success','تم الحفظ');
    }//storeDocBrand

    public function arr($request,$increment){
        $slides=[
            'firstSlidePrice' => $request->firstSlidePrice[$increment],
            'OpenFileFirstSlide' => $request->OpenFileFirstSlide[$increment],
            'OpenFilePerecentFirstSlide' => $request->OpenFilePerecentFirstSlide[$increment],
            'OpenFileMinimumFirstSlide' => $request->OpenFileFirstSlideMin[$increment],
            'SecondSlidePrice' => $request->SecondSlidePrice[$increment],
            'OpenFileSecondSlide' => $request->OpenFileSecondSlide[$increment],
            'OpenFilePerecentSecondSlide' => $request->OpenFilePerecentSecondSlide[$increment],
            'thirdSlidePrice' => $request->thirdSlidePrice[$increment],
            'OpenFileThirdSlide' => $request->OpenFileThirdSlide[$increment],
            'OpenFilePerecentThirdSlide' => $request->OpenFilePerecentThirdSlide[$increment],
            'fourthSlidePrice' => $request->fourthSlidePrice[$increment],
            'OpenFileFourthSlide' => $request->OpenFileFourthSlide[$increment],
            'OpenFilePerecentFourthSlide' => $request->OpenFilePerecentFourthSlide[$increment],
            'display'=>1
        ];
        return $slides;
    }//end arr

    public function getAllBrands($name,$lang=null){
        $user_id = auth()->user()->id;
        $brands=CompleteDoc::where(['Insurance_Company_ar'=>$name,'display'=>1,'user_id'=>$user_id])
            ->get()->groupBy('brand_id');
        //dd($brands);
        $lang=$lang;
        return view('Cdashboard.all_brands',compact('brands','lang'));
    }//end getAllBrands

    public function getAllBrandsSearch(Request  $request,$lang=null){
//        dd($request->all());
        $user_id = auth()->user()->id;
        $models=models::where('name', 'LIKE', '%' . $request->search . '%')->pluck('id');
        $brands=CompleteDoc::where(['display'=>1,'user_id'=>$user_id])->whereIn('model_id',$models)->get()
        ->groupby('brand-id');
       // dd($brands);
        return view('Cdashboard.all_brands',compact('brands','lang'));
    }//end getAllBrandsSearch

    public function addBrand($id,$lang=null){

        $document=CompleteDoc::where('id',$id)->first();
        // dd($brands);
        $lang=$lang;
        return view('Cdashboard.add_brand',compact('document','lang'));
    }//end
  public function addBrandToDoc(Request  $request){
        //dd($request->all());
      $request->validate([
          'model_id'=>'required|array|min:1'
      ]);
      $res = null;
      $compDocument=CompleteDoc::where(['id'=>$request->id])->selectionExcpt()->toArray();
      $j=-1;
      for ($i=0;$i<count($request->firstSlidePrice);$i++){
        if ($request->firstSlidePrice[$i] !=null) {
            $j++;
            $con = ['model_id' => $request->model_id[$j], 'brand_id' => $request->brand_id];
            $arr = $this->arr($request, $i);
            $createRow = $arr + $compDocument[0] + $con;
            CompleteDoc::create($createRow);

        }//end if
      }
      return redirect()->route('all_complete')->with('success','تم الحفظ');
    }//end

     public function inDocumentStore(Request $request)
    {
//dd(auth()->user()->id);

        $request->validate([

            'model_id'=>'required',
            'type_of_use' =>'required',

        ]);

        $imageName = '';
        if(count($request->model_id) >= 1){


             if($request->file('logo')){
                      $imageName = time().'.'.request()->logo->getClientOriginalExtension();

                       request()->logo->move(public_path('uploads'), $imageName);
                    }


            foreach($request->model_id as $key=>$model){
                $doc = new CompleteDoc();
                $arr = explode(',',$model);
                $doc->brand_id = $request->brand_id;

                $doc->model_id = $request->model_id[$key];

                if($request->price[$key] != null){
                    $doc->price = $request->price[$key];
                }
                else
                {
                    $doc->price = 0;
                }


                if($request->type_of_use[$key] != null){
                    $doc->type_of_use = $request->type_of_use[$key];
                }


                $doc->user_id = auth()->user()->id;

                 $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
                 $doc->Insurance_Company_en = $request->Insurance_Company_en;
                 $doc->deliveryFee = $request->deliveryFee;

                $doc->year = date("Y");
                $doc->logo = $imageName;
                $doc->end_date = auth()->user()->ended_at;
                $doc->ar_term= $request->ar_term;
                $doc->en_term = $request->en_term;

                $doc->in_duration = $request->in_duration;
                $doc->precent = $request->precent;
                $doc->discount_q = $request->discount_q;
                $doc->start_disc = $request->start_disc ;
                $doc->end_disc = $request->end_disc;


                $doc->firstSlidePrice = $request->firstSlidePrice[$key];
                $doc->OpenFileFirstSlide = $request->OpenFileFirstSlide[$key];
                $doc->OpenFilePerecentFirstSlide = $request->OpenFilePerecentFirstSlide[$key];
                $doc->OpenFileMinimumFirstSlide = $request->OpenFileFirstSlideMin[$key];
                $doc->SecondSlidePrice = $request->SecondSlidePrice[$key];
                $doc->OpenFileSecondSlide = $request->OpenFileSecondSlide[$key];
                $doc->OpenFilePerecentSecondSlide = $request->OpenFilePerecentSecondSlide[$key];
                $doc->thirdSlidePrice = $request->thirdSlidePrice[$key];
                $doc->OpenFileThirdSlide = $request->OpenFileThirdSlide[$key];
                $doc->OpenFilePerecentThirdSlide = $request->OpenFilePerecentThirdSlide[$key];
                $doc->fourthSlidePrice = $request->fourthSlidePrice[$key];
                $doc->OpenFileFourthSlide = $request->OpenFileFourthSlide[$key];
                $doc->OpenFilePerecentFourthSlide = $request->OpenFilePerecentFourthSlide[$key];


                $doc->save();

                $Condition = Condition::create(
                    [
                        'ToleranceratioCheck' =>  $request->ToleranceratioCheck,
                        'Tolerance_ratio'  =>  $request->Tolerance_ratio,
                        'ToleranceYearPerecenteage' =>  $request->ToleranceYearPerecenteage ,
                        'ConsumptionRatio'  =>  $request->ConsumptionRatio,
                        'ConsumptionFirstRatio' =>  $request->ConsumptionFirstRatio,
                        'YearPerecenteage' =>  $request->YearPerecenteage,
                        'ConsumptionYearPerecenteage' =>  $request->ConsumptionYearPerecenteage,
                        'last_percent'=>$request->last_percent,
                        'insurance_document_id' =>  $doc->id
                    ]
                );
                foreach($request->AddonNameAR as $keyConditionItem => $AddonNameAR){
                    $ConditionItem = ConditionItem::create(
                        [
                            'AddonNameAR' => $AddonNameAR,
                            'AddonNameEn'  => $request->AddonNameEn[$keyConditionItem],
                            'AddonMaxYear'  => $request->AddonMaxYear[$keyConditionItem],
                            'AddonUnkownMaxmum'  => $request->AddonUnkownMaxmum[$keyConditionItem],
                            'condition_id' => $Condition->id
                        ]
                    );
                }

                foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
                    $Addition = Addition::create(
                        [
                            'FeatureNameAr' => $FeatureNameAr,
                            'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                            'FeatureCost' => $request->FeatureCost[$keyAddition],
                            'insurance_document_id' =>  $doc->id
                        ]
                    );
                }

                // $InsuranceDocumentBrand = InsuranceDocumentBrand::create(
                //     [
                //         'firstSlidePrice' => $request->firstSlidePrice[$key],
                //         'OpenFileFirstSlide' => $request->OpenFileFirstSlide[$key],
                //         'OpenFilePerecentFirstSlide' => $request->OpenFilePerecentFirstSlide[$key],
                //         'OpenFileFirstSlideMin'  => $request->OpenFileFirstSlideMin[$key],
                //         'SecondSlidePrice'  => $request->SecondSlidePrice[$key],
                //         'OpenFileSecondSlide' => $request->OpenFileSecondSlide[$key],
                //         'OpenFilePerecentSecondSlide' => $request->OpenFilePerecentSecondSlide[$key],
                //         'thirdSlidePrice'  => $request->thirdSlidePrice[$key],
                //         'OpenFileThirdSlide'  => $request->OpenFileThirdSlide[$key],
                //         'OpenFilePerecentThirdSlide' => $request->OpenFilePerecentThirdSlide[$key],
                //         'fourthSlidePrice' => $request->fourthSlidePrice[$key],
                //         'OpenFileFourthSlide'  => $request->OpenFileFourthSlide[$key],
                //         'OpenFilePerecentFourthSlide'  => $request->OpenFilePerecentFourthSlide[$key],
                //         'insurance_document_id' =>  $doc->id
                //     ]
                //     );

            }
        }

        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');

    }
    public function ddElgher(Request $request){
        $request->validate([
            'model_id'=>'required',

        ]);
       $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
       $logo_name = '';
       $country=country::first()->id;

            if($request->file('logo')){
                        $imageName = $request->Insurance_Company_ar.'.'.request()->logo->getClientOriginalExtension();
                        request()->logo->move(public_path('uploads'), $imageName);
                          $logo_name = $imageName;
                    }

        if($insurance == null){

           $insurance = new \App\Insurance();
           $insurance->user_id = auth()->user()->id;
           $insurance->ar_name =$request->Insurance_Company_ar;
           $insurance->en_name =$request->Insurance_Company_en;
           $insurance->image = $logo_name;
           $insurance->country_id = $country;
           $insurance->status = 1;
           $insurance->save();

       }
        foreach($request->model_id as $key=>$modelid)
        {
            $model_brand = explode(',',$modelid);
            $doc = new InsuranceDocument();
        $doc->insurance_id=$insurance->id;
        $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
        $doc->Insurance_Company_en = $request->Insurance_Company_en;
        $doc->deliveryFee = $request->deliveryFee;
        $doc->model_id =$model_brand[0];
        $doc->brand_id = $model_brand[1];
        $doc->ar_term= $request->ar_term;
        $doc->en_term = $request->en_term;
        $doc->user_id = auth()->user()->id;
        $doc->price = $request->price[$key];
        $doc->year = date("Y");
        $doc->firstinterval = $request->firstinterval[$key];
        $doc->secondinterval = $request->secondinterval[$key];
        $doc->thirdinterval = $request->thirdinterval[$key];
        $doc->precent = $request->precent;
        $doc->discount_q = $request->discount_q;
        $doc->start_disc = $request->start_disc;
        $doc->end_disc = $request->end_disc;
        $doc->type_of_use = $request->type_of_use[$key];
        $doc->in_duration = $request->in_duration;
       $doc->logo =$logo_name;
        $doc->end_date = auth()->user()->ended_at;

        // $doc->type = 0;
        $doc->save();
        }

        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');


    }
    public function inDocumentCreate($lang=null){

        $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
        $insurance_document = \App\InsuranceDocument::where('user_id',auth()->user()->id)->get();
        $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
                    $merge_insurance =$insurance_document->merge( $complete_insurance);
        return view('Cdashboard.insuranceC')->with(['lang'=>$lang,'insurance'=>$insurance,'complete_insurance'=>$complete_insurance,'merge_insurance'=>$merge_insurance,'insurance_document'=>$insurance_document,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }

    public function inDocumentCreateComplete($lang=null){

        $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
         $uses=Style::all();
        return view('Cdashboard.CreateComplete')->with(['lang'=>$lang,'insurance'=>$insurance,'uses'=>$uses]);
    }

    public function compDocumentCreate($lang=null){
        $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
        $insurance_document = \App\InsuranceDocument::where('user_id',auth()->user()->id)->get();
        $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
        $merge_insurance =$insurance_document->merge( $complete_insurance);
        $data=\App\CompleteDoc::where('user_id',auth()->user()->id)->first();
        //dd($data);dd('fff');
        $uses=Style::get();
        return view('Cdashboard.InsuranceCFull')->with(['uses'=>$uses,'lang'=>$lang,'insurance'=>$insurance,'complete_insurance'=>
            $complete_insurance,'merge_insurance'=>$merge_insurance,'insurance_document'
        =>$insurance_document,'brands'=>\App\brands::where('status',1)->get(),
            'models'=>\App\models::get(),'data'=>$data]);
    }

    public function inDocumentEdit($id , $lang=null)
    {
        $id = \App\InsuranceDocument::where('id',$id)->first();
        if($id)
        {
         return view('Cdashboard.insuranceU')->with(['lang'=>$lang,'document'=>$id,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
        }
        else
        {
            return back();
        }
    }
     public function inDocumentUpdate(Request $request)
    {
        $request->validate([
             'brand_id'=>'required',
            'model_id'=>'required',

        ]);

        $doc = InsuranceDocument::where('id',$request->insurance_id)->first();
        $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
        $doc->Insurance_Company_en = $request->Insurance_Company_en;
        $doc->deliveryFee = $request->deliveryFee;
        $doc->model_id = $request->model_id;
        $doc->brand_id = $request->brand_id;
        $doc->ar_term= $request->ar_term;
        $doc->en_term = $request->en_term;
        $doc->user_id = auth()->user()->id;
        $doc->price = $request->price;
        $doc->year = date("Y");
        $doc->firstinterval = $request->firstinterval;
        $doc->secondinterval = $request->secondinterval;
        $doc->thirdinterval = $request->thirdinterval;
        $doc->precent = $request->precent;
        $doc->discount_q = $request->discount_q;
        $doc->start_disc = $request->start_disc ;
        $doc->end_disc = $request->end_disc;
        $doc->type_of_use = $request->type_of_use;
        $doc->in_duration = $request->in_duration;
         if($request->file('logo')){
                        $imageName = $request->Insurance_Company_ar.'.'.request()->logo->getClientOriginalExtension();
                        request()->logo->move(public_path('uploads'), $imageName);
                        $doc->logo = $imageName;
                    }

        // $doc->type = 0;
        $doc->save();
        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');

    }
    public function cmDocumentStore(Request $request)
    {
        $request->validate([
            'brand_id'=>'required',
            'model_id'=>'required',
            'type_of_use' =>'required',

        ]);
        if(count($request->brand_id) >= 1){
            foreach($request->brand_id as $key=>$brand){


                 $doc = new CompleteDoc();
                 $doc->insurance_id = $request->insurance_id;
                $doc->brand_id = $brand;
                $doc->model_id =  $request->model_id[$key];


                if($request->year[$key] != null ){
                    $doc->year = $request->year[$key];
                }
                else
                 {
                    $doc->year = 0;
                }
                  if($request->inmethodfrom[$key] != null ){
                    $doc->inmethodfrom = $request->inmethodfrom[$key];
                }
                else
                 {
                    $doc->inmethodfrom = 0;
                }
                  if($request->inmethodto[$key] != null ){
                    $doc->inmethodto = $request->inmethodto[$key];
                }
                else
                 {
                    $doc->inmethodto = 0;
                }
                  if($request->percentage[$key] != null ){
                    $doc->percentage = $request->percentage[$key];
                }
                else
                 {
                    $doc->percentage = 0;
                }
                  if($request->fileprice[$key] != null ){

                    $doc->fileprice = $request->fileprice[$key];
                }
                else
                 {
                    $doc->fileprice = 0;
                }
                  if($request->minimum[$key] != null ){
                    $doc->minimum = $request->minimum[$key];
                }
                else
                 {
                    $doc->minimum = 0;
                }
                $doc->user_id = auth()->user()->id;

                $doc->ar_term= $request->ar_term;
                $doc->en_term = $request->en_term;
                $doc->type_of_use = $request->type_of_use;
                $doc->start_disc = $request->start_disc ;
                $doc->end_disc = $request->end_disc;
                $doc->type = 1;
                $doc->save();

            }
        }

        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');
    }
     public function cmDocumentEdit($id , $lang=null)
    {
        $id = \App\CompleteDoc::where('id',$id)->first();
        if($id)
        {
      //   return view('Cdashboard.Insurance_CFull')->with(['lang'=>$lang,'document'=>$id,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
        return view('Cdashboard.insuranceCU')->with(['lang'=>$lang,'document'=>$id,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
        }
        else
        {
            return back();
        }
    }
     public function cmDocumentUpdate(Request $request)
    {
        $request->validate([
            'brand_id'=>'required',
            'model_id'=>'required',

        ]);
        $doc = CompleteDoc::where('id',$request->insurance_id)->first();
        // $doc->insurance_id = $request->insurance_id;
        $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
        $doc->Insurance_Company_en = $request->Insurance_Company_en;
        $doc->model_id = $request->model_id;
        $doc->brand_id = $request->brand_id;
        $doc->ar_term= $request->ar_term;
        $doc->en_term = $request->en_term;
        $doc->type_of_use = $request->type_of_use;
        $doc->year = $request->year;
        $doc->inmethodfrom = $request->inmethodfrom;
        $doc->inmethodto = $request->inmethodto;
        $doc->percentage= $request->percentage;
        $doc->fileprice = $request->fileprice;
        $doc->minimum = $request->minimum;
        // $doc->in_duration = $request->in_duration;
        // $doc->precent = $request->precent;
        // $doc->discount_q = $request->discount_q;
        $doc->start_disc = $request->start_disc ;
        $doc->end_disc = $request->end_disc;
        // $doc->type = 1;
        $doc->save();

        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');

    }
    public function deleteinDocument($id){
        if($id != null)
        {
            \App\userinsurance::where('id',$id)->Forcedelete();
            return back();
        }
        else
         {
             return back();
         }
    }
       public function cmforce($id)
    {
        if($id != null)
        { //dd('dd');
            InsuranceDocument::find($id)->forceDelete();
            return redirect('Cdashboard/insurance')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function inforce($id)
    {
        if($id != null)
        {
            InsuranceDocument::where('id',$id)->forceDelete();
            return redirect('Cdashboard/insurance')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
     public function CompDoc_delete($id)
    {
        if($id != null)
        {
            \App\CompleteDoc::where('id',$id)->forceDelete();

            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
    public function CompDoc_active($id){
        $insurnace =  \App\CompleteDoc::where('id',$id)->first();
        $insurnace->status = 1 ;
        $insurnace->save();
        return back()->with('success' , 'تم التفعيل بنجاح');
    }

      public function CompDoc_deactive($id){
        $insurnace =  \App\CompleteDoc::where('id',$id)->first();
        $insurnace->status = 0 ;
        $insurnace->save();
        return back()->with('success' , 'تم التعطيل بنجاح');
    }

     public function IncCompDoc_active($id){
        $insurnace =  \App\InsuranceDocument::where('id',$id)->first();
        $insurnace->status = 1 ;
        $insurnace->save();
        return back()->with('success' , 'تم التفعيل بنجاح');
    }
      public function IncCompDoc_deactive($id){
        $insurnace =  \App\InsuranceDocument::where('id',$id)->first();
        $insurnace->status = 0 ;
        $insurnace->save();
        return back()->with('success' , 'تم التعطيل بنجاح');
    }

     public function IncCompDoc_delete($id)
    {
        if($id != null)
        {
            \App\InsuranceDocument::where('id',$id)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function active_insurnace(Request $request){
        $insurance_company = \App\Insurance::where('id' , $request->id)->first();
        $insurance_documents = \App\InsuranceDocument::where('user_id',$request->user_id)->get();
        $complete_insurances = \App\CompleteDoc::where('user_id',$request->user_id)->get();
        if($insurance_documents){
            foreach($insurance_documents as $insurance_document){
                $insurance_document->status = 1 ;
                $insurance_document->save();
            }
        }
         if($complete_insurances){
            foreach($complete_insurances as $complete_insurance){
                $complete_insurance->status = 1 ;
                $complete_insurance->save();
            }
        }
        $insurance_company->status = 1;
        $insurance_company->save();
        return back()->with('success' , 'تم التفعيل بنجاح');
    }

     public function deactive_insurnace(Request $request){
        $insurance_company = \App\Insurance::where('id' , $request->id)->first();
        $insurance_documents = \App\InsuranceDocument::where('user_id',$request->user_id)->get();
        $complete_insurances = \App\CompleteDoc::where('user_id',$request->user_id)->get();
        if($insurance_documents){
            foreach($insurance_documents as $insurance_document){
                $insurance_document->status = 0 ;
                $insurance_document->save();
            }
        }
         if($complete_insurances){
            foreach($complete_insurances as $complete_insurance){
                $complete_insurance->status = 0 ;
                $complete_insurance->save();
            }
        }

        $insurance_company->status = 0;
        $insurance_company->save();
        return back()->with('success' , 'تم التعطيل بنجاح');
    }

    public function UpdateBrand(Request  $request){
        $row=CompleteDoc::find($request->id);
        $row->fill($request->except(['_token','id']));
        $row->save();
        return redirect()->back()->with(['success' => 'Banner updated successfully']);
    }//end UpdateBrand

    public function contactUs(Request  $request){
        $request->validate([
            'txtName' => 'required|string|max:255',
            'txtPhone' => 'required|string|max:255',
            'txtMsg' => 'required',
            'txtEmail' => 'required|email|email'
            //'password' => ['required', 'string', 'min:8'],
        ]);
        //dd($request->all());
        $email=$request->txtEmail;
        $name=$request->txtName;
        $phone=$request->txtPhone;
        $msg=$request->txtMsg;
        $mail='soouqnet235@gmail.com';
        Mail::send([], [], function ($message) use ($email,$name,$phone,$msg,$mail) {

            $message->to($mail, 'New Message')->subject
            ('New Request')// here comes what you want
            ->setBody(
                '<h4> Phone :  ' . $phone . '  </h4> <p> Name :  '.$name.' </p>
                <h4>Email:'.$email.'</h4><p>Message : '.$msg.'</p>', 'text/html'); // assuming text/plain
            $message->from('info@tameenistore.com', 'New Message');
        });
        return redirect()->back()->with(['success'=>'تم الارسال بنجاح']);
    }//end aboutUs



}//end class

