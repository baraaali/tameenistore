<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Balance;
use App\country;
use App\UserBanner;
use Illuminate\Http\Request;
use App\DepartmentMembership;

class BannerUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }//end construct

    public function banners($lang = null){
        $banners=Banner::paginate();
        $countries = country::where('status','1')->get();
        return view('dashboard.banners.index',compact('lang','banners','countries'));
    }

    public function getInfo($id,$lang){
        $rows=Banner::where('id',$id)->first();
        //$lang= app()->getLocale();
        if ($rows->type==0)$rows['type_trans']=$lang=='ar'?'اعلى الصفحه':'Up Page';
       elseif($rows->type==1)$rows['type_trans']=$lang=='ar'?'الجانب الايمن للصفحه':'Right Page';
       else$rows['type_trans']=$lang=='ar'?'الجانب الايسر للصفحه':'Left Page';
       //
        if ($rows->page==0)$rows['page_trans']=$lang=='ar'?'الرئيسيه':'Home';
        elseif ($rows->page==1)$rows['page_trans']=$lang=='ar'?'سيارات للبيع':'car sale';
        elseif ($rows->page==2)$rows['page_trans']=$lang=='ar'?'سيارات الايجار':'car rent';
        elseif ($rows->page==3)$rows['page_trans']=$lang=='ar'?'وكالات البيع':'agent sale';
        elseif ($rows->page==4)$rows['page_trans']=$lang=='ar'?'وكالات الايجار':'agent rent';
        elseif ($rows->page==5)$rows['page_trans']=$lang=='ar'?'الاعلانات':'Ads';
        elseif ($rows->page==6)$rows['page_trans']=$lang=='ar'?'كل الاقسام':'All Departments';
        elseif ($rows->page==7)$rows['page_trans']=$lang=='ar'?'القسم الواحد':'Single Departments';
        elseif ($rows->page==8)$rows['page_trans']=$lang=='ar'?'بجوار الاعلانات الذهبيه':'Beside Golden Ads';
        elseif ($rows->page==9)$rows['page_trans']=$lang=='ar'?'بجوار الاعلانات المميزة':'Beside Spacial Ads';
        elseif ($rows->page==10)$rows['page_trans']=$lang=='ar'?'بجوار الاعلانات الفضيه':'Beside Silver Ads';
        elseif ($rows->page==11)$rows['page_trans']=$lang=='ar'?'بجوار الاعلانات العاديه':'Beside Normal Ads';
        return response()->json($rows);
    }//end getInfo

    public function addUserBanner(Request  $request){
    //    dd($request->all());
        $request->validate([
            'banner_id'=>'required',
            'file'=> 'required|image|max:7000',
        ]);
        $user=auth()->user();
        $balance=Balance::where('user_id',$user->id)->first();
        $price=Banner::where('id',$request->banner_id)->first();
        $day = date('Y-m-d');
        $date = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
       // $file=uploadImage($request->file);
        if($request->file('file')){
            $imageName = rand().time().'.'.request()->file->getClientOriginalExtension();
            request()->file->move(public_path('uploads'), $imageName);
        }
        $arr=[$user->id,$request->banner_id,$user->country_id,$date,$imageName,$request->link];
     //dd($arr);
        if ((isset($price) &&$price->price==0) || auth()->user()->guard == 1){
            $this->addBanner($arr);
            return redirect()->back()->with('success','تم الحفظ');
        }
        else{
            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $dep=$this->addBanner($request->all());
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

    public function addBanner($data){
    //  dd($arr);
    $data['user_id'] = auth()->user()->id;
    $row=UserBanner::create($data);
        // $row=UserBanner::create([
        //     'user_id'=>$arr[0],
        //     'banner_id'=>intval($arr[1]),
        //     'country_id'=>$arr[2],
        //     'end_date'=>$arr[3],
        //     'file'=>$arr[4],
        //     'link'=>$arr[4],
        // ]);
        return $row->id;
    }//end addBanner

}//end class
