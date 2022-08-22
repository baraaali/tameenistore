<?php

namespace App\Http\Controllers;

use App\Balance;
use App\DepartmentMembership;
use App\Exhibition;
use App\Agents;
use App\carImages;
use App\Cars;
use App\CarHolder;
use App\carPrices;
use App\country;
use App\AgentBranches;
use App\ExhibitorBranches;
use App\items;
use App\Price;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\membership;
use App\User;
use App\models;

use Hash;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('showCat');
    }

    public function index($lang = null){
        $user=auth()->user()->id;
        $items = \App\items::where('user_id',$user)->get();
       // dd($items);
        // $country = country::where('status',1)->get();
         $country = country::where('status',1)->get();
        // why status/
        $categories = \App\Categories::where('status',1)->get();
        return view('Cdashboard.accessories',['viewcategories'=>$categories,'lang'=>$lang,'countries'=>$country,'items'=>$items]);
    }

    public function showCat($id,$lang=''){
         $car=items::find($id);
         $lang=$lang;
        // dd($car->images);
        $count=$car->visitors+1;
        $car->update(['visitors'=>$count]);
        $car->save();
         if ($car==null) return back()->with('sucess','هذا العنصر غير موجود');
        return view('content.show-one-cat',compact('car','lang'));
    }//end showCat

    public function store(Request $request){
       // dd($request->all());
        $request->validate([
                'ar_name'=>'required',
                'en_name'=>'required',
                'ar_desciption'=>'required',
                'en_description'=>'required',
                'category_id'=>'required',
                'special'=>'required|int|exists:departmentmemberships,id',
                'country_id'=>'required',
                'discount'=>'required',
                'price'=> 'required|numeric',
                'images'=> 'required|array',
                'main_image'=> 'required|image|max:7000',
            ]);
        $user_id=auth()->user()->id;
        $balance=Balance::where('user_id',$user_id)->first();
       // $price=Price::where('id',$request->special)->first();
        $price=DepartmentMembership::where('id',$request->special)->first();
        if (isset($price) &&$price->price==0){
            $this->addDepartment($request);
            return redirect()->back()->with('success','تم الحفظ');
        }
        else{

            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $dep=$this->addDepartment($request);
                    $days=$request->number_days;
                    $total=$price->price*$days;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user_id,'out',$total,'department',$dep);
                    return redirect()->back()->with('success','تم الحفظ');
                }
                else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
        }//end else

    }//end store

    public function addDepartment(Request $request){
        if($request->file('main_image')){
            $imageName = $request->en_name.'.'.request()->main_image->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
        }
        $day = date('Y-m-d');
        $NewDate = date('Y-m-d', strtotime($day . " +".$request->number_days." days"));
        $new = new \App\items();
        $new->category_id = $request->category_id;
        $new->country_id = $request->country_id;
        $new->user_id = auth()->user()->id;
        $new->ar_name = $request->ar_name;
        $new->en_name = $request->en_name;
        $new->ar_desciption = $request->ar_desciption;
        $new->en_description = $request->en_description;
        $new->price = $request->price;
        $new->main_image = $imageName;
        $new->discount = $request->discount;
        $new->dicount_percent = $request->dicount_percent;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->status = 1;
        $new->special = $request->special;
        $new->end_ad_date = $NewDate;
        $new->visitors = 0;
        $new->item_end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + 30 days'));
        $new->save();

        if($request->images)
        {
            $files = $request->file('images');

            foreach($files as $file)
            {

                $newImage = new \App\item_pics();
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $imageName);

                $newImage->item_id = $new->id;
                $newImage->image = $imageName;
                $newImage->save();
            }
        }
        return $new->id;
    }

    public function update(Request $request){
         $request->validate([
                'ar_name'=>'required',
                'en_name'=>'required',
                'en_description'=>'required',
                'ar_desciption'=>'required',
                'price'=> 'required',
            ]);
        $new = \App\items::where('id',$request->id)->first();

        $new->category_id = $request->category_id;
        $new->country_id = $request->country_id;
         $new->user_id = auth()->user()->id;
        $new->ar_name = $request->ar_name;
        $new->en_name = $request->en_name;
        $new->ar_desciption = $request->ar_desciption;
        $new->en_description = $request->en_description;
        $new->price = $request->price;
        $new->discount = $request->discount;
        $new->dicount_percent = $request->dicount_percent;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->status = 1;
        $new->special = 1;
        $new->visitors = 0;
        $new->item_end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + 30 days'));;

        if($request->file('main_image')){
            $imageName = $request->en_name.'.'.request()->main_image->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
            $new->main_image=$imageName;
        }
        $new->save();
        if($request->images)
        {

            $old_images = \App\item_pics::where('item_id',$request->id)->get();
            foreach($old_images as $old){
                $old->delete();
            }

            $files = $request->file('images');

            foreach($files as $file)
            {

                $newImage = new \App\item_pics();
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();



            $file->move(public_path('uploads'), $imageName);

                $newImage->item_id = $new->id;
                $newImage->image = $imageName;
                $newImage->save();
            }
        }

       return redirect()->back()->with('success','تم التحديث بنجاح');
    }

    public function destroy($id){
        $item = \App\items::where('id',$id)->first();
        if($item->delete()){
            return back();
        }
        return back();
    }



}
