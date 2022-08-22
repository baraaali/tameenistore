<?php

namespace App\Http\Controllers\Api;

use App\AdsMembership;
use App\Agents;
use App\brands;
use App\Cars;
use App\DepartmentMembership;
use App\User;
use App\Website;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Categories;
use App\country;
use App\Http\Controllers\Controller;
use App\items;
use App\models;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;

class MainController extends Controller
{
    use GeneralTrait;

    public function home(Request  $request){
        $lang=app()->getlocale();
        $date=$day = date('Y-m-d');
        $country=$request->country_id;
        if ($country){
            $golden = getCarsApi(3,$country);
            $special = getCarsApi(1,$country);
            $silver =getCarsApi(2,$country);
            $normal = getCarsApi(0,$country);

        }
        else{
            $golden = getCarsApi(3);
            $special = getCarsApi(1);;
            $silver =  getCarsApi(2);
            $normal =  getCarsApi(0);

        }
        //items
        $items=items::with('category:id,'.lang().'_name as name')->
        with('country:id,'.lang().'_name as name')->where(['status'=>1]);
        if (getCountry() !=0) $items=$items->where('country_id',getCountry());
        $items=$items->whereHas('user', function($q) {
            $q->where('block',1);
        });

        if($country){
            $items=$items->where('country_id',$country);
        }

        $items=$items->select('id','category_id','country_id',lang().'_name as name','visitors','price',
            'created_at','main_image','discount','user_id')
            ->get();

        //partners

        $messages = \App\CompleteDoc::where(['status'=>1,'display'=>1,'search_show'=>1]);
        if ($country) $messages=$messages->where('country_id',$country);
        $messages=collect($messages->get());
        $banners = $messages->unique('Insurance_Company_ar');

        //$banners->values()->all();
        $partners = array();
        foreach($banners as $banner) {
            $partners[] = $banner->logo;
        }
        //  $banners->select()->get();


        return $this->returnData('home',['golden'=>$golden,'special'=>$special,'silver'=>$silver,'normal'=>$normal,'partners'=>$partners,'items'=>$items]);
    }//end home
    //start countries-----------------------------
    public function countries(){

        $countries=country::where(['parent'=>0,'status'=>1])->
        select('id',lang().'_name as name',lang().'_code as code',lang().'_currency as currency','image')->get();

        return $this->returnData('countries',$countries);
    }//end country
    public function countriesWithCities(){
        $countries=country::with('children:id,'.lang().'_name as name')->where(['parent'=>0,'status'=>1])->
        select('id',lang().'_name as name,',lang().'_code as code',lang().'_currency as currency','image')->get();
        return $this->returnData('countries',$countries);
    }//end country
    public function country($country_id){
        $country=country::where(['id'=>$country_id,'status'=>1])->
        select('id',lang().'_name as name',lang().'_code as code',lang().'_currency as currency','image')->first();
        return $this->returnData('country',$country);
    }//end country
    public function countryWithCity($country_id){
        $country=country::with('children:id,'.lang().'_name as name')->where(['id'=>$country_id,'status'=>1])->
        select('id',lang().'_name as name',lang().'_code as code',lang().'_currency as currency','image')->first();
        return $this->returnData('country',$country);
    }//end country
    //end countries-----------------------------
    ///start cats---------------------
    public function categories(){
        $categories=Categories::where(['status'=>1])->
        select('id',lang().'_name as name')->get();
        return $this->returnData('categories',$categories);
    }//end categories

    public function searchDepartment(Request $request)
    {
        $rules=[
            'start_price'=>'sometimes:nullable|int',
            'end_price'=>'sometimes:nullable|int',
            'category'=>'sometimes:nullable',
            'country_id'=>'sometimes:nullable|exists:countries,id',
            'name'=>'sometimes:nullable',
        ];

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $items = items::with('images:id,image,item_id','country:id,'.lang().'_name as name,'.lang().'_currency as currency,'.lang().'_code as code')->where(['status' => 1]);
        if (isset($request->category)){
            if ($request->category != 0) $items = $items->where(['category_id' => $request->category]);
        }
//        dd($request->start_price);
        if ($request->country !=0) $items=$items->where('country_id',$request->country );
        if ($request->start_price) $items=$items->where('price','>=',intval($request->start_price));
        if ($request->end_price) $items=$items->where('price','<=',intval($request->end_price));
        if ($request->name) $items=$items->where('ar_name', 'like', '%' .$request->name. '%')->
        orWhere('en_name', 'like', '%' . $request->name. '%');
        $items=$items->whereHas('user', function($q)
        {$q->where('block',1);})->select('id',lang().'_name as name',lang().'_desciption as description','price','discount',
            'visitors','country_id','category_id')->paginate(28);
   return $this->returnData('items',$items);
    }


    public function allDepartments(Request  $request){
        $day = date('Y-m-d');
        $items=items::with('country:id,'.lang().'_name as name,'.lang().'_currency as currency,'.lang().'_code as code')->where(['status'=>1]);
        if ($request->country_id !=0) $items=$items->where('country_id',$request->country_id );
        $items=$items->whereHas('user', function($q) {
            $q->where('block',1);})
            ->where('end_ad_date','>',$day)
            ->select('id',lang().'_name as name','en_description','main_image','ar_desciption','price','discount',
                'visitors','country_id','category_id','end_ad_date')->paginate(28);
        foreach ($items as $item){
            $item->description=lang()=='ar'?$item->ar_desciption:$item->en_description;
        }

        return $this->returnData('departments',$items);
    }
    public function department($category_id){
        $item=\App\items::with('user:id,name,email','country:id,'.lang().'_name as name,'.lang().'_currency as currency,'.lang().'_code as code')
            ->where(['status'=>1,'category_id'=>$category_id])
            ->whereHas('user', function($q)
            {$q->where('block',1);})->select('id','user_id','category_id','country_id',lang().'_name as name',
                'price','discount','visitors','main_image','end_ad_date')
            ->paginate(28);
        return $this->returnData('department',$item);
    }//end fun

    public function showItemsDetails($id){
        $item=items::with('images:id,item_id,image','user:id,name,phones','category:id,'.lang().'_name as name')
            ->where(['id'=>$id,'status'=>1])
            ->select('id','main_image','visitors',lang().'_name as name',lang().'_desciption as desciption'
            ,'price','discount','item_end_date','user_id','category_id')->first();
//         dd($item->visitors);
        if ($item){
        $count=$item->visitors+1;
        $item->update(['visitors'=>$count]);
        $item->save();   }

        return $this->returnData('item',$item);
    }//end showItemsDetails
    /// end cats
    ///brands
    public function brands(){
        $brands=brands::select('id','name')->where('status',1)->get();
        return $this->returnData('brands',$brands);

    }//end brands

    public function models(){
        $models=models::select('id','name')->get();
        return $this->returnData('models',$models);

    }//end models

    public function brandsWithModels(){
        $models=brands::with('brands')
            ->where('status',1)->get();
        return $this->returnData('models',$models);

    }//end models

    public function agency($type,$country_id=0,$val=2){
        $agents=Agents::with('cars:id,agent_id','country:id,'.lang().'_name as name,'.lang().'_code as code')
            ->where('agent_type',$type)->where('status','!=',0);
        if ($val !=2) {
            $agents=$agents->where('car_type',$val);
        }

          if ($country_id !=0)  {
              $agents=$agents->where('country_id',$country_id);}
        $agents=$agents->select('id',lang().'_name as name','image','country_id')->orderBy('id','desc')
            ->paginate('20');
        foreach ($agents as $agent){
            $agent->car_count=$agent->cars->count();
        }
        return $agents;
    }

    public function rentAgency(Request  $request){
        if ($request->country_id) $agents=$this->agency(1,$request->country_id);
        else $agents=$this->agency(1);

        return $this->returnData('agents',$agents);
    }//end rentAgency

    public function rentAgencySearch(Request  $request){

        $rules=[
            'type'=>'sometimes:nullable|in:0,1|integer',
            'val'=>'required|in:0,1,2',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
//        dd($request->type==2);
        $val=$request->val;
        $type=$request->type;
        if ($request->country_id){
            if (isset($type)  && $type==2){
                $agents=$this->agency($type,$request->country_id);
            }
           else $agents=$this->agency($type,$request->country_id,$val);
        }
        else {
            if (isset($type) && $type ==2){
                dd('df');
                $agents=$this->agency($type);}
            else{
                $agents=$this->agency($type,'',$val);}
        }

        return $this->returnData('agents',$agents);
    }//end rentAgencySearch

    public function saleAgencySearch(Request  $request){

    }//end saleAgencySearch

    public function saleAgency(Request  $request){

        if ($request->country_id) $agents=$this->agency(0,$request->country_id);
        else $agents=$this->agency(0);
//        foreach ($agents as $agent){
//            $car_count=$agent->cars->count();
//        }
        return $this->returnData('agents',$agents);
    }//end saleAgency

    public function about(){
        $about = \App\Website::select('description_'.lang().' as description','email_1','email_2','phone_1',
            'phone_2','data','whats','phone','fatoorah','token','fatoorah_tameen')->first();
      //  $about->description=str_replace(' ', '-', $about->description);
        $about->description=strip_tags(preg_replace('/\s+/', ' ', $about->description));
        $about->token=strip_tags(preg_replace('/\s+/', '', $about->token));
        return $this->returnData('agents',$about);
    }

    public function searchShamel(Request  $request){
          try {
        $rules = [
            'carprice' => 'required',
            'type_of_use' => 'required',
            'brand_id' => 'required|int|min:1',
            'model_id' => 'required|int|min:1',
            'year' => 'required|int|min:1',
            'sort' => 'required|in:asc,desc',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $insurance_document = \App\InsuranceDocument:: where(['type_of_use'=>$request->type_of_use,'status'=>0])->get();
        $typeOfUse = $request->type_of_use;
//           $complete_insurances = \App\CompleteDoc::with(['conditions','additions:id,FeatureNameAr,FeatureNameEn,FeatureCost,FeatureNotices,insurance_document_id','user.Country:id,'.lang().'_code as code,'.lang().'_currency as currency','conditions.condition_items'])
           $complete_insurances = \App\CompleteDoc::with(['user.Country:id,'.lang().'_code as code,'.lang().'_currency as currency','conditions.condition_items'])
            ->where([
                'type_of_use' => $typeOfUse,
                'brand_id' => $request->brand_id,
                'model_id' => $request->model_id,
                'status'=>1,
                'search_show'=>1,
            ])->where('max_value','>=',$request->carprice)
            ->where('max_year_search','<=',$request->year)
            ->where('end_date','>=',date('Y-m-d H:i:s'));

              if ($request->country_id) $complete_insurances=$complete_insurances->where('country_id',$request->country_id);

               $complete_insurances=$complete_insurances->orderBy('OpenFileMinimumFirstSlide',$request->sort)
               ->select('id','insurance_id','user_id',lang().'_term','firstSlidePrice','OpenFileFirstSlide','OpenFilePerecentFirstSlide',
                  'OpenFileMinimumFirstSlide','SecondSlidePrice','OpenFileSecondSlide','OpenFilePerecentSecondSlide',
                  'thirdSlidePrice','OpenFileThirdSlide','OpenFilePerecentThirdSlide','fourthSlidePrice',
                  'OpenFileFourthSlide','OpenFilePerecentFourthSlide','precent','start_disc','end_disc','price',
                  'status','end_date','deliveryFee','Insurance_Company_ar','Insurance_Company_en',
                  'logo','year','in_duration','display','search_show','max_value','fake_discount')->get();

        return $this->returnData('insurance',$complete_insurances);
       }//end try
       catch(\Exception $ex){
           return $this->returnError($ex->getCode(),$ex->getMessage());
       }//end cach

    }//end searchShamel

    public function searchTameenOther(Request  $request){
        $rules = [
            'type_of_use' => 'required|in:private,rent',
            'brand_id' => 'required|int|min:1',
            'model_id' => 'required|int|min:1',
            'year' => 'required|int|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $insurance_document = \App\InsuranceDocument::where([
          //  'brand_id'=>$request->brand_id,
         //   'model_id'=>$request->model_id,
            'type_of_use'=>$request->type_of_use,
            'status' => 1])->with('User.Country:id,'.lang().'_code as code,'.lang().'_currency as currency')
            //->where('end_date','>=',date('Y-m-d'))
            ->select('id','user_id',lang().'_term','insurance_id','firstinterval','secondinterval','thirdinterval',
            'Insurance_Company_'.lang().' as Insurance_Company','logo','discount_q','start_disc','end_disc',
            'type','type_of_use','in_duration','price','status','end_date','deliveryFee');
        if($request->country_id) $insurance_document=$insurance_document->where('country_id',$request->country_id);
        $insurance_document=$insurance_document->get();
        return $this->returnData('insurances',$insurance_document);
    }//end searchother

    public function uses(){
        $uses = \App\Style::select('id','name_'.lang() .' as name')->get();
       return $this->returnData('uses',$uses);
    }

    public function settings(){
        $settings=Website::first();
        return $this->returnData('setting',$settings);
    }//end setting

    public function restPassword(Request  $request){
        $rules = [
            'email' => 'required|email|exists:users,email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        try {
            $code = substr(str_shuffle(str_repeat($pool, 15)), 0, 15);
            $user=User::where('email',$request->email)->first();
            $pass=bcrypt($code);
            $user->update(['password'=>$pass]);
            $text='Hi sir : your New password is  '.$code;
            Mail::send([], [], function ($message) use ($user,$text) {

                $message->to($user->email, 'Update your password')->subject
                ('New Request')// here comes what you want
                ->setBody('<h4> Hello, ' . $user->name . ' , </h4> <p> '.$text.' </p>', 'text/html'); // assuming text/plain
                $message->from('info@tameenistore.com', 'Customer Services');
            });
            return $this->returnSuccessMessage('success',99);
        }     catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach

    }//end fun

    public function membershipCars(){
        $rows=AdsMembership::select('id','name_'.lang(),'price','duration','type')->get();
        return $this->returnData('rows',$rows);
    }//end membershipCars

    public function membershipDeps(){
        $rows=DepartmentMembership::select('id','name_'.lang(),'price','duration')->get();
        return $this->returnData('rows',$rows);
    }//end membershipCars

}//end class
