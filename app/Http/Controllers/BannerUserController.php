<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Banner;
use App\country;
use App\DepartmentMembership;
use App\UserBanner;
use Illuminate\Http\Request;

class BannerUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }//end construct

    public function banners($lang){
        $banners=Banner::where('type',0)->get();
        $countries=country::where(['status'=>1,'parent'=>0])->get();
        $rows=UserBanner::where(userBannersConditions())->get();
        // return view('Cdashboard.banners',compact('lang','rows','countries','banners'));
        return view('dashboard.banners.user-banner',compact('lang','rows','countries','banners'));
    }

    public function getInfo($id,$lang){
        $rows=Banner::where('id',$id)->first();
        //$lang= app()->getLocale();
        if ($rows->type==0)$rows['type_trans']=$lang=='ar'?'اعلى الصفحه':'Up Page';
       elseif($rows->type==1)$rows['type_trans']=$lang=='ar'?'الجانب الايمن للصفحه':'Right Page';
       else$rows['type_trans']=$lang=='ar'?'الجانب الايسر للصفحه':'Left Page';
       //
        $rows['page_trans'] =  get_banners_pages($rows->page);
        return response()->json($rows);
    }//end getInfo

    public function addUserBanner(Request  $request){
        $request->validate([
            'banner_id'=>'required',
            'country_id'=>'required',
            'file'=> 'required|image|max:7000',
            'start_date'=>'required|date|after:yesterday',
        ]);
       //dd($request->all());
        $user=auth()->user();
        $balance=Balance::where('user_id',$user->id)->first();
        $price=Banner::where('id',$request->banner_id)->first();
        $day = $request->start_date;
       // dd($price->duration);
        $date = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
       // $file=uploadImage($request->file);
        if($request->file('file')){
            $imageName = rand().time().'.'.request()->file->getClientOriginalExtension();
            request()->file->move(public_path('uploads'), $imageName);
        }
        $arr=['link'=> $request->link, 'user_id'=>$user->id,'banner_id'=>$request->banner_id,'country_id'=>$request->country_id,
            'start_date'=>$request->start_date,'end_date'=>$date,'file'=>$imageName];
     //dd($arr);
        if ((isset($price) &&$price->price==0) || auth()->user()->guard == 1){
            $this->addBanner($arr);
            return redirect()->back()->with('success','تم الحفظ');
        }
        else{
            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $dep=$this->addBanner($arr);
                    $total=$price->price;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user->id,'out',$total,'banner',$dep);
                    return redirect()->back()->with('success','تم الاضافه بنجاح');
                }
                else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
        }//end else
    }//end addUserBanner

    public function addBanner($arr){
     // dd($arr[4]);
        $row=UserBanner::create($arr);
        return $row->id;
    }//end addBanner

    public function editBanner($id,Request  $request){
        $request->validate([
            'country_id'=>'required',
            'link'=>'nullable|url',
        ]);
        $row=UserBanner::find($id);
        if ($row){
            $row->update($request->except('token'));
            return redirect()->back()->with('success','تم التحديث بنجاح ');
        }else{
            return redirect()->back()->with('success','هذا العنصر غير موجود ');
        }
    }//end fun

    public function renewBanner($id,Request  $request){
        $request->validate([
            'banner_id'=>'required',
            'start_date'=>'required|date|after:yesterday',
        ]);
        $user=auth()->user();
        $balance=Balance::where('user_id',$user->id)->first();
        $price=Banner::where('id',$request->banner_id)->first();
        $row=UserBanner::find($id);
        $day = $request->start_date;

        $date = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        if (isset($price) &&$price->price==0){
            $row->update(['banner_id'=>$request->banner_id,'start_date'=>$request->start_date,'end_date'=>$date]);
            return redirect()->back()->with('success','تم الحفظ');
        }
        else{
            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $row->update(['banner_id'=>$request->banner_id,'start_date'=>$request->start_date,'end_date'=>$date]);
                    $total=$price->price;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user->id,'out',$total,'banner',$id);
                    return redirect()->back()->with('success','تم الاضافه بنجاح');
                }
                else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
        }//end else
    }//end fun

    public function deleteBanner($id){
        $row=UserBanner::find($id);
        if ($row){
            $row->delete();
            return redirect()->back()->with('success','تم الحذف بنجاح ');
        }else{
            return redirect()->back()->with('success','هذا العنصر غير موجود ');
        }
    }//end fun


}//end class
