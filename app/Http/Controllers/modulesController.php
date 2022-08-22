<?php

namespace App\Http\Controllers;

use App\Cat;
use App\Cars;
use App\items;
use App\Price;
use Validator;
use App\brands;
use App\Notify;
use App\SubCat;
use App\Balance;
use App\country;
use App\Categories;
use App\MiniSubCat;
use App\ServiceImg;
use App\NewServices;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\NewServiceMembership;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class modulesController extends Controller
{

      public function __construct()
        {
            
           $this->middleware(['auth'])->except(['getSubCategoryList','getMiniSubCategoryList']);
        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  /*  public function index()
    {
     
        $rows = NewServices::where('status', 1)->orderBy('id','desc')->paginate();
        return view('dashboard.modules.index', compact('rows'));
    } //end index
*/
        public function watchAds($id){
        $ads=Notify::find($id)->forceDelete();
//        $ads->status=0;
//        $ads->save();
        return redirect()->back()->with('success','تم التحديث بنجاح');
        }//end watchAds

     public function editServices($id,$lang = null)
      {
        $countries=country::all();
        $cats=Cat::where('status',1)->get();
        $sub_cats=SubCat::where('status',1)->get();
        $mini_subcat=SubCat::get();
        $row=NewServices::find($id);
        return view('Cdashboard.update_service',compact('countries','lang','cats','sub_cats','mini_subcat','row','lang'));
      }//end editServices

    public function delete($id){
        $ads=NewServices::find($id);
         $ads->delete();
        // Cars::where('id',$ads->ads_id)->forceDelete();

        return redirect()->back()->with('success','تم حذف الاعلان بنجاح');
    }//end delete



    public function showItem(Request $request){
        
      $conditions = getNewServicesConditions();
     // dd($conditions);
       $items = \App\NewServices::where($conditions)->paginate();
       $countries = country::where('status',1)->get();
       $viewcategories = \App\Categories::where('status',1)->get();
        
        // $status = $request->param('status');
        // $type = $request->param('type');
        // $membership = $request->param('membership');
        // $country_id = $request->param('country_id');
        if($request->isMethod('post'))
        {
            $membership = $request->input('membership');
            $order = $request->input('order');
            $search = $request->input('search');
            $filters = getNewServicesConditions();;
            foreach ($request->all() as $filter => $value) {
                if( $filter != 'membership' && $filter != 'order' && $filter != 'search' && strlen($value))
                    array_push($filters,[$filter,'=',$value]);
            }
            $items =  \App\NewServices::where($filters);
           
            if(strlen($search))
            {
                //return print_r($filters);
            $items->where(function($q) use ($search){
                
            $q->orWhere([['name_en','LIKE','%'.$search.'%']]);
            $q->orWhere([['name_ar','LIKE','%'.$search.'%']]);
            
             $q->orWhereHas('users',function($u) use ($search){
                $u->where([['name','LIKE','%'.$search.'%']]);
              });
            });
            
              
             
            }

            if(strlen($membership)) 
             $items->whereHas('membership',function($q) use ($membership){
                $q->where('type','=',intval($membership));
            });
            
           //return $items->toSql();

            if(strlen($order))
            $items->orderBy(explode('-',$order)[0],explode('-',$order)[1]);
            
            $items = $items->where($filters);

            $items =  $items->paginate(12);
            return view('dashboard.modules.table',compact('items','viewcategories','countries'));
        }
   // dd($countries);
        return view('dashboard.modules.index',compact('items','viewcategories','countries'));
    }

   /* public function itemshow(){

        $countries = country::where('status',1)->get();
        $viewcategories = \App\Categories::where('status',1)->get();
        return view('dashboard.items.create',compact('viewcategories','countries'));
    }*/

    public function edit($id){

        $viewcategories = \App\Categories::where('status',1)->get();
        $countries = country::where('status',1)->get();
        $categories = Cat::where('status',1)->get();
        $sub_categories = SubCat::where('status',1)->get();
        $mini_categories = MiniSubCat::get();
        $ad = NewServices::where('id',$id)->first();
        return view('dashboard.modules.edit',compact('ad','viewcategories','countries','categories','sub_categories','mini_categories'));
    }

    public function update(Request $request)
    {
        $ad = NewServices::where('id',$request->id)->first();
        if(!empty($ad))
        {
            $request->validate([
                'name_ar'=>'required',
                'name_en'=>'required',

                'ar_description'=>'required',
                'en_description'=>'required',

                'cat_id'=>'required',
                'sub_cat'=>'required',

                'country_id'=>'required',
                'gover_id'=>'required',
                'city_id'=>'required',

                'type'=>'required|int|exists:service_membership,id',

                'price'=> 'required|numeric',
            ]);
            $this->storeAd($request,$request->id);
            return redirect()->back()->with('success','تم الحفظ');


        }else{
            return redirect()->back();
        }

    }

    public function create(){
        $viewcategories = \App\Categories::where('status',1)->get();
        $countries = country::where('status',1)->get();
        $categories = Cat::where('status',1)->get();
        $sub_categories = SubCat::where('status',1)->get();
        $mini_categories = MiniSubCat::get();
        return view('dashboard.modules.create',compact('viewcategories','countries','categories','sub_categories','mini_categories'));
    }

    public function store(Request $request){
         $request->validate([
                 'name_ar'=>'required',
                 'name_en'=>'required',

                 'ar_description'=>'required',
                 'en_description'=>'required',

                 'cat_id'=>'required',
                 'sub_cat'=>'required',

                 'country_id'=>'required',
                 'gover_id'=>'required',
                 'city_id'=>'required',

                 'type'=>'required|int|exists:service_membership,id',

                 'price'=> 'required|numeric',
                 'main_image'=> 'required|image|max:7000',
             ]);
            //  dd($request->all());
         $user_id=auth()->user()->id;
         $balance=Balance::where('user_id',$user_id)->first();
        // $price=Price::where('id',$request->type)->first();
         $price=NewServiceMembership::where('id',$request->type)->first();
            if((floatval($price->price) == 0) || auth()->user()->guard == 1)
            {
               $this->storeAd($request);
               return redirect()->back()->with('success','تم الحفظ');
            }else
             if (isset($balance) && isset($price) && floatval($balance->balance) >= floatval($price->price) ){
                     $tx = $this->storeAd($request);
                     $total=$price->price;
                     $user_balance=$balance->balance - $total;
                     $balance->update(['balance'=>$user_balance]);
                     transaction($user_id,'out',$total,'department',$tx);
                     return redirect()->back()->with('success','تم الحفظ');
                 
             }//end isset
              return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
         
 
     }//end store
 
     public function storeAd(Request $request,$id = null){

        if(!$id)
        $ad = new NewServices();
        else
        $ad = NewServices::where('id',$id)->first();

        if($request->file('main_image')){
             $imageName = time().'.'.request()->main_image->getClientOriginalExtension();
             request()->main_image->move(public_path('uploads'), $imageName);
             $ad->image = $imageName;
         }
         $price=NewServiceMembership::where('id',$request->type)->first();

         if(empty($ad->start_date))
         $ad->start_date = date('Y-m-d');

         $NewDate = date('Y-m-d', strtotime($ad->start_date . " +".$price->duration." days"));

         $ad->user_id = auth()->user()->id;
         
         $ad->status = 1;
         $ad->end_date = $NewDate;
         $ad->visitor = 0;
         $ad->cat_id = $request->cat_id;
         $ad->sub_cat= $request->sub_cat;
         $ad->mini_sub_cat= $request->mini_sub_cat;
         $ad->country_id= $request->country_id;
         $ad->gover_id= $request->gover_id;
         $ad->city_id= $request->city_id;
         $ad->name_ar= $request->name_ar;
         $ad->name_en= $request->name_en;
         $ad->ar_description= $request->ar_description;
         $ad->en_description= $request->en_description;
         $ad->price= $request->price;
         $ad->type= $request->type;

         
         $ad->save();
       
 
         if($request->images)
         {
             ServiceImg::where('service_id',$ad->id)->delete();
             $files = $request->file('images');
 
             foreach($files as $file)
             {
 
                 $newImage = new \App\ServiceImg();
                 $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                 $file->move(public_path('uploads'), $imageName);
 
                 $newImage->service_id = $ad->id;
                 $newImage->file = $imageName;
                 $newImage->save();
             }
         }
         return true;
     }
 

    public function itemChangeStatus(Request $request)
    {  
        //\Log::info($request->all());
        $cat = NewServices::find($request->brand_id);
        $cat->status = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus

   public function renewItem(Request $request)
  {
       $ads= NewServices::findOrFail( $request->item_date_id);
        $days=$request->item_days;
        if (Date('Y-m-d')>$ads->end_date) $date=Date('Y-m-d');
        else $date=$ads->end_date;
        $ads->end_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        // $ads->end_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        $ads->save();
        return redirect()->back()->with('success','تم تجديد الاعلان بنجاح');
      

    
  }//end renewServices

  public function getSubCategoryList(Request $request)
  { 
  	$rows = SubCat::where("cat_id",$request->id)->where("status",1)
            ->get();
        return response()->json($rows);
  }

    public function getMiniSubCategoryList(Request $request){

        $rows = MiniSubCat::where("subCat_id",$request->id)->get();
        return response()->json($rows);
    }

}//end class
