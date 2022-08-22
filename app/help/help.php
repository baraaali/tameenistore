<?php

use App\Like;
use App\User;
use App\CompleteDoc;
use App\MemberInsurance;
use App\InsuranceDocument;
use App\Events\NotificationEvent;
//use Session;

 function get_banners_pages($index = null)
{
   $arr =  [
        'الرئيسيه'
    ,'سيارات للبيع'
    ,'سيارات للايجار'
    ,'وكالات البيع'
    ,'وكالات الايجار'
    ,'إعلانات الأقسام'
    ,'خدمات السيارات'
    ,'الإعلانات التجارية'
    ,'تأمين ضد الغير'
    ,'تأمين شامل'

//        ,'بجوار الاعلانات الذهبيه','بجوار الاعلانات المميزة ','بجوار الاعلانات الفضيه','بجوار الاعلانات العاديه'
    ];
    if($index != null) return $arr[$index];
    return $arr;
}

function get_banners_types($index = null){
    $arr = ['اعلى الصفحه','جانب الصفحه الايمن','جانب الصفحه الايسر'];
    if($index != null) return $arr[$index];
    return $arr;
}

function getCountry(){
    if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
        return  intval(session()->get('selected_value'));  
    }
    return 0;

    /*if (session()->has('country')) {
        $country = Session::get('country');
        $country_id=\App\country::where('en_name',$country)->first()->id;
    }
    else $country_id=0;
    return $country_id;*/
}

function forgetCountry(){
    Session::forget('country');
    return redirect()->back();
}

function transaction($user_id,$transaction,$value,$type,$type_id=0){
  \App\PaymentHistory::create([
      'user_id'=>$user_id,
      'transaction'=>$transaction,
      'value'=>$value,
      'type'=>$type,
      'type_id'=>$type_id,
      'balance_after'=>0,
  ]);

  // send notification
  $user = User::where('id',$user_id)->first();
  if($transaction == 'in'){
    NotificationEvent::dispatch(["purpose"=>"add_credit","params"=>['email'=>$user->email]]);
  }else if($transaction == 'out'){
    NotificationEvent::dispatch(["purpose"=>"balance_discount","params"=>['email'=>$user->email]]);
  }
}

function uploadImage($image){
    $imageName = rand().time().'.'.$image->getClientOriginalExtension();
    $image->move(public_path('uploads'), $imageName);
    return $imageName;
}

function checkUploadDocument($type=0){

    if ($type !=0) $user=auth()->guard('api')->user();
    else $user=auth()->user();
    $web=\App\Website::first();
    if ($user->type==0) return 0;
    else{
       if ($web->data==0) return 0;
       else{
           $doc=\App\DocumentsUser::where('user_id',$user->id)->first();
           if ($doc) return 0;
           else return 1;
       }
    }

}//end fun checkUploadDocument

function getCars($spacial,$country=0){
    $day = date('Y-m-d');
   $lang=app()->getlocale();
    $cars=\App\Cars::with('agents:id,'.$lang.'_name')
       ->with(['country:id,'.$lang.'_name,en_currency','Price'])
        ->whereHas('memberships', function($q) use($spacial){
          $q->where('ads_membership.type',$spacial);
      })
        ->whereHas('agents', function($q){
        $q->where('agents.status',1);
    })->where(['status'=>1]);
//dd($cars->get());
    if ($country>0){
       $cars=$cars->where(['country_id'=>$country]);
    }

      return  $cars->whereDate('end_ad_date','>',$day)->
      select('id','agent_id','category_id',$lang.'_name','year','country_id',
          'color','fuel','max','engine','kilo_meters','used',$lang.'_description','end_date',
      'visitors','discount_percent','main_image','special','end_ad_date')->get();
}

// get items
function getItems($spacial,$country=0,$category_id=0){
    $day = date('Y-m-d');
     $lang=app()->getlocale();
    $items=\App\items::with(['category','images','country','user','membership'])
      ->where(['status'=>1])
      ->whereDate('end_ad_date','>',$day)
      ->whereHas('membership',function($q) use ($spacial){
        $q->where('type',$spacial);
      });
    
    if ($country){
       $items=$items->where(['country_id'=>$country]);
    }
    if ($category_id){
       $items=$items->where(['category_id'=>$category_id]);
    }
    return  $items->get();
}


//function getCars($spacial,$country=0){
//    $day = date('Y-m-d');
//   $lang=app()->getlocale();
//    $cars=\App\Cars::with('agents:id,'.$lang.'_name')->
//        with(['country:id,'.$lang.'_name,en_currency','Price'])->whereHas('agents', function($q){
//        $q->where('agents.status',1);
//    })->where(['status'=>1,'special'=>$spacial]);
//
//    if ($country>0){
//       $cars=$cars->where(['country_id'=>$country]);
//    }
//
//      return  $cars->whereDate('end_ad_date','>',$day)->
//      select('id','agent_id','category_id',$lang.'_name','year','country_id',
//          'color','fuel','max','engine','kilo_meters','used',$lang.'_description','end_date',
//      'visitors','discount_percent','main_image')->get();
//}
//
function getCarsApi($spacial,$country=0){
    $day = date('Y-m-d');
    $lang=lang();
    $cars=\App\Cars::with('agents:id,'.$lang.'_name as name')->
        with('Price:id,car_id,cost,discount_start_date,discount_amount,discount_percent,discount_end_date')
        ->with('country:id,'.$lang.'_name as name,en_currency as currency,en_code as code')
        ->with('memberships:id,type')
        ->whereHas('memberships', function($q) use($spacial){
            $q->where('ads_membership.type',$spacial);
        })->whereHas('agents', function($q){
        $q->where('agents.status',1);
    })->where(['status'=>1]);

    if ($country>0){
        $cars=$cars->where(['country_id'=>$country]);
    }

    return  $cars->whereDate('end_ad_date','>',$day)->
    select('id','agent_id','category_id',$lang.'_name as name','year','country_id',
        'color','fuel','max','engine','kilo_meters','used',$lang.'_description as description','end_date',
        'visitors','discount_percent','main_image','special','end_ad_date')->inRandomOrder()->get();
}
//
function checkUserSubscription($type,$user=0){
//    if ($user==0) $user_id=auth()->user()->id;
//    else $user_id=$user;
    if ($user !=0) $user_id=auth()->guard('api')->user();
    else $user_id=auth()->user();
   // dd($user_id);
    $date=date('Y-m-d');

    $row=\App\SubscriptionUser::where(['user_id'=>$user_id->id,'type'=>$type])->orderBy('id','desc')->first();
//dd($row->member_id);
    if ($row){
        $sub=MemberInsurance::where('id',$row->member_id)->first();
       if ($sub->free==0&&$row->end_date>=$date) return $status=0;
       elseif ($sub->free==0&&$row->end_date<$date&&$type==0) return $status=1;
       elseif ($sub->free==0&&$row->end_date<$date&&$type==1) return $status=4;
       else{
           if ($type==0&&$row->end_date>=$date)return $status=0;
           elseif ($type==0&&$row->end_date<$date)return $status=2;
           elseif ($type==1&&$row->end_date>=$date)return $status=0;
           elseif ($type==1&&$row->end_date<$date)return $status=3;
       }//end else paid
    }//outer if
    else {
     if ($type==0)   return -1;
     if ($type==1)   return -2;
    }

}//end checkUserSubscription

function checkUserBalance($id,$value=0){
    $row=\App\Balance::where('user_id',$id)->first();
    if ($row){
        if ($row->balance<$value) return $checked=0;
        else {
            $price=$row->balance-$value;
            $row->update(['balance'=>$price]);
            return 1;
        }
    }else return $checked=0;
}//end checkUserBalance

function insertRow($id,$type,$duration){
    \App\Checking::create([
        'user_id'=>$id,
        'type'=>$type,
        'duration'=>$duration
    ]);
}

function checkMembership($member,$id,$type){

    $row=\App\SubscriptionUser::where(['user_id'=>$id,'member_id'=>$member->id,'type'=>$type])->first();
    $time=date('Y-m-d');
    if ($row) {
        if ($row->member_id !=1){
            $date=date('Y-m-d', strtotime($time. " +$member->duration days"));
            $row->update(['end_date'=>$date]);
            //update all old insurance
            if ($type==0){
                CompleteDoc::where('user_id',$id)->update(['end_date'=>$date]);
            }
            else{
                InsuranceDocument::where('user_id',$id)->update(['end_date'=>$date]);
            }
        }
    }else{
        $date=date('Y-m-d', strtotime($time . " +$member->duration days"));
        \App\SubscriptionUser::create(['user_id'=>$id,'member_id'=>$member->id,'end_date'=>$date,'type'=>$member->type]);
    }
}

function lang(){
    $lang=app()->getlocale();
    return $lang;
}

 function getItemsConditions()
{
    if(auth()->user()->guard == 1)
    return [];
    else
    return ['user_id'=>auth()->user()->id];
}

function getNewServicesConditions()
{
    if(auth()->user()->guard == 1)
    return [];
    else
    return ['user_id'=>auth()->user()->id];
}

function userBannersConditions()
{
    if(auth()->user()->guard == 1)
    return [];
    else
    return ['user_id'=>auth()->user()->id];
}

function getHeart($model,$ad_id)
{
    if(auth()->user())
    {
    $user_id = auth()->user()->id;
    $like = Like::where('user_id',$user_id)->where('model',$model)->where('ad_id',$ad_id)->first();
    if(!empty($like) && $like->is_liked == 1)
    return '<i class="fa fa-heart text-danger mx-1" aria-hidden="true"></i>';
    return '<i class="far fa-heart text-danger mx-1" aria-hidden="true"></i>';
    }
   
    return '<i class="fa fa-heart text-danger mx-1" aria-hidden="true"></i>';
}

function getLikesCount($model,$ad_id)
{
    return Like::where('model',$model)->where('ad_id',$ad_id)->where('is_liked',1)->count();
}

function format_interval($date) {
$first_date = new DateTime($date);
$today = new DateTime();
$interval = $first_date->diff($today);
$result = "";
if($interval->y)
{
if ($interval->y == 1) 
$result .= $interval->format(" عام ");else
if ($interval->y == 2) 
$result .= $interval->format(" عامين ");else
$result .= $interval->format("%y أعوام ");

}

if($interval->m)
{
if ($interval->y)
$result .= " و ";

if ($interval->m == 1) 
$result .= $interval->format(" شهر ");else
if ($interval->m == 2) 
$result .= $interval->format(" شهرين ");else
$result .= $interval->format("%m أشهر ");
}

if ($interval->d ) 
{
    if ($interval->m )
    $result .= " و ";
if ($interval->d == 1) 
$result .= $interval->format(" يوم ");else
if ($interval->d == 2) 
$result .= $interval->format(" يومين ");else
$result .= $interval->format("%d يوم ");
}

if ($interval->h) 
{
    if ($interval->d )
    $result .= " و ";
if ($interval->h == 1) 
$result .= $interval->format(" ساعة ");else
if ($interval->h == 2) 
$result .= $interval->format(" ساعتين ");else
$result .= $interval->format("%h ساعة  ");

}

if($result != "")
return " مند ".$result;
else
return "اليوم";


}


