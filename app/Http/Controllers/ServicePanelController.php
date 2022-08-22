<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\NewServices;
use App\country;
use App\Cat;
use App\SubCat;
use App\NewServiceMembership;
use App\Balance;
use DB;

use App\ServiceImg;
use Illuminate\Support\Str;

use App\MiniSubCat;
use Illuminate\Http\Request;

class ServicePanelController extends Controller
{

	

  public function allService($lang = null)
  {
    $day = date('Y-m-d');
  	$rows=NewServices::where('user_id',auth()->user()->id)->paginate(12);
  	return view('Cdashboard.services',compact('rows','lang','day'));
  }

  public function addServices($lang = null)
  {
  	$countries=country::all();
  	$cats=Cat::where('status',1)->get();
  	$sub_cats=SubCat::where('status',1)->get();
  	$mini_subcat=SubCat::get();
  	return view('Cdashboard.add_service',compact('countries','lang','cats','sub_cats','mini_subcat'));
  	
  }//end addServices

   public function storeServices(Request $request)
  {  
 //dd($request->all());
    $request->validate([
             'country_id' => 'required|int',
             'cat_id' => 'required|int',
             //'sub_cat' => 'required|int',
             'special'=>'required|int|exists:service_membership,id',
             'ar_description' => 'required',
             'en_description' => 'required',
             'name_en' => 'required',
             'name_ar' => 'required',
             'image' => 'required|image|max:7000',
         ]);
        //dd($request->all());

        $user_id=auth()->user()->id;
        $balance=Balance::where('user_id',$user_id)->first();
        $price=NewServiceMembership::where('id',$request->special)->first();
        //dd($price);
        if ((isset($price) &&$price->price==0) || auth()->user()->guard == 1){
            $this->addService($request);
            return redirect()->back()->with('success','تم الحفظ');
        }
        else{

            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $service=$this->addService($request);
                  //  $days=$request->number_days;
                    $total=$price->price;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user_id,'out',$total,'service',$service);
                    return redirect()->back()->with('success','تم الحفظ');
                }
                else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
        }//end else


  }//end storeServices


  public function addService(Request $request)
  {

     $user = auth()->user();
        $user_id = $user->id;
        $price=NewServiceMembership::where('id',$request->special)->first();
        if($request->file('image')){
            $imageName = $request->en_description.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
        }
        $type=NewServiceMembership::where('id',$request->special)->first();
        $day = date('Y-m-d');
        $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        $service = new NewServices();
        $service->country_id = $request->country_id;
        $service->end_date = $NewDate;
        $service->start_date = $day;
        $service->cat_id = $request->cat_id;
         $service->name_ar = $request->name_ar;
          $service->name_en = $request->name_en;
        $service->sub_cat = $request->sub_cat;
        $service->ar_description = $request->ar_description;
        $service->en_description = $request->en_description;
        $service->price =$request->price;
        $service->image = $imageName;
        $service->user_id =  $user_id;
       $service->type =$type->type;
        if($request->gover_id !=null ){
            $service->gover_id = $request->gover_id;
        }
        if($request->mini_sub_cat !=null ){
            $service->mini_sub_cat = $request->mini_sub_cat;
        }      
        $service->save();

        if($request->images)
        {
            $files = $request->file('images');

            foreach($files as $file)
            {

                $newImage = new ServiceImg();
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads'), $imageName);

                $newImage->service_id = $service->id;
                $newImage->file = $imageName;
                $newImage->save();
            }
        }

        return $service->id;
    
  }

   public function editServices($id,$lang = null,$type=null)
  {
    $countries=country::all();
    $cats=Cat::where('status',1)->get();
    $sub_cats=SubCat::where('status',1)->get();
    $mini_subcat=SubCat::get();
    $row=NewServices::find($id);
  	return view('Cdashboard.update_service',compact('countries','lang','cats','sub_cats','mini_subcat','row','lang','type'));
  }//end editServices

   public function updateServices($id,Request $request)
  {
    //dd($request->all());
  	    $request->validate([
             'country_id' => 'required|int',
             'cat_id' => 'required|int',
             //'sub_cat' => 'required|int',
             'ar_description' => 'required',
             'en_description' => 'required',
             'name_ar' => 'required',
             'name_en' => 'required',
             'image' => 'sometimes:nullable|image|max:7000',
         ]);
        $row=NewServices::find($id);
        $row->update($request->except(['token','image','images']));
        if($request->file('image')){
            $imageName = $request->en_description.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $row->update(['image'=>$imageName]);
        }
        
         if($request->images)
        { $rows=ServiceImg::where('service_id',$id)->delete();
            $files = $request->file('images');
            foreach($files as $file)
            {
                $newImage = new ServiceImg();
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $imageName);
                $newImage->service_id = $id;
                $newImage->file = $imageName;
                $newImage->save();
            }
        }
        return redirect()->back()->with('success','تم الحفظ');
  }//end updateServices

   public function deleteServices($id)
  {
     if(!empty($id))
        {
            $row=NewServices::find($id);
            // dd($row);
            $row->delete();
            return redirect()->back()->with('success','تم الحذف');
        }
  	return redirect()->back()->with('success','هذا العنصر غير موجود');
  }//end deleteServices

   public function renewServices(Request $request)
  {
      $request->validate([
          'special'=>'required|int|exists:service_membership,id',
      ]);

      $ad=NewServices::find($request->ad);
      $price=NewServiceMembership::where('id',$request->special)->first();
      $day = date('Y-m-d');
      if ($ad->end_date<$day)
      $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
      else $NewDate = date('Y-m-d', strtotime($ad->end_date . " +".$price->duration." days"));
      $user_id=auth()->user()->id;
      $balance=Balance::where('user_id',$user_id)->first();

     // dd($NewDate);
      if (isset($price) &&$price->price==0){
         $ad->update(['end_date'=>$NewDate]);
          return redirect()->back()->with('success','تم تجديد الاعلان');
      }
      else{

          if (isset($balance)){
              if ($balance->balance >=$price->price){
                  $ad->update(['end_date'=>$NewDate]);
               //   $days=$request->number_days;
                  $total=$price->price;
                  $user_balance=$balance->balance - $total;
                  $balance->update(['balance'=>$user_balance]);
                  transaction($user_id,'out',$total,'service',$request->ad);
                  return redirect()->back()->with('success','تم الحفظ');
              }
              else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
          }//end isset
          else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
      }//end else

    
  }//end renewServices

  public function getSubCategoryList(Request $request)
  { 
  	$rows = DB::table("subCats")->where("cat_id",$request->sub_id)->where("status",1)
            ->pluck("name_ar","id");
           // dd($request->sub_id);
        return response()->json($rows);
  }

    public function getMiniSubCategoryList(Request $request){

        $rows = DB::table("miniSubCat")
            ->where("subCat_id",$request->sub_id)->pluck("name_ar","id");
        return response()->json($rows);

    }//end getCityList


  public function allServices($lang = null,Request $request)
  {  $services=new NewServices();
  //dd($request->all());
    $cats=Cat::where('status',1)->get();
    $sub_cats=SubCat::where('status',1)->get();
    $mini_subcat=SubCat::get();
    if ($request->cat_id && $request->cat_id>0) {
      $services=$services->where('cat_id',$request->cat_id );
    }
    if ($request->sub_cat) {
       
      $services=$services->where('sub_cat',$request->sub_cat );
    }
     if (isset($request->mini_sub_cat)) {
      $services=$services->where('mini_sub_cat',$request->mini_sub_cat );
    }
    $day = date('Y-m-d');
    $services=$services->orderBy('type','Desc')->where('status',1)->whereDate('end_date','>',$day)->paginate(18);

    return view('content.new_service',compact('services','lang','cats','sub_cats',
      'mini_subcat'));
  }

  public function ServiceDetails($id,$lang= null)
  {
    $service= NewServices::with('images')->where('id',$id)->first();

    $service->visitor = $service->visitor + 1;
    $service->save();
      return view('content.service_details',compact('service','lang'));
  }


}//end class