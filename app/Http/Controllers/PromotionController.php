<?php

namespace App\Http\Controllers;

use App\Cars;
use App\City;
use App\User;
use App\items;
use App\Balance;
use App\country;
use App\CarHolder;
use App\Promotion;
use App\Governorate;
use App\UserNotification;
use App\NotificationPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class PromotionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function promotion($lang=null){
        $balance= Balance::where('user_id',auth()->user()->id)->first();
        $packages = NotificationPrice::get();
        $promotions = Promotion::where('user_id',auth()->user()->id)->paginate();
        return view('dashboard.promotions.index',compact('balance','lang','packages','promotions'));
    }
    public function promotionNew($lang=null){
        $countries  = country::where('status',1)->get();
        return view('dashboard.promotions.new')->with(['lang'=>$lang,'countries'=>$countries]);
    }
    public function targetCount(Request $request)
    {
        $countries_ids = !empty($request->input('country')) ? $request->input('country') : [];
        $governorate_ids = !empty($request->input('governorate')) ? $request->input('governorate') : [];
        $city_ids = !empty($request->input('city')) ? $request->input('city') : [];
        
        $count = 0 ;

        if(!empty($city_ids)) 
        return  User::whereIn('city_id',$city_ids)->count();

        else if(!empty($governorate_ids))
        return User::whereIn('governorate_id',$governorate_ids)->count();

        else if(!empty($countries_ids))
        return  User::whereIn('country_id',$countries_ids)->count();
    }
    public function addBalancePromotion(Request $request)
    {
        $package_id = $request->input('package_id');
        $package = NotificationPrice::where('id',$package_id)->get()->first();
        $user = auth()->user();
        $balance = Balance::where('user_id',$user->id)->first();
        $current_balance = !is_null($balance) ?  $balance->balance : 0;
        $current_package_number =  floatval($package->number);
        $current_notifications_balance =  !empty($user->notifications_balance) ? floatval($user->notifications_balance) : 0 ;
        if(floatval($current_balance) >=  floatval($package->price))
        {
            $balance->update(['balance'=> ($current_balance-$package->price )]);
            $user->update(['notifications_balance'=>$current_package_number + $current_notifications_balance]);
            $request->session()->flash('success','site.balance add successfully');
            return response()->json($user, 200);
        }
        $request->session()->flash('error','site.your balance is not enought');
        return response()->json(false, 200);

    }

        
    public function getAdsByType(Request $request)
    {
        $type = $request->input('type');
        $user = auth()->user();
        if($type == 'cars')
        {
            $carHolder = CarHolder::where('is_user',$user->id)->get();
            $ads = Cars::whereIn('id',$carHolder->pluck('car_id'))->where('status',1)->get();
        }else if($type == 'categories')
        $ads = items::where([['status','=',1],['user_id','=',$user->id]])->get();
        
        return response()->json($ads, 200);
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
        $request->validate([
            'ad_type' => 'required|string|max:255',
            'ad_id' => 'required|numeric',
            'countries' => 'required|array',
            // 'governorates' => 'required|array',
            // 'cities' => 'required|array',
            'subject' => 'required|string',
            'image' => 'required|max:5000|mimes:jpeg,jpg,png',
            'body' => 'required|string',
        ]);

        $notifications_balance = auth()->user()->notifications_balance;
       
        if($notifications_balance > 0){
        $promotion = new Promotion();
        $imgname = time().'.'.$request->image->getClientOriginalExtension();
        $promotion->ad_type = $request->ad_type;
        $promotion->ad_id = $request->ad_id;
        $promotion->user_id = auth()->user()->id;
        $promotion->countries = implode('-',$request->countries);
        $promotion->governorates = $request->governorates ? implode('-',$request->governorates) : null;
        $promotion->cities =  $request->cities ? implode('-',$request->cities) : null;
        $promotion->subject = $request->subject;
        $promotion->image = $imgname;
        $promotion->body = $request->body;
        $request->image->move(public_path('uploads'),$imgname);
        $promotion->save();
        UserNotification::create([
            'user_id' => auth()->user()->id,
            'subject' => __('site.your ad is in review'),
            'body' => __('site.your ad is in review please waite to your ad to be approved'),
        ]);
        $request->session()->flash('success', 'site.saved successfully');
        return redirect('promotion');
       }
       $request->session()->flash('error', 'site.your balance is not enought');
        return redirect('promotion');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotion = Promotion::where('id',$id)->get()->first();
        if(!is_null($promotion))
        return $promotion;
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        $promotion = Promotion::where('id',$id)->get()->first();
        $notes = $status == 'rejected' ? $request->notes : null;
        if(!is_null($promotion))
        {
            $promotion->update(['status'=>$status,'notes'=>$notes]);
            if($status === 'approved')
            $this->sendPromotions($promotion);
            $request->session()->flash('success', 'site.saved successfully');
            return back();    
        }
        return;
    }

    public function sendPromotions($promotion)
    {
 
    Artisan::queue('send-promote:notification',['promotion'=>$promotion]);
       return;  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promotion = Promotion::where('id',$id)->get()->first();
        if(!is_null($promotion)){
            $promotion->delete();
            request()->session()->flash('success', 'site.saved successfully');
            return back();   
        }
        return back();
    }
}
