<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Cars;
use App\User;
use App\items;
use App\Price;
use App\Agents;
use App\models;
use App\Balance;
use App\country;
use App\CarHolder;
use App\carImages;
use App\carPrices;
use Carbon\Carbon;
use App\Categories;
use App\Exhibition;
use App\membership;
use App\AgentBranches;
use App\ExhibitorBranches;

use Illuminate\Support\Str;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\DepartmentMembership;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class ItemsController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
       
       $this->middleware('auth')->except('showCat');
    }



    public function renewAds(Request  $request){
        
        $request->validate([
            // 'number_days' => 'required|int|min:1',
            'special'=>'required|int|exists:departmentmemberships,id',
        ]);
        $ad=items::find($request->ad);
        $price=DepartmentMembership::where('id',$request->special)->first();
        $day = date('Y-m-d');
        if ($ad->end_ad_date<$day)
            $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        else $NewDate = date('Y-m-d', strtotime($ad->end_ad_date . " +".$price->duration." days"));
        
        $user_id=auth()->user()->id;
        $balance=Balance::where('user_id',$user_id)->first();

        if ((isset($price) &&$price->price==0) || auth()->user()->guard == 1){
            DB::table('items')->where('id', $request->ad)->update(['end_ad_date'=>$NewDate,'item_end_date'=>$NewDate]);
            return redirect()->back()->with('success','تم تجديد الاعلان');
        }
        else{

            if (isset($balance)){
                if ($balance->balance >=$price->price){
                   // dd($NewDate);
                    DB::table('items')->where('id', $request->ad)->update(['end_ad_date'=>$NewDate,'item_end_date'=>$NewDate]);
                 //   $ad->update(['end_ad_date'=>'2021-06-22','item_end_date'=>$NewDate]);
                    $total=$price->price;
                   $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user_id,'out',$total,'car',$request->ad);
                    return redirect()->back()->with('success','تم الحفظ');
                }
                else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
        }//end else

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
                    $total=$price->price;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user_id,'out',$total,'department',$dep);
                    return redirect()->back()->with('success','تم الحفظ');
                }
                else return redirect()->back()->with('error','عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return redirect()->back()->with('error','عفوا ليس لديك رصيد كافى ');
        }//end else

    }//end store

    public function addDepartment(Request $request){
        if($request->file('main_image')){
            $imageName = time().'.'.request()->main_image->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
        }
        $price=DepartmentMembership::where('id',$request->special)->first();
        $day = date('Y-m-d');
        $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
       // dd($NewDate);
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
        $new->item_end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + '.$price->duration.' days'));
        $new->save();

       /* if($request->images)
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
        }*/
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
            $item = \App\items::where('id',$request->id)->first();
            $data = $request->all();
            

        

        if($request->file('main_image')){
            $imageName = $request->en_name.'.'.request()->main_image->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
            $data['main_image']=$imageName;
        }
        $item->update($data);
       

       return redirect()->back()->with('success','تم التحديث بنجاح');
    }

    public function destroy($id){
        $item = \App\items::where('id',$id)->first();
        if($item->delete()){
            return back();
        }
        return back();
    }

    public function index(Request $request){
        $conditions = getItemsConditions();
        $items = \App\items::where($conditions)->paginate();
        $countries = country::where('status',1)->get();
        $viewcategories = \App\Categories::where('status',1)->get();

         if($request->isMethod('post'))
         {
             $membership = $request->input('membership');
             $order = $request->input('order');
             $search = $request->input('search');
             $filters = [];
             foreach ($request->all() as $filter => $value) {
                 if($filter != 'membership' && $filter != 'order' && $filter != 'search')
                     array_push($filters,[$filter,'=',$value]);
             }
             $items =  \App\items::where($filters);
            
             if(!is_null($search))
             {
             $columns =   Schema::getColumnListing('items');
             foreach ($columns as $column) {
                 $items->orWhere(function($q) use ($column,$search){
                     $q->where([[$column,'LIKE','%'.$search.'%']]);
                 });
             }
             $items->orWhereHas('user',function($q) use ($search){
                 $q->where([['name','LIKE','%'.$search.'%']]);
             });
             }
 
             if(!is_null($membership)) 
             $items->whereHas('membership',function($q) use ($membership){
                 $q->where('type',$membership);
             });
 
             if(!is_null($order))
             $items->orderBy(explode('-',$order)[0],explode('-',$order)[1]);
 
             $items =  $items->where($conditions)->paginate();
             return view('dashboard.items.table',compact('items','viewcategories','countries'));
         }
    
         return view('dashboard.items.index',compact('items','viewcategories','countries'));
     }

     
    public function itemChangeStatus(Request $request)
    {
        //\Log::info($request->all());
        $cat = items::find($request->brand_id);
        $cat->status = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }

    /*public function create(){

        $countries = country::where('status',1)->get();
        $viewcategories = \App\Categories::where('status',1)->get();
        return view('dashboard.items.create',compact('viewcategories','countries'));
    }*/
    
    public function renewItem(Request  $request){

        $ads= \App\items::findOrFail( $request->item_date_id);
        $days=$request->item_days;
      //  dd($balance);
        if(  auth()->user()->guard == 1 )
        {
        if (Date('Y-m-d')>$ads->end_ad_date) $date=Date('Y-m-d');
        else $date=$ads->end_ad_date;
        $ads->end_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        $ads->end_ad_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        $ads->save();
        return redirect()->back()->with('success','تم تجديد الاعلان بنجاح');
       }
        return redirect()->back()->with('error','لا يوجد رصيد كافي');
    }

    public function create()
    {
        $countries = country::where('status',1)->get();
        $viewcategories = \App\Categories::where('status',1)->get();
        $memberships = \App\DepartmentMembership::get();
        return view('dashboard.items.create',compact('viewcategories','memberships','countries'));
    }

 



}
