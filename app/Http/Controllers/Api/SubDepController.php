<?php

namespace App\Http\Controllers\Api;

use App\Balance;
use App\Booking;
use App\DepartmentMembership;
use App\Http\Controllers\Controller;
use App\items;
use DB;
use App\Price;
use App\Traits\GeneralTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;


class SubDepController extends Controller
{
    use GeneralTrait;

    public function getAllSubCat(){
        $user=auth()->guard('api')->user()->id;
        $items = \App\items::with(['category:id,'.lang().'_name as name','country:id,'.lang().'_name as name'])->
        where('user_id',$user)->select('id',lang().'_name as name','price',
        'main_image','visitors','discount','category_id','country_id')->get();
        return $this->returnData('items',$items);
    }//end getAllSubCat

    public function addSub(Request  $request){
        $rules=[
            'ar_name'=>'required',
            'en_name'=>'required',
            'ar_desciption'=>'required',
            'en_description'=>'required',
            'category_id'=>'required|exists:categories,id',
            'country_id'=>'required|exists:countries,id',
            'special'=>'required|exists:departmentmemberships,id',
            'discount'=>'required',
            'dicount_percent'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'price'=> 'required|numeric',
            'images'=> 'required|array',
            'main_image'=> 'required|image|max:7000',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        try {
            $user_id = auth()->guard('api')->user()->id;
            $balance = Balance::where('user_id', $user_id)->first();
            $price = DepartmentMembership::where('id', $request->special)->first();
            if ((isset($price) && $price->price == 0 || auth()->user()->guard == 1)) {
                $this->addDepartment($request);
                return $this->returnSuccessMessage('success');
            } else {
                if (isset($balance)) {
                    if ($balance->balance >= $price->price) {
                        $dep = $this->addDepartment($request);
                       // $days = $request->number_days;
                        $total = $price->price;
                        $user_balance = $balance->balance - $total;
                        $balance->update(['balance' => $user_balance]);
                        transaction($user_id, 'out', $total, 'department', $dep);
                        return $this->returnSuccessMessage('success');
                    } else return $this->returnError(99, 'عفوا ليس لديك رصيد كافى');
                }//end isset
                else return $this->returnError(99, 'عفوا ليس لديك رصيد كافى');
            }//end else
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end catch

    }//end addSub

    function addDepartment(Request $request){
        if($request->file('main_image')){
            $imageName = Str::random(8).'.'.$request->file('main_image')->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
        }
        $day = date('Y-m-d');
        $price = DepartmentMembership::where('id', $request->special)->first();
        $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        $new = new \App\items();
        $new->category_id = $request->category_id;
        $new->country_id = $request->country_id;
        $new->user_id = auth()->guard('api')->user()->id;
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

    public function getSubCat($id){
        $row=items::with(['category:id,'.lang().'_name as name','country:id,'.lang().'_name as name','images:id,item_id,image'])
            ->where('id',$id)->get();
        return $this->returnSuccessMessage('row',$row);
    }//end getSubCat

    public function updateSubCat(Request  $request){
        $rules=[
            'id'=>'required|exists:items,id',
            'ar_name'=>'required',
            'en_name'=>'required',
            'ar_desciption'=>'required',
            'en_description'=>'required',
            'category_id'=>'required|exists:categories,id',
            'country_id'=>'required|exists:countries,id',
            //'special'=>'required|exists:prices,id',
            'discount'=>'required',
            'dicount_percent'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'price'=> 'required|numeric',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        try {
        $user_id = auth()->guard('api')->user()->id;
        $new = \App\items::where('id',$request->id)->first();
        $new->category_id = $request->category_id;
        $new->country_id = $request->country_id;
        $new->user_id = $user_id;
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
        //$new->special = 1;
      //  $new->visitors = 0;
        $new->item_end_date = date('Y-m-d', strtotime(Date('Y-m-d'). ' + 30 days'));;

        if($request->file('main_image')){
            $imageName = Str::random(8).'.'.$request->file('main_image')->getClientOriginalExtension();
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
        return $this->returnSuccessMessage('success');
            }catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end catch
    }//end fun

    public function delete($id){
        $user_id = auth()->guard('api')->user()->id;
        $row=items::where(['id'=>$id,'user_id'=>$user_id])->first();
        if ($row){
            $row->forceDelete();
            return $this->returnSuccessMessage('success');
        }else return $this->returnError(99,'this item not found');
    }

    public function showOrders(){
        $user_id = auth()->guard('api')->user()->id;
       $rows= Booking::where('owner_id',$user_id)->get();
        return $this->returnData('rows',$rows);
    }

    public function showOrder($id){
        $user_id = auth()->guard('api')->user()->id;
        $rows= Booking::with('cars:id,'.lang().'_name as name')->where('id',$id)->first();
        return $this->returnData('rows',$rows);
    }

    public function deleteOrder($id){
        $user_id = auth()->guard('api')->user()->id;
        $row=Booking::where(['id'=>$id])->first();
        if ($row){
            $row->forceDelete();
            return $this->returnSuccessMessage('success');
        }else return $this->returnError(99,'this item not found');
    }


    public function renewDepartement(Request  $request){
        $rules=[
            'id'=>'required|exists:items,id',
            'special'=>'required|exists:departmentmemberships,id',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $ad=items::find($request->id);
        //dd($ad);
        $price=DepartmentMembership::where('id',$request->special)->first();
        $day = date('Y-m-d');
        if ($ad->end_ad_date<$day)
            $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        else $NewDate = date('Y-m-d', strtotime($ad->end_ad_date . " +".$price->duration." days"));
        $user_id=auth()->guard('api')->user()->id;
        $balance=Balance::where('user_id',$user_id)->first();

        // dd($NewDate);
        if (isset($price) &&$price->price==0){
//            $ad->update(['end_ad_date'=>$NewDate]);
            DB::table('items')->where('id', $request->id)->update(['end_ad_date'=>$NewDate,'item_end_date'=>$NewDate]);
            return $this->returnSuccessMessage('success');
        }
        else{

            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    // dd($NewDate);
                    DB::table('items')->where('id', $request->id)->update(['end_ad_date'=>$NewDate,'item_end_date'=>$NewDate]);
                    //   $ad->update(['end_ad_date'=>'2021-06-22','item_end_date'=>$NewDate]);
                    $total=$price->price;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user_id,'out',$total,'car',$request->id);
                    return $this->returnSuccessMessage('success');
                }
                else return $this->returnError(99,'عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return $this->returnError(99,'عفوا ليس لديك رصيد كافى ');
        }//end else

    }
}//end class
