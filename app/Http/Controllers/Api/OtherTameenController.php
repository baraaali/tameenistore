<?php

namespace App\Http\Controllers\Api;

use App\country;
use App\Http\Controllers\Controller;
use App\Insurance;
use App\InsuranceDocument;
use App\Insurancetemplate;
use App\SubscriptionUser;
use App\Token;
use App\Traits\GeneralTrait;
use App\User;
use App\userinsurance;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;


class OtherTameenController extends Controller
{
    use GeneralTrait;

   public function getAllother(){
       $user=auth()->guard('api')->user()->id;
       $insurance_document = Insurancetemplate::where('user_id',$user)->select('id',lang().'_term','Insurance_Company_'.lang(),
       'logo','type_of_use')
           ->get();
       return $this->returnData('rows',$insurance_document);
   }//end getAllother

    public function addOtherTameen(Request  $request){
        $rules=[
            'type_of_use'=>'required|in:private,rent',
            'Insurance_Company_ar'=>'required|unique:insurance_templates,Insurance_Company_ar',
            'Insurance_Company_en'=>'required|unique:insurance_templates,Insurance_Company_en',
            'deliveryFee'=>'required|integer',
            'ar_term'=>'required',
            'en_term'=>'required',
            'precent'=>'required|integer',
            'discount_q'=>'required|integer',
            'start_disc'=>'required',
            'end_disc'=>'required|date|after:start_disc',
            'logo'=>'required|image|max:7000',
        ];
        //  return auth()->guard('api')->user();
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user=auth()->guard('api')->user()->id;
        $country=auth()->guard('api')->user()->country->id;
        $status=checkUserSubscription(1,$user);
        if ($status !=0) return  $this->returnError(99,$status);
        $check=checkUploadDocument();
        if ($check ==1) return  $this->returnError(99,'من فضلك قم برفع المستندات المطلوبه اولا');
        try {
            if($request->file('logo')){
                $imageName = $request->Insurance_Company_ar.'.'.request()->logo->getClientOriginalExtension();
                request()->logo->move(public_path('uploads'), $imageName);
                $logo_name = $imageName;
            }
            $sub=SubscriptionUser::where(['user_id'=>$user,'type'=>'1'])->latest()->first()->end_date;

            if ($sub<date('Y-m-d')) return redirect()->route('selectMembership')->with('success','انتهت مده اشتراكك من فضلك قم بالتجديد');

            $end_date = $sub;
            $year = date("Y");
            $row=Insurancetemplate::create($request->all()+['year'=>$year,
                    'end_date'=>$end_date,'user_id'=>$user,'country_id'=>$country]);
            $row->logo=$logo_name;
            $row->save();
            return $this->returnSuccessMessage('success');
        }
        catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
    }//end addotherTameen

    public function showTameen($id){
        $user=auth()->guard('api')->user()->id;
//        $row=Insurancetemplate::where(['user_id'=>$user,'id'=>$id])->
//            select(lang().'_term as term','year','Insurance_Company_'.lang() .' as name','logo','deliveryFee',
//        'precent','discount_q','start_disc','end_disc','type_of_use','status','end_date')->first();
        $row=Insurancetemplate::where(['user_id'=>$user,'id'=>$id])->first();
        if ($row){
            return $this->returnData('row',$row);
        }
        else return $this->returnError(99,'هذا العنصر غير موجود');
    }//end showTameen

    public function addBrand(Request  $request){
        $rules=[
            'id'=>'integer|required',
            'model_id'=>'required|array',
            'price'=>'required|array',
            'brand_id'=>'required|array',
            'firstinterval'=>'required|array',
            'secondinterval'=>'required|array',
            'thirdinterval'=>'required|array',
        ];
        //  return auth()->guard('api')->user();
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $doc=Insurancetemplate::find($request->id)->toArray();
        array_shift($doc);
        $user_id=$doc['user_id'];
        $insurance_id=Insurance::where('user_id',$user_id)->first()->id;
        $country=auth()->guard('api')->user()->country->id;
        DB::beginTransaction();
        try {
            for ($key=0;$key<count($request->firstinterval);$key++) {
                if ($request->firstinterval[$key] != null) {
                    $model_brand = explode(',', $request->model_id[0]);
                    InsuranceDocument::create($doc + [
                            'other_id' => $request->id,
                            'insurance_id' => $insurance_id,
                            'model_id' => $model_brand[0],
                            'brand_id' => $request->brand_id[$key],
                            'price' => $request->price[$key],
                            'firstinterval' => $request->firstinterval[$key],
                            'secondinterval' => $request->secondinterval[$key],
                            'thirdinterval' => $request->thirdinterval[$key],
                            'country_id' => $country,
                        ]);
                }
            }
            DB::commit();
            return $this->returnSuccessMessage('success');
        }
        catch(\Exception $ex){
            DB::rollback();
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach

    }//end addBrand

    public function editOtherTameen($id,Request  $request){
        $rules=[
            'type_of_use'=>'required|in:private,rent',
            'Insurance_Company_ar'=>'required|unique:insurance_templates,Insurance_Company_ar,'.$id,
            'Insurance_Company_en'=>'required|unique:insurance_templates,Insurance_Company_en,'.$id,
            'deliveryFee'=>'required|integer',
            'ar_term'=>'required',
            'en_term'=>'required',
            'precent'=>'required|integer',
            'discount_q'=>'required|integer',
            'start_disc'=>'required',
            'end_disc'=>'required|date|after:start_disc',
            'logo'=>'sometimes:nullable|image|max:7000',
            'status'=>'required|integer|in:1,0',
        ];
        //  return auth()->guard('api')->user();
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user=auth()->guard('api')->user()->id;
        try {
            $doc = Insurancetemplate::where('id',$request->id)->first();
            $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
            $doc->Insurance_Company_en = $request->Insurance_Company_en;
            $doc->deliveryFee = $request->deliveryFee;
            $doc->ar_term= $request->ar_term;
            $doc->en_term = $request->en_term;
            $doc->user_id = $user;
            $doc->year = date("Y");
            $doc->precent = $request->precent;
            $doc->status = $request->status;
            $doc->discount_q = $request->discount_q;
            $doc->start_disc = $request->start_disc ;
            $doc->end_disc = $request->end_disc;
            $doc->type_of_use = $request->type_of_use;
            $doc->in_duration = $request->in_duration;
            if($request->file('logo')){
                $imageName = $request->Insurance_Company_ar.'.'.request()->logo->getClientOriginalExtension();
                request()->logo->move(public_path('uploads'), $imageName);
                $doc->logo = $imageName;
            }

            // $doc->type = 0;
            $doc->save();
            $arr=$doc->toArray();

            array_shift($arr);
            $ins=new InsuranceDocument();
            $ins->where(['user_id'=>$user,'other_id'=>$id])->update($arr);
        } catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
    }

    public function showAllOtherBrands($id,Request  $request){
        $user=auth()->guard('api')->user()->id;
        $rows=InsuranceDocument::with(['idbrand:id,name','idmodel:id,name'])->
        where(['user_id'=>$user,'other_id'=>$id])->select('id','brand_id','model_id','status','price',
        'firstinterval','secondinterval','thirdinterval','Insurance_Company_'.lang().' as name','logo','deliveryFee')->get();

        return $this->returnData('rows',$rows);
    }//end showAllOtherBrands

    public function deleteOtherTameen(Request  $request){
        $rules=[ 'id'=>'required|integer'];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user=auth()->guard('api')->user()->id;
        $row=Insurancetemplate::where(['id'=>$request->id,'user_id'=>$user])->first();
        if ($row){
            $row->delete();
            return $this->returnSuccessMessage('success');
        }
        return $this->returnError(99,'هذا العنصر غير موجود');
    }//end fun

    public function showRequestOther(){

        $user=auth()->guard('api')->user()->id;
        $insurance = \App\Insurance::where('user_id',$user)->get();
        $rows=userinsurance::with(['user:id,name,email,phones','brand:id,name','model:id,name'])->
        whereIn('insurance_id',$insurance->pluck('id'))->get();
         return $this->returnData('rows',$rows);
    }

    public function deleteRequestOther($id){
        userinsurance::where('id',$id)->Forcedelete();
       return $this->returnSuccessMessage('success');
    }

    public function sendRequestOther(Request  $request){
        $rules=[
            'insurance_id'=>'required|integer|exists:insurance,id',
            'id'=>'required|integer|exists:insurance_document,id',
//            'brand_id' =>'required|int|exists:brands,id',
//            'model_id' =>'required|int|exists:models,id',
            'type' =>'required|in:rent,private',
//            'name_ar' =>'required',
//            'name_en' =>'required',
            'inDuration' =>'required',
            'year' =>'required',
            'price' =>'required',
            'date'=>'required|date',
            'delivery' => 'required|integer|in:0,1',
            'files'=>'required|array|min:1',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        try {
            $doc = \App\Insurance::where('id',$request->insurance_id)->first();
            $row = \App\InsuranceDocument::where('id',$request->id)->first();
            $user=auth()->guard('api')->user()->id;
        $req = new userinsurance();
        $req->type_of_use = $request->type;
        $req->brand_id =$row->brand_id;
        $req->model_id = $row->model_id;
        $req->year = $request->year;
        $req->insurance_id = $request->insurance_id;
        $req->price = $request->price;
        $req->inDuration = $request->inDuration;
        $req->companynameen = $doc->en_name;
        $req->companynamear = $doc->ar_name;
        $req->start_in = $request->date;
        $req->delivery = $request->delivery;
        $req->user_id = $user;
        $files_array = [];
        if($request->file('files')) {
            foreach($request->file('files') as $file){

                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $imageName);

                array_push($files_array,$imageName);
            }
        }
        $req->files = json_encode($files_array);
        $req->save();
       $token=Token::where('user_id',$doc->user_id)->first();
       return  $this->returnData('token',$token);}
        catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach

        }//sendRequestOther

}//end class
