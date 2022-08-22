<?php

namespace App\Http\Controllers\Api;

use App\Agents;
use App\Booking;
use App\Cars;
use App\Http\Controllers\Controller;
use App\Notify;
use App\Token;
use App\Traits\GeneralTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;

class CarController extends Controller
{
    use GeneralTrait;

    public function cars($country=0,$type)
    {
        $day = date('Y-m-d');
        $cars = Cars::with('memberships','country:id,'.lang().'_name  as name,'.lang().'_currency as currency,'.lang().'_code as code')
               ->with('Price:id,car_id,cost,discount_start_date,discount_amount,discount_percent,discount_end_date')
               ->where(['status'=>1])->where('end_ad_date','>',$day);
        if ($country !=0) $cars=$cars->where('country_id',$country);
        $cars = $cars->whereHas('agents', function($q) use ($type) {
         $q->where(['agents.agent_type'=>$type,'status'=>1]);
        })->select($this->arr())->orderBy('id','desc')->paginate(24);

        return $cars;
    }

    public function carsNew($country=0,$type,$status,Request  $request){
        $day = date('Y-m-d');
//        $cars = Cars::with('memberships','country:id,'.lang().'_name  as name,'.lang().'_currency as currency,'.lang().'_code as code')
//               ->with('Price:id,car_id,cost,discount_start_date,discount_amount,discount_percent,discount_end_date')
//               ->where(['status'=>1])->where('end_ad_date','>',$day);
//        if ($country !=0) $cars=$cars->where('country_id',$country);
//        $cars = $cars->whereHas('agents', function($q) use ($type) {
//         $q->where(['agents.agent_type'=>$type,'status'=>1]);
//        })->select($this->arr())->orderBy('id','desc')->paginate(24);


        $cars=Cars::join('ads_membership', 'cars.special', '=', 'ads_membership.id')
            ->join('agents', 'cars.agent_id', '=', 'agents.id')
            ->join('car_prices', 'cars.id', '=', 'car_prices.car_id')
            ->join('countries', 'cars.country_id', '=', 'countries.id')
            ->where(['cars.status'=>1]);
        if ($status=='0') $cars=$cars->where('cars.rent_type',$status);
        elseif ($status=='1') $cars=$cars->whereIn('cars.rent_type',['1','2','3','4']);
        $cars=$cars->where(['agents.agent_type'=>$type,'agents.status'=>1])
               ->where('cars.end_ad_date','>',$day);

             if ($request->brand_id){
                 $cars=$cars->where('cars.ar_brand',$request->brand_id);
             }
        if ($request->model_id){

            $cars=$cars->where('cars.en_model',$request->model_id);
        }
        if ($request->year){
            $cars=$cars->where('cars.year',$request->year);
        }
            $cars=$cars->orderBy('ads_membership.type', 'desc')->select($this->arrNew());
       // if (getCountry() !=0) $cars=$cars->where('cars.country_id',getCountry());
       return $cars->paginate(24);
      //dd($cars->get());
    }

    public function arrNew(){
        $arr=array('cars.id','cars.'.lang().'_name  as name','cars.country_id','color',lang().'_features  as features',
            'fuel','max','engine','cars.special','cars.kilo_meters','cars.used',lang().'_description  as description','main_image',
            'cars.visitors','year','cars.discount_percent','cars.rent_type','cars.agent_id','cars.ar_brand','cars.end_ad_date','cars.ar_model','cars.created_at'
        ,'ads_membership.type','ads_membership.name_'.lang().' as ads_name',
            'car_prices.cost','car_prices.discount_amount','car_prices.discount_percent','car_prices.discount_start_date',
            'car_prices.discount_end_date','countries.'.lang().'_name  as country_name','countries.'.lang().'_currency as currency',
            'countries.'.lang().'_code as code');
        return $arr;
    }

   public function carSale(Request  $request){
        if ($request->country_id) $cars=$this->carsNew($request->country_id,0,'0',$request);
        else $cars=$this->carsNew('',0,'0',$request);
       return $this->returnData('cars',$cars);
   }//end carSale

    public function getResult(Request  $request){
        $day = date('Y-m-d');
        $cars=Cars::with('country:id,'.lang().'_name  as name,'.lang().'_currency as currency,'.lang().'_code as code')
            ->with('Price:id,car_id,cost,discount_start_date,discount_amount,discount_percent,discount_end_date')
            ->where(['status'=>1])->where('end_ad_date','>',$day);
        if ($request->country_id !=0) $cars=$cars->where('country_id',$request->country_id );
        if ($request->agent_id && $request->agent_id>0) $cars=$cars->where('agent_id',$request->agent_id);

        if ($request->brand_id){
            $cars=$cars->where('ar_brand',$request->brand_id);
        }
        if ($request->model_id){
            $cars=$cars->where('en_model',$request->model_id);
        }
        if ($request->year){
            $cars=$cars->where('year',$request->year);
        }
        return $cars;

    }//end getResult

    public function carSaleSearch(Request  $request){
        $rules=[
            'car_type'=>'sometimes:nullable|in:0,1,2',
            'agent_id'=>'sometimes:nullable|exists:agents,id',
            'brand_id'=>'sometimes:nullable|exists:brands,id',
            'model_id'=>'sometimes:nullable|exists:models,id',
            'year'=>'sometimes:nullable|integer',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
//        $cars=$this->getResult($request);
//        if (isset($request->car_type)&&$request->car_type!=2) {
//            $type=$request->car_type;
//            $cars=$cars->where('used',$type);
//        }
//
//        $cars=$cars->whereHas('agents', function($q) {
//            $q->where('agents.status',1);   })
//            ->where('status',1)->where('rent_type','0')
//            ->select($this->arr())->orderBy('id','desc')->paginate(24);
        if ($request->country_id) $cars=$this->carsNew($request->country_id,0,'0',$request);
        else $cars=$this->carsNew('',0,'0',$request);
        // dd($cars);
        return $this->returnData('cars',$cars);
    }//end searchCar

    public function carRentSearch(Request  $request){
        $rules=[
            'car_type'=>'sometimes:nullable|in:1,2,3,4',
            'agent_id'=>'sometimes:nullable|exists:agents,id',
            'brand_id'=>'sometimes:nullable|exists:brands,id',
            'model_id'=>'sometimes:nullable|exists:models,id',
            'year'=>'sometimes:nullable|integer',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
//        $cars=$this->getResult($request);
//        $cars=$cars->where(['status'=>1]);
//        if ($request->has('car_type')){
//            $cars=$cars->where('rent_type',$request->car_type);
//        }
//        $cars=$cars->whereIn('rent_type',['1','2','3','4']);
//        $cars=$cars->whereHas('agents', function($q)
//        {$q->where('agents.status',1);})
//            ->select($this->arr())->orderBy('id','desc')->paginate(24);
        if ($request->country_id) $cars=$this->carsNew($request->country_id,1,'1',$request);
        else $cars=$this->carsNew('',1,'1',$request);
        // dd($cars);
        return $this->returnData('cars',$cars);
    }//end carRentSearch

    public function carRent(Request  $request){
        if ($request->country_id) $cars=$this->carsNew($request->country_id,1,'1',$request);
        else $cars=$this->carsNew('',1,'1',$request);
        // dd($cars);
        return $this->returnData('cars',$cars);
    }//

    public function ads(Request  $request){
        if ($request->country_id) $cars=$this->carsNew($request->country_id,2,'0',$request);
        else $cars=$this->carsNew('',2,'0',$request);
        return $this->returnData('cars',$cars);
    }//end ads

  public function Searchads(Request  $request){
      $rules=[
          'car_type'=>'sometimes:nullable|in:0,1,2',
          'agent_id'=>'sometimes:nullable|exists:agents,id',
          'brand_id'=>'sometimes:nullable|exists:brands,id',
          'model_id'=>'sometimes:nullable|exists:models,id',
          'year'=>'sometimes:nullable|integer',
      ];
      $validator=Validator::make($request->all(),$rules);
      if($validator->fails()){
          $code=$this->returnCodeAccordingToInput($validator);
          return $this->returnValidationError($code,$validator);
      }
//      $cars=$this->getResult($request);
//      if (isset($request->car_type)&&$request->car_type!=2) {
//          $type=$request->car_type;
//          $cars=$cars->where('used',$type);
//      }
//
//      $cars=$cars->whereHas('agents', function($q) {
//          $q->where('agents.status',1);   })
//          ->where('status',1)
//          ->select($this->arr())->orderBy('id','desc')->paginate(24);
      if ($request->country_id) $cars=$this->carsNew($request->country_id,2,'0',$request);
      else $cars=$this->carsNew('',2,'0',$request);
      return $this->returnData('cars',$cars);
      return $this->returnData('cars',$cars);
    }//end Searchads

    public function arr(){
       $arr=array('id',lang().'_name  as name','country_id','color',lang().'_features  as features',
                'fuel','max','engine','special','kilo_meters','used',lang().'_description  as description','main_image',
                'visitors','year','discount_percent','rent_type','agent_id','ar_brand','end_ad_date','ar_model','created_at');
       return $arr;
    }


    public function carDetails($id){
      $car=Cars::with(['agents:id,'.lang().'_name as name,phones,user_id','model:id,name',
          'brand:id,name','Images','country:id,'.lang().'_name  as name,'.lang().'_currency as currency'])
          ->with('Price:id,car_id,cost,discount_start_date,discount_amount,discount_percent,discount_end_date')
          ->where('id',$id)->select($this->arr())->first();
      if ($car){
          $car->visitors = $car->visitors + 1;
          $car->save();
      }
      return $this->returnData('car',$car);
    }//end car

    public function adsNotify(Request  $request){
        try{
            $rules=[
                'car_id' => 'required|min:0',
            ];
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails()){
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
            $row=new Notify();
            $row->ads_id=$request->car_id;
            $row->status=1;
            $row->save();
        }//end try
        catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach

        return $this->returnData('car','تم تبليغ الادارة');
    }//end userNotify


    public function allAgencyCars($id,Request  $request){
            $agant=Agents::find($id);
            $cars=Cars::with('agents:id,'.lang().'_name as name ,phones,car_type,instagram,twitter_page,fb_page,'.lang().'_address as address ',
                'country:id,'.lang().'_name  as name,'.lang().'_currency as currency,'.lang().'_code as code');
            if ($request->country_id) $cars=$cars->where('country_id',$request->country_id);
            $cars=$cars->whereHas('agents', function($q) {
                $q->where('agents.status',1);
            })->where('agent_id',$id)->select($this->arr())->paginate('24');

          return $this->returnData('cars',$cars);
    }

    public function booking(Request  $request){
       try{
            $rules=[
                'name'=>'required|max:200',
                'from_date'=>'required|date',
                'to_date'=>'required|date|after:from_date',
                'address'=>'required',
                'car_id'=>'required|int|min:1',
                'phone'=>'required|max:20',
            ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $car=Cars::find($request->car_id);
        if ($car) {
            $owner = $car->agents->owner;
         //  dd($owner);
            $mail = $owner->email;
            $user = Auth::guard('api')->user();
            $owner_id = $owner->id;

            $book = Booking::create($request->all() + ['user_id' => $user->id, 'owner_id' => $owner_id]);
            $phone = $request->phone;
            $name = $request->name;
            $msg = "You have New request for your car ";
            $email = $user->email;
            $token=Token::where('user_id',$owner_id)->select('token')->get();
//            Mail::send([], [], function ($message) use ($email, $name, $phone, $mail, $msg) {
//                $message->to($mail, 'New Message')->subject
//                ('New Request')// here comes what you want
//                ->setBody(
//                    '<h4> you have new Request from :  ' . $name . '  </h4> <p> Phone :  ' . $phone . ' </p>
//                    <p>Email:' . $email . '</p>
//                    <p>Message : ' . $msg . '</p>', 'text/html'); // assuming text/plain
//                $message->from('info@tameenistore.com', 'New Request');
//            });
            return $this->returnData('token', $token);
        }else return $this->returnError('s1111','هذا العنصر غير موجود ');
        }//end try
        catch (\Exception $e){
        return $this->returnError('s1110','حدثت مشكله يرجى المحاوله مرة اخرى');
        }

    }//end booking

}//end class
