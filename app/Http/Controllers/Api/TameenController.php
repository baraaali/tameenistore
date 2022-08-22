<?php

namespace App\Http\Controllers\Api;

use App\Addition;
use App\brands;
use App\CompleteDoc;
use App\CompleteDocSubmit;
use App\CompleteDocSubmitAddition;
use App\Condition;
use App\ConditionItem;
use App\Http\Controllers\Controller;
use App\Insurance;
use App\MemberInsurance;
use App\models;
use App\SubscriptionUser;
use App\Token;
use App\Traits\GeneralTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;


class TameenController extends Controller
{
    use GeneralTrait;

    public function selectMemberShip(Request  $request){
        try{
            $rules=[
                'status' => 'required|int',
            ];
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails()){
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
        $status=$request->status;
        if ($status== -1) $sub=\App\MemberInsurance::where('type','0')->where('free','0');
        elseif ($status== -2) $sub=\App\MemberInsurance::where('type','1')->where('free','0');
        elseif ($status==1||$status==2) $sub=\App\MemberInsurance::where('type','0')->where('free','1');
        else $sub=\App\MemberInsurance::where('type','1')->where('free','1')->first();
        $sub=$sub->select('id','name_'.lang(),'price','type','duration','free')->first();

        return $this->returnData('membership',$sub);}
        catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach

    }//end fun

    public function userSubscribe(Request  $request){
        $rules=[
            'type' => 'required|int',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
         $user=auth()->guard('api')->user()->id;
        $check=checkUserSubscription($request->type,1);

        return $this->returnData('checkStatus',$check);

    }//end checkUserSubscrib

    public function checkUserUploadDocument(Request  $request){
        $user=auth()->guard('api')->user();
       // dd($user);
        $check=checkUploadDocument(1);

        return $this->returnData('checkStatus',$check);
    }

    public function checkPossibleAdd(Request  $request){
        $rules=[
            'type' => 'required',
        ];
      //  return auth()->guard('api')->user();
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user=auth()->guard('api')->user();
        $status=checkUserSubscription($request->type,1);
        //dd($status);
        if ($status !=0) return  $this->returnError(99,$status);

        $check=checkUploadDocument(1);

        if ($check==1) return  $this->returnError(99,'pleaze upload document');

        return $this->returnSuccessMessage('you can now add tameen');

    }//end fun

    public function subscribeMembership(Request  $request){
        $rules=[
            'type' => 'required',
            'membership_id' => 'required|int|exists:memberships_insurance,id',
        ];
        //  return auth()->guard('api')->user();
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $membership=MemberInsurance::find($request->membership_id);
        $type=$request->type;
        $id=auth()->guard('api')->user()->id;
        if($membership->price=='0'){

            checkMembership($membership,$id,$type);
            if ($type=='0') return $this->returnSuccessMessage('تم الاشتراك فى العضويه');
        }
        else{
            $price=$membership->price;
            $checked=checkUserBalance($id,$price);
            if ($checked==0) return $this->returnError(99,'ليس لديك رصيد كافى ... من فضلك قم بشحن رصيدك');
            else {
                try {
                    transaction($id,'out',$price,'membership',-2);
                    checkMembership($membership,$id,$type);
                    if ($type==0) return $this->returnSuccessMessage('تم الاشتراك فى العضويه');
                } catch(\Exception $ex){
                    return $this->returnError($ex->getCode(),$ex->getMessage());
                }//end cach
            }
        }

    }//end subscribe membership

    public function addCompleteTameen(Request $request){
//dd($request->start_disc);
        $rules=[
            'type_of_use' =>'required|int|exists:uses,id',
//            'brand_id' =>'required|int|exists:brands,id',
//            'model_id' =>'required|int|exists:models,id',
            'Insurance_Company_ar' =>'required|min:3|max:150|unique:complete_doc,Insurance_Company_ar',
            'Insurance_Company_en' =>'required|min:3|max:150|unique:complete_doc,Insurance_Company_en',
            'deliveryFee' =>'required|int',
            'precent' =>'required|int',
            'ar_term' =>'required',
            'en_term' =>'required',
            'max_value' =>'required|int',
            'max_year' =>'required|int',
            'start_disc' =>'required|date',
            'end_disc' =>'required|date',
            'ToleranceratioCheck' =>'required',
            'Tolerance_ratio'  =>'required',
            'ToleranceYearPerecenteage' =>'required' ,
            'ConsumptionRatio'  => 'required',
            'ConsumptionFirstRatio' =>'required',
            'YearPerecenteage' =>'required',
            'ConsumptionYearPerecenteage' =>'required',
            'last_percent'=>'required',
            'last_percent_en'=>'required',
            'FeatureNameAr'=>'required|array',
            'FeatureNameEn'=>'required|array',
            'FeatureCost'=>'required|array',
            'FeatureNotices'=>'required|array',
            'AddonNameAR'=>'required|array',
            'AddonNameEn'=>'required|array',
            'AddonMaxYear'=>'required|array',
            'AddonUnkownMaxmum'=>'required|array',
            'logo'=>'required|image|max:5000|mimes:jpeg,jpg,png'
        ];
        //  return auth()->guard('api')->user();
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user=auth()->guard('api')->user()->id;
        $country=auth()->guard('api')->user()->country->id;
        $document=CompleteDoc::where('user_id',$user)->first();
        //dd($user);
        $insurance=Insurance::where('user_id',$user)->first();
        $model=models::first()->id;
        $brand=brands::first()->id;
        if($request->file('logo')){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads'), $imageName);
        }
        $year = date("Y");
        $logo = $imageName;
        $sub=SubscriptionUser::where(['user_id'=>$user,'type'=>'0'])->latest()->first()->end_date;
        if ($sub<date('Y-m-d')) return $this->returnError(99,'انتهت مده اشتراكك من فضلك قم بالتجديد');
        $end_date = $sub;
        $mix=$year-$request->max_year;
        $requestData=[
            'type_of_use' =>$request->type_of_use,
            'Insurance_Company_ar' =>$request->Insurance_Company_ar,
            'Insurance_Company_en' =>$request->Insurance_Company_en,
            'deliveryFee' =>$request->deliveryFee,
            'ar_term' =>$request->ar_term,
            'en_term' =>$request->en_term,
            'start_disc' =>$request->start_disc,
            'precent' =>$request->precent,
            'end_disc' =>$request->end_disc,
            'max_value' =>$request->max_value,
            'max_year' =>$request->max_year,
            'max_year_search' =>$mix,
            'price'=>0,
            'insurance_id'=>$insurance->id,
            'logo'=>$logo,
            'year'=>$year,
            'user_id'=>$user,
            'end_date'=>$end_date,
            'model_id'=>$model,
            'brand_id'=>$brand,
            'fake_discount'=>1,
            'country_id'=>$country,
//            'model_id'=>$request->model_id,
//            'brand_id'=>$request->brand_id,
        ];
        //dd($country);
        $status=checkUserSubscription('0',1);
        //dd($status);
        if ($status !=0) return  $this->returnError(99,$status);
        $check=checkUploadDocument();
        if ($check ==1) return  $this->returnError(99,'من فضلك قم برفع المستندات المطلوبه اولا');
        DB::beginTransaction();
        try {
            $row = CompleteDoc::create($requestData);

            $arrCon = [
                'ToleranceratioCheck' => $request->ToleranceratioCheck,
                'Tolerance_ratio' => $request->Tolerance_ratio,
                'ToleranceYearPerecenteage' => $request->ToleranceYearPerecenteage,
                'ConsumptionRatio' => $request->ConsumptionRatio,
                'ConsumptionFirstRatio' => $request->ConsumptionFirstRatio,
                'YearPerecenteage' => $request->YearPerecenteage,
                'ConsumptionYearPerecenteage' => $request->ConsumptionYearPerecenteage,
                'last_percent' => $request->last_percent,
                'last_percent_en' => $request->last_percent_en,
                'insurance_document_id' => $row->id
            ];
            $rowCon = Condition::create($arrCon);

            foreach ($request->AddonNameAR as $keyConditionItem => $AddonNameAR) {
                $ConditionItem = ConditionItem::create(
                    [
                        'AddonNameAR' => $AddonNameAR,
                        'AddonNameEn' => $request->AddonNameEn[$keyConditionItem],
                        'AddonMaxYear' => $request->AddonMaxYear[$keyConditionItem],
                        'AddonUnkownMaxmum' => $request->AddonUnkownMaxmum[$keyConditionItem],
                        'condition_id' => $rowCon->id
                    ]
                );
            }
            foreach ($request->FeatureNameAr as $keyAddition => $FeatureNameAr) {
                $Addition = Addition::create(
                    [
                        'FeatureNameAr' => $FeatureNameAr,
                        'FeatureNameEn' => $request->FeatureNameEn[$keyAddition],
                        'FeatureCost' => $request->FeatureCost[$keyAddition],
                        'FeatureNotices' => $request->FeatureNotices[$keyAddition],
                        'insurance_document_id' => $row->id
                    ]
                );
            }
            DB::commit();
            return $this->returnSuccessMessage('تم اضافه التأمين');
        }    catch(\Exception $ex){
            DB::rollback();
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//

    }//end addCompleteTameen

    public function editCompleteTameen($id){
        $row = \App\CompleteDoc::with('conditions.condition_items','additions')->where('id',$id)->first();
        return $this->returnData('tameen',$row);
    }//end editCompleteTameen

    public function updateCompleteTameen($id,Request  $request){
        $rules=[
            'type_of_use' =>'required|int|exists:uses,id',
//            'brand_id' =>'required|int|exists:brands,id',
//            'model_id' =>'required|int|exists:models,id',
            'Insurance_Company_ar' =>'required|min:3|max:150|unique:complete_doc,Insurance_Company_ar,'.$id,
            'Insurance_Company_en' =>'required|min:3|max:150|unique:complete_doc,Insurance_Company_en,'.$id,
            'deliveryFee' =>'required|int',
            'precent' =>'required|int',
            'ar_term' =>'required',
            'en_term' =>'required',
            'max_value' =>'required|int',
            'max_year' =>'required|int',
            'start_disc' =>'required|date',
            'end_disc' =>'required|date',
            'ToleranceratioCheck' =>'required',
            'Tolerance_ratio'  =>'required',
            'ToleranceYearPerecenteage' =>'required' ,
            'ConsumptionRatio'  => 'required',
            'ConsumptionFirstRatio' =>'required',
            'YearPerecenteage' =>'required',
            'ConsumptionYearPerecenteage' =>'required',
            'last_percent'=>'required',
            'last_percent_en'=>'required',
            'FeatureNameAr'=>'required|array',
            'FeatureNameEn'=>'required|array',
            'FeatureCost'=>'required|array',
            'FeatureNotices'=>'required|array',
            'AddonNameAR'=>'required|array',
            'AddonNameEn'=>'required|array',
            'AddonMaxYear'=>'required|array',
            'AddonUnkownMaxmum'=>'required|array',
            'logo'=>'required|image|max:5000|mimes:jpeg,jpg,png|sometimes:nullable'
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user=auth()->guard('api')->user()->id;
        $document=CompleteDoc::where('id',$id)->first();
        // dd($document);
        //$insurance=Insurance::where('id',$request->insurance_id)->first();
        $model=$document->model_id;
        $brand=$document->brand_id;
        if($request->file('logo')){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads'), $imageName);
        }
        $fake=isset($request->fake_discount)?0:1;
        $year = date("Y");
        $logo = $imageName??$document->logo;
        $end_date = auth()->guard('api')->user()->ended_at;
        $mix=$year-$request->max_year;
        $requestData=[
            'type_of_use' =>$request->type_of_use,
            'Insurance_Company_ar' =>$request->Insurance_Company_ar,
            'Insurance_Company_en' =>$request->Insurance_Company_en,
            'deliveryFee' =>$request->deliveryFee,
            'ar_term' =>$request->ar_term,
            'en_term' =>$request->en_term,
            'start_disc' =>$request->start_disc,
            'end_disc' =>$request->end_disc,
            'max_value' =>$request->max_value,
            'max_year' =>$request->max_year,
            'price'=>0,
            'precent'=>$request->precent,
//            'insurance_id'=>$insurance->id,
            'logo'=>$logo,
            'year'=>$year,
            'max_year_search'=>$mix,
            'user_id'=>$user,
            'end_date'=>$end_date,
            'fake_discount'=>$fake,
//            'model_id'=>$model,
//            'brand_id'=>$brand,
        ];

        ///to do
        $docs=CompleteDoc::where(['Insurance_Company_en'=>$document->Insurance_Company_en,
            'user_id'=>$document->user_id])->get();
        foreach ($docs as $doc){
            $doc->update($requestData);
        }
        // $row = $document->update($requestData);

        $arrCon=[
            'ToleranceratioCheck' =>  $request->ToleranceratioCheck,
            'Tolerance_ratio'  =>  $request->Tolerance_ratio,
            'ToleranceYearPerecenteage' =>  $request->ToleranceYearPerecenteage ,
            'ConsumptionRatio'  =>  $request->ConsumptionRatio,
            'ConsumptionFirstRatio' =>  $request->ConsumptionFirstRatio,
            'YearPerecenteage' =>  $request->YearPerecenteage,
            'ConsumptionYearPerecenteage' =>  $request->ConsumptionYearPerecenteage,
            'last_percent'=>$request->last_percent,
            'last_percent_en'=>$request->last_percent_en,
            'insurance_document_id' =>  $document->id
        ];
        $con=Condition::where('insurance_document_id',$document->id)->first();
        if ($con !=null){
            $con->update($arrCon);
            $rowCon=$con;
        }else{
            $rowCon = Condition::create($arrCon);
        }
        $deleted=ConditionItem::where('condition_id',$rowCon->id)->delete();
        foreach($request->AddonNameAR as $keyConditionItem => $AddonNameAR){
            $ConditionItem = ConditionItem::create(
                [
                    'AddonNameAR' => $AddonNameAR,
                    'AddonNameEn'  => $request->AddonNameEn[$keyConditionItem],
                    'AddonMaxYear'  => $request->AddonMaxYear[$keyConditionItem],
                    'AddonUnkownMaxmum'  => $request->AddonUnkownMaxmum[$keyConditionItem],
                    'condition_id' => $rowCon->id
                ]
            );
        }
        $addition=Addition::where('insurance_document_id',$document->id)->delete();
        foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
            $Addition = Addition::create(
                [
                    'FeatureNameAr' => $FeatureNameAr,
                    'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                    'FeatureCost' => $request->FeatureCost[$keyAddition],
                    'FeatureNotices' => $request->FeatureNotices[$keyAddition],
                    'insurance_document_id' =>  $document->id
                ]
            );
        }
       return  $this->returnSuccessMessage('success','تم التحديث بنجاح');
    }//end fun updateCompleteTameen

//    public function addBrand($id,$name){
//        $user_id=auth()->guard('api')->user()->id;
//        $ids=\App\CompleteDoc::where(['user_id'=>$user_id,'Insurance_Company_ar'=>$name])->pluck('model_id')->toArray();
//        $models= \App\models::where('brand_id',$id)->whereNotIn('id',$ids)->get();
//
//        return $this->returnData('models',$models);
//    }//end fun

      public function addBrand(Request  $request){
          $rules=[
              'model_id'=>'required|array|exists:models,id',
              'brand_id' =>'required|int|exists:brands,id',
              'id' =>'required|int',
              'firstSlidePrice' =>'required|array',
              'OpenFileFirstSlide' =>'required|array',
              'OpenFilePerecentFirstSlide' =>'required|array',
              'OpenFileFirstSlideMin' =>'required|array',
              'SecondSlidePrice' =>'required|array',
              'OpenFileSecondSlide' =>'required|array',
              'OpenFilePerecentSecondSlide' =>'required|array',
              'thirdSlidePrice' =>'required|array',
              'OpenFileThirdSlide' =>'required|array',
              'OpenFilePerecentThirdSlide' =>'required|array',
              'fourthSlidePrice' =>'required|array',
              'OpenFileFourthSlide' =>'required|array',
              'OpenFilePerecentFourthSlide' =>'required|array',

          ];
          //  return auth()->guard('api')->user();
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails()){
              $code=$this->returnCodeAccordingToInput($validator);
              return $this->returnValidationError($code,$validator);
          }
          $user=auth()->guard('api')->user()->id;
          $status=checkUserSubscription('0',1);
          //dd($status);
          if ($status !=0) return  $this->returnError(99,$status);
          $check=checkUploadDocument();
          if ($check ==1) return  $this->returnError(99,'من فضلك قم برفع المستندات المطلوبه اولا');
          $res = null;
          $compDocument=CompleteDoc::where(['id'=>$request->id])->selectionExcpt()->toArray();
          $j=-1;
          for ($i=0;$i<count($request->firstSlidePrice);$i++){
              if ($request->firstSlidePrice[$i] !=null) {
                  $j++;
                  $con = ['model_id' => $request->model_id[$j], 'brand_id' => $request->brand_id,'fake_discount'=>1];
                  $arr = $this->arr($request, $i);
                  $createRow = $arr + $compDocument[0] + $con;
                  CompleteDoc::create($createRow);
              }//end if
          }
          return $this->returnSuccessMessage('success','تم الاضافة بنجاح');
      }//end addBrand

      public function arr($request,$increment){
        $slides=[
            'firstSlidePrice' => $request->firstSlidePrice[$increment],
            'OpenFileFirstSlide' => $request->OpenFileFirstSlide[$increment],
            'OpenFilePerecentFirstSlide' => $request->OpenFilePerecentFirstSlide[$increment],
            'OpenFileMinimumFirstSlide' => $request->OpenFileFirstSlideMin[$increment],
            'SecondSlidePrice' => $request->SecondSlidePrice[$increment],
            'OpenFileSecondSlide' => $request->OpenFileSecondSlide[$increment],
            'OpenFilePerecentSecondSlide' => $request->OpenFilePerecentSecondSlide[$increment],
            'thirdSlidePrice' => $request->thirdSlidePrice[$increment],
            'OpenFileThirdSlide' => $request->OpenFileThirdSlide[$increment],
            'OpenFilePerecentThirdSlide' => $request->OpenFilePerecentThirdSlide[$increment],
            'fourthSlidePrice' => $request->fourthSlidePrice[$increment],
            'OpenFileFourthSlide' => $request->OpenFileFourthSlide[$increment],
            'OpenFilePerecentFourthSlide' => $request->OpenFilePerecentFourthSlide[$increment],
            'display'=>1
        ];
        return $slides;
    }//end arr

    public function getAllBrands(Request  $request){
        $rules=[
            'name_ar' => 'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user_id = auth()->guard('api')->user()->id;
        $docs=CompleteDoc::with(['idbrand:id,name','idmodel:id,name'])->where(['Insurance_Company_ar'=>$request->name_ar,'display'=>1,'user_id'=>$user_id])
            ->select('firstSlidePrice','OpenFileFirstSlide','OpenFilePerecentFirstSlide','OpenFileMinimumFirstSlide','SecondSlidePrice','OpenFileSecondSlide','OpenFilePerecentSecondSlide'
                ,'thirdSlidePrice','OpenFileThirdSlide','OpenFilePerecentThirdSlide','fourthSlidePrice','OpenFileFourthSlide','OpenFilePerecentFourthSlide'
                ,'id','model_id','brand_id')->get()->groupBy('brand_id');
       return $this->returnData('docs',$docs);
        return view('Cdashboard.all_brands',compact('brands','lang'));
    }//end getAllBrands

    public function updateBrand(Request  $request){
        $rules=[
            'id' =>'required|int',
            'firstSlidePrice' =>'required',
            'OpenFileFirstSlide' =>'required',
            'OpenFilePerecentFirstSlide' =>'required',
            'OpenFileFirstSlideMin' =>'required',
            'SecondSlidePrice' =>'required',
            'OpenFileSecondSlide' =>'required',
            'OpenFilePerecentSecondSlide' =>'required',
            'thirdSlidePrice' =>'required',
            'OpenFileThirdSlide' =>'required',
            'OpenFilePerecentThirdSlide' =>'required',
            'fourthSlidePrice' =>'required',
            'OpenFileFourthSlide' =>'required',
            'OpenFilePerecentFourthSlide' =>'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $user=auth()->guard('api')->user()->id;
        try {
            $row = CompleteDoc::find($request->id);
            if ($row) {
                $row->fill($request->except(['id']));
                $row->save();
                return $this->returnSuccessMessage('success');
            }
        } catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//
    }//end update brand

    public function ChangeCompleteStatus(Request  $request){
        $rules=[
            'id' =>'required|int',
            'status' =>'required|int|in:0,1',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $row=CompleteDoc::find($request->id);
        if ($row){
            $row->update(['status'=>$request->status]);
            //$row->save();
            return $this->returnSuccessMessage('success');
        }
        else return  $this->returnError(99,'هذا العنصر غير موجود ');
    }//end fun changeStatus

    public function getAllComplete(){
        $user=auth()->guard('api')->user()->id;
        $complete_insurance = \App\CompleteDoc::with(['idbrand:id,name','idmodel:id,name'])->where('user_id',$user)
            ->select('id','display','Insurance_Company_'.lang() .' as name','logo','model_id', 'brand_id','Insurance_Company_ar')->get()
            ->groupBy('Insurance_Company_ar');
       // $merge_insurance =$insurance_document->merge( $complete_insurance);

        return $this->returnData('rows',$complete_insurance);
    }//end getAllComplete

    public function deleteCompleteTameen(Request  $request){
        $rules=[
            'id' =>'required|int',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }

        $user=auth()->guard('api')->user()->id;
        $row=CompleteDoc::where(['id'=>$request->id,'user_id'=>$user])->first();
        DB::beginTransaction();
        try {
            if ($row) {
                $name = $row->Insurance_Company_ar;
                $coms = CompleteDocSubmit::where('complete_doc_id', $row->id)->get();
                if (count($coms) > 0) CompleteDocSubmit::where('complete_doc_id', $request->id)->forceDelete();
                CompleteDoc::where(['Insurance_Company_ar' => $name, 'user_id' => $user])->forceDelete();
                $adds = Addition::where('insurance_document_id', $request->id)->get();
                if (count($adds) > 0) {
                    foreach ($adds as $ad) {
                        $ad->forceDelete();
                    }
                }
                DB::commit();
                return $this->returnSuccessMessage('success');
            }
        }    catch(\Exception $ex){
            DB::rollback();
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//
       return $this->returnError(99,'هذا العنصر غير موجود');
    }//end deleteCompleteTameen

    public function completeRequestTameen(){
        $user=auth()->guard('api')->user()->id;
        $rows = CompleteDocSubmit::with(['user:id,name,email,phones','complete_doc.idbrand:id,name',
            'CompleteDocSubmitAddition.addition:id,FeatureNameAr,FeatureNameEn,FeatureCost'])
            ->where('owner_id',$user)->where('status','!=',0)->get();
        return $this->returnData('rows',$rows);
    }//end completeRequestTameen

    public function completeRequestTameenDelete($id){
        $row=CompleteDocSubmit::find($id);
        if ($row !=null){
            $row->status=0;
            $row->save();
            return $this->returnSuccessMessage('sucess');
        }
        return $this->returnError(99,'not found');
    }//end completeRequestTameenDelete

    public function sendCompleteRequest(Request  $request)
    {
        $rules = [
            'start_date' => 'required|date',
            'file' => 'required|image|max:3000',
            'id' => 'required|exists:complete_doc,id',
            'total_price' => 'required|integer',
            'price' => 'required|integer',
            'delivery' => 'required|integer|in:0,1',
            'add_id' => 'sometimes:nullable|array|exists:additions,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $user_id = auth()->guard('api')->user()->id;
        DB::beginTransaction();
        try {
            if ($request->has('file')) {
                $imageName = time() . '.' . request()->file->getClientOriginalExtension();
                request()->file->move(public_path('uploads'), $imageName);
            }
            $com = CompleteDoc::find($request->id);
            $first_row = CompleteDoc::where(['user_id' => $com->user_id, 'Insurance_Company_ar' => $com->Insurance_Company_ar])
                ->first()->id;
            $CompleteDocSubmit = CompleteDocSubmit::create([
                'complete_doc_id' => $request->id,
                'price' => $request->price,
                'user_id' => $user_id,
                'net_price' => $request->total_price,
                'file' => $imageName,
                'owner_id' => $com->user_id,
                'start_date' => $request->start_date,
                'delivery' => $request->delivery,
            ]);
            if (isset($request->add_id)&&count($request->add_id) > 0) {
//                     dd('dd');
                foreach ($request->add_id as $addition) {
                    CompleteDocSubmitAddition::create([
                        'complete_doc_submit_id' => $CompleteDocSubmit->id,
                        'addition_id' => $addition
                    ]);
                }
            }
            DB::commit();
            $token=Token::where('user_id',$com->user_id)->select('token')->get();
            return $this->returnData('token',$token);
        } catch(\Exception $ex){
            DB::rollback();
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
        //notifaction
    }//end sendCompleteRequest

    public function changeStatus(Request  $request){
        $rules = [
            'id' => 'required|exists:complete_doc_submit,id',
            'status'=>'required|int|max:2'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        try {
        if ($request->status <3) {
            $row = CompleteDocSubmit::find($request->id);
            $status = $request->status;
            $increceValue = $status == 1 ? 2 : 3;
            $row->status = $increceValue;
            $row->save();
            $text=$increceValue==2?'Your Document has been received successfully':'Your Document has been accepted successfully';

            $doc = \App\CompleteDoc::where('id', $row->complete_doc_id)->select('user_id')->first();

            $user = auth()->guard('api')->user();

            Mail::send([], [], function ($message) use ($user,$text) {

                $message->to($user->email, 'New Document Indeed')->subject
                ('New Request')// here comes what you want
                ->setBody('<h4> Hello, ' . $user->name . ' , </h4> <p> '.$text.' </p>', 'text/html'); // assuming text/plain
                $message->from('info@tameenistore.com', 'Customer Services');
            });
           return $this->returnSuccessMessage('success');
        }
        else return $this->returnSuccessMessage('success'); }
        catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
    }//end changeStatus

    public function hiddenRequest(Request  $request){
        $rules = [
            'id' => 'required|exists:complete_doc_submit,id',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        try {
            $row = CompleteDocSubmit::find($request->id);
            if ($row != null) {
                $row->status = 0;
                $row->save();
                return $this->returnSuccessMessage('sucess');
            }
            else return $this->returnError(99, 'not found');
        }  catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
    }//end hiddenRequest

    public function requestsTameen(){
        $user = auth()->guard('api')->user()->id;
        $rows = CompleteDocSubmit::with('CompleteDocSubmitAddition.addition','user')->where('owner_id',$user)->where('status','!=',0)->get();
//        dd($rows);
        return $this->returnData('rows',$rows);
    }//end fun

    public function getAddations($name,$id){
        $row = \App\CompleteDoc::where('Insurance_Company_ar',$name)
            ->where('insurance_id', $id)->first();
        if ($row) {
            $conRow = \App\Condition::where('insurance_document_id', $row->id)->get();
            //  foreach ($conRow as $con){
            //    $con->items = \App\ConditionItem::where('condition_id', $con->id)->get();
            $items = \App\ConditionItem::where('condition_id', $conRow[0]->id)->get();
            //}
            $additions = \App\Addition::where('insurance_document_id', $row->id)->get();

            return $this->returnData('rows', ['condition' => $conRow, 'items' => $items, 'adds' => $additions]);
        }else return  $this->returnError(99,'not found');
    }//end getAddations

}//end class
