<?php

namespace App\Http\Controllers\Api;

use App\AdsMembership;
use App\Agents;
use App\Balance;
use App\CarHolder;
use App\carImages;
use App\carPrices;
use App\Cars;
use App\country;
use App\DocumentsUser;
use App\Exhibition;
use App\Http\Controllers\Controller;
use App\Price;
use App\Traits\GeneralTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;


class AgentController extends Controller
{
    use GeneralTrait;
    public function uploadUserDocuments(Request  $request){
        // dd($request->all());
        try{
            $rules=[
            'company_name'=>'required|min:3|max:100',
            'license_number'=>'required|int',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
                'license_image' => 'sometimes:nullable|image|max:5000',
                'id_image' => 'sometimes:nullable|image|max:5000',
            ];
            $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
        $user=auth()->guard('api')->user()->id;
        $arr=[
            'user_id'=>$user,
            'company_name'=>$request->company_name,
            'license_number'=>$request->license_number,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
//            'license_image'=>$license_image,
//            'id_image'=>$id_image,
        ];
        $row=DocumentsUser::where('user_id',$user)->first();
            if ($request->license_image){
                $license_image = uploadImage($request->license_image);
                if ($row) $row->license_image=$license_image;
            }
            if ($request->id_image) {
                $id_image = uploadImage($request->id_image);
                if ($row)  $row->id_image=$id_image;
            }
        if ($row) {
            $row->update($arr);
            $row->save;
        }
        else $insert=DocumentsUser::create($arr+['license_image'=>$license_image,'id_image'=>$id_image]);

//            $insert->save();
        return $this->returnSuccessMessage('success');
        }
        catch(\Exception $ex){
                return $this->returnError($ex->getCode(),$ex->getMessage());
            }//end cach
    }//end fun

    public function showUserAds(){
        $user=auth()->guard('api')->user()->id;
        $carHolder = CarHolder::where('is_user',$user)->get();
        $cars = Cars::with(['Price:id,car_id,currency,cost','brand:id,name',
            'country:id,'.lang().'_name as name'])->whereIn('id',$carHolder
            ->pluck('car_id'))->select('id',lang().'_name as name','ar_brand','end_date','visitors',
            'country_id','main_image',lang().'_description as description','max','year','kilo_meters')->get();
        return $this->returnData('ads',$cars);
    }//end showUswerAds

    public function getUserAd($id){
        $car=Cars::with(['country:id,'.lang().'_name as name','Price','brand:id,name',
           'Images','model:id,name'])->where('id',$id)
            ->first();
        return $this->returnData('car',$car);
    }//end getUserAd

    public function addCar(Request  $request){
        $user=auth()->guard('api')->user();
        $user_id = $user->id;
        $agent_id = Agents::where('user_id', $user_id)->first()->id;
        $membership = \App\membership::where('id',auth()->guard('api')->user()->membership_id)->first();
        $price=AdsMembership::where('id',$request->special)->first();
        if($request->file('main_image')){
            $imageName = $request->en_name.'.'.request()->main_image->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
        }
        $day = date('Y-m-d');
        $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        $car = new Cars();
        $car->en_name = $request->en_name;
        $car->ar_name = $request->ar_name;
        $car->end_ad_date = $NewDate;
        $car->ar_model = $request->ar_model;
        $car->en_model = $request->ar_model;
        $car->ar_brand = $request->ar_brand;
        $car->main_image = $imageName;
        $car->agent_id =  $agent_id;
       // $car->category_id = $request->category_id;
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
        $car->end_date = '';
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

        return $car->id;
    }

    public function AddNewAd(Request  $request){
        try {
            $rules=$this->rules();
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $user_id = auth()->guard('api')->user()->id;
            $balance = Balance::where('user_id', $user_id)->first();
            $price = AdsMembership::where('id', $request->special)->first();

            if ((isset($price) && $price->price == 0) || auth()->user()->guard == 1) {
                $this->addCar($request);
                return $this->returnSuccessMessage('success');
            } else {

                if (isset($balance)) {
                    if ($balance->balance >= $price->price) {
                        $car = $this->addCar($request);
                      //  $days = $request->number_days;
                        $total = $price->price ;
                        $user_balance = $balance->balance - $total;
                        $balance->update(['balance' => $user_balance]);
                        transaction($user_id, 'out', $total, 'car', $car);
                        return $this->returnSuccessMessage('success');
                    } else return $this->returnError(99, 'عفوا ليس لديك رصيد كافى');
                }//end isset
                else return $this->returnError(99, 'عفوا ليس لديك رصيد كافى');
            }//end else
        } catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
    }//end AddNewAd

    public function updateAd(Request  $request){
        try {
        $rules=$this->rules();
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $user_id = auth()->guard('api')->user()->id;
        $car =  Cars::where('id',$request->id)->first();
        $car->rent_type = $request->rent_type;
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
      // $car->special = $request->special;
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
                foreach ($olds as $key => $old) {
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

        $Agent = Agents::where('user_id',$user_id)->first();
        $Exhibitor = Exhibition::where('user_id',$user_id)->first();
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
             return  $this->returnSuccessMessage('success');}
        catch(\Exception $ex){
        return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
    }//end updateAd


    public function rules(){
        $rules = [
            'country_id' => 'required|exists:countries,id',
            'ar_brand' => 'required|int|exists:brands,id',
            'ar_model' => 'required|int|exists:models,id',
          //  'number_days' => 'required|int|min:1',
            'ar_name' => 'required',
            'main_image' => 'sometimes:nullable|image|max:7000',
            'en_name' => 'required',
            'ar_description' => 'required',
            'en_description' => 'required',
            'images' => 'sometimes:nullable|array|min:1',
            'cost' => 'required|integer',
            'discount_amount' => 'required|integer',
            'discount_percent' => 'required|integer',
            'discount_start_date' => 'required|date',
            'discount_end_date' => 'required|date|after:discount_start_date',
            'fuel' => 'required',
            'year' => 'required|int',
            'color' => 'required',
            'used' => 'required|integer|in:0,1',
            'special' => 'required|integer|exists:ads_membership,id',
            'en_features' => 'required',
            'ar_features' => 'required',
            'sell' => 'required|integer|in:0,1',
            'talap' => 'required|integer|in:0,1',
            'transmission' => 'required|integer|in:0,1',
            'rent_type' => 'required|integer|in:0,1,2,3,4',
            'kilometers' => 'required|integer',
            'maxSpeed' => 'required|integer',
            'engine' => 'required|integer',
        ];
        return $rules;
    }

    public function membership(){
        $rows=Price::select('id','name_'.lang() .' as name','price')->get();
        return $this->returnData('rows',$rows);
    }//end membership

    public function deleteAd($id){
        $row=Cars::find($id);
        if ($row){
            $row->forceDelete();
            return $this->returnSuccessMessage('success');
        }
        else return $this->returnError(99,'this item not found');


    }//end deleteAd



    public function renewAd(Request  $request){
        $rules=[
            'id'=>'required|exists:cars,id',
            'id'=>'required|exists:ads_membership,id',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
    }
    public function renewAdsFromBalance(Request  $request){
            $rules=[
                'id'=>'required|exists:cars,id',
                'special'=>'required|exists:ads_membership,id',
            ];
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails()){
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
        $ad=Cars::find($request->id);
        $price=AdsMembership::where('id',$request->special)->first();
        $day = date('Y-m-d');
        if ($ad->end_ad_date<$day)
            $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        else $NewDate = date('Y-m-d', strtotime($ad->end_ad_date . " +".$price->duration." days"));
        $user_id=auth()->guard('api')->user()->id;
        $balance=Balance::where('user_id',$user_id)->first();

        //dd($price);
        if (isset($price) &&$price->price==0){
            $ad->update(['end_ad_date'=>$NewDate]);
            return $this->returnSuccessMessage('success');
        }
        else{

            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $ad->update(['end_ad_date'=>$NewDate]);
                    //   $days=$request->number_days;
                    $total=$price->price;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user_id,'out',$total,'car',$request->id);
                    return $this->returnSuccessMessage('success');
                }
                else return $this->returnError(99,'عفوا ليس لديك رصيد كافى');
            }//end isset
            else return $this->returnError(99,'عفوا ليس لديك رصيد كافى');
        }//end else

    }
}//end class
