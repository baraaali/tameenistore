<?php

namespace App\Http\Controllers;

use Hash;
use App\Cars;
use App\City;
use App\User;
use App\items;
use App\Price;
use App\Style;
use App\Agents;
use App\brands;
use App\models;
use App\Balance;
use App\country;
use App\Vehicle;
use App\Addition;
use App\Checking;
use App\Mcenters;
use App\CarHolder;

use App\carImages;
use App\carPrices;

use App\Condition;
use App\Insurance;
use Carbon\Carbon;
use App\Exhibition;
use App\membership;
use App\CompleteDoc;
use App\Governorate;
use App\AdsMembership;
use App\AgentBranches;
use App\ConditionItem;
use App\McenterService;
use App\McenterVehicle;
use App\MemberInsurance;
use App\ServiceCategory;
use App\RangeTimeMcenter;
use App\SubscriptionUser;
use App\UserNotification;
use App\CompleteDocSubmit;
use App\ExhibitorBranches;
use App\InsuranceDocument;
use App\Insurancetemplate;
use App\NotificationPrice;
use App\MaintenanceRequest;
use Illuminate\Support\Str;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\InsuranceDocumentBrand;
use App\McenterAdditionalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ControlPanelController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        $this->middleware('auth')->except(['getAdditionalByService']);
    }
     public function index($lang=null)
    {
            $agent = \App\Agents::where('user_id',auth()->user()->id)->first();
            $agent_branch = \App\AgentBranches::where('agent_id',auth()->user()->id)->get();
            $exhibitor = \App\Exhibition::where('user_id',auth()->user()->id)->first();
            $Exhibition_branch = \App\ExhibitorBranches::where('exhibitor_id',auth()->user()->id)->get();
            return view('Cdashboard.index3')
            ->with(['lang'=>$lang,'agent_branch'=>$agent_branch,'Exhibition_branch'=>$Exhibition_branch]);
    }
    public function controlPanel ($lang = null)
    {
//         if(auth()->user()->ended_at != null)
//         {
//             $today = Carbon::now();
//             $endDate = Carbon::parse(auth()->user()->ended_at);
//
//             if($today >= $endDate)
//            {
//             return view('Cdashboard.expired')->with(['lang'=>$lang]);
//             }
//             else
//             {
//                 return view('Cdashboard.index')->with(['lang'=>$lang]);
//             }
//         }
//         else
//         {
//             $memberships = membership::orderBy('cost','asc')->get();
//             return view('Cdashboard.membership')->with(['lang'=>$lang,'memberships'=>$memberships]);
//         }
        $times = [];
        if(Auth()->user()->type == 4)
        $times = RangeTimeMcenter::where('mcenter_id',Auth()->user()->mcenter->id)->get();
        return view('Cdashboard.index')->with([
            'countries' => \App\country::where('status',1)->get(),
            'lang' => $lang,
            'center' => Auth()->user()->mcenter,
            'times' => $times,
            'categories' => ServiceCategory::where('status','1')->get()

        ]);
    }

    public function showBalance($lang=null){
        $balance=Balance::where('user_id',auth()->user()->id)->first();
        return view('Cdashboard.show_balance')->with(['lang'=>$lang,'balance'=>$balance]);
    }

   

    public function getGovernorates(Request $request)
    {
        $ids = $request->input('ids');
        if(!is_null($ids) && !empty($ids))
        {
            $governorates  = Governorate::whereIn('country_id',$ids)->get();
            return response()->json($governorates, 200);
        }
        return response()->json([], 200);
    } 
     public function getCities(Request $request)
    {
        $ids = $request->input('ids');
        if(!is_null($ids) && !empty($ids))
        {
            $cities  = City::whereIn('governorate_id',$ids)->get();
            return response()->json($cities, 200);
        }
        return response()->json([], 200);
    }


    // show single insurances 
    public function insuranceSingle($lang=null)
    { 
        $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
        $insurance_document = Insurancetemplate::where('user_id',auth()->user()->id)->get();
        $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
        $merge_insurance =$insurance_document->merge( $complete_insurance);

        return view('dashboard.insurance-user.index')
        ->with(['lang'=>$lang,'merge_insurance'=>$merge_insurance ,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }

    // show create single insurance
    public function inDocumentCreate($lang=null){
        //        $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
                $uses=Style::all();
                $id=auth()->user()->id;
                $check=checkUploadDocument();
                $vehicles  = \App\Vehicle::where('status','1')->get();
                $type=1;
                $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
                $insurance_document = \App\InsuranceDocument::where('user_id',auth()->user()->id)->get();
                $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
                $merge_insurance =$insurance_document->merge( $complete_insurance);
                $view2=view('dashboard.insurance-user.create')->with(['lang'=>$lang,'insurance'=>$insurance,'vehicles'=>$vehicles,'complete_insurance'=>$complete_insurance,'merge_insurance'=>$merge_insurance,'insurance_document'=>$insurance_document,
                    'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
                $view=view('dashboard.insurance-user.select_new_membership',compact('lang','type','vehicles'));
                if ($check==1) return redirect()->route('my-home')->with('success','من فضلك قم برفع المستندات المطلوبه اولا  ' );
                $status=Checking::where(['user_id'=>$id,'type'=>1])->orderBy('id','Desc')->first();
                if (isset($status)) {
                    if ($status->status==0) return $view2;
                    else return $view;
                }
                
                return $view;
            }
            
    // store single insurance
    public function ddElgher(Request $request){

        $request->validate([
           // 'model_id'=>'required',
            'type_of_use'=>'required',
            'Insurance_Company_ar'=>'required',
            'Insurance_Company_en'=>'required',
            'deliveryFee'=>'required|integer',
            'ar_term'=>'required',
            'en_term'=>'required',
            'vehicle_id'=>'required',
            'logo'=>'required|image|max:7000',
        ]);
       $logo_name = '';
//       $country=country::first()->id;
        $user_id=auth()->user()->id;
        $country=auth()->user()->country->id;
        if($request->file('logo')){
            $imageName = $request->Insurance_Company_ar.'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads'), $imageName);
              $logo_name = $imageName;
                }
       /// $sub=SubscriptionUser::where(['user_id'=>$user_id,'type'=>'1'])->latest()->first()->end_date;

       // if ($sub<date('Y-m-d')) return redirect()->route('selectMembership')->with('success','انتهت مده اشتراكك من فضلك قم بالتجديد');
//to do 11-11
        $sub=Checking::where(['user_id'=>$user_id,'type'=>1])->orderBy('id','Desc')->first();
        //if ($sub<date('Y-m-d')) return redirect()->route('selectMembership')->with('success','انتهت مده اشتراكك من فضلك قم بالتجديد');
        $time=date('Y-m-d');
        $end_date =date('Y-m-d', strtotime($time . " +$sub->duration days"));
        $year = date("Y");
        $row=Insurancetemplate::create($request->all()+['year'=>$year,
                'end_date'=>$end_date,'user_id'=>$user_id,'country_id'=>$country]);
      $row->logo=$logo_name;
      $row->save();
      $sub->update(['status'=>1]);
        return redirect('dashboard/insurance')->with('success','تم الحفظ');

    }

    // Edit single insurance
    public function inDocumentEdit($id , $lang=null)
    {
        $id = Insurancetemplate::where('id',$id)->first();
        if($id)
        {
         return view('dashboard.insurance-user.edit')->with(['lang'=>$lang,'document'=>$id]);
        }
        else
        {
            return back();
        }
    }

    // update single insurance
    public function inDocumentUpdate(Request $request)
    {
        $request->validate([
            'type_of_use'=>'required',
            'Insurance_Company_ar'=>'required',
            'Insurance_Company_en'=>'required',
            'deliveryFee'=>'required|integer',
            'ar_term'=>'required',
            'en_term'=>'required',
            'precent'=>'required|integer',
            'discount_q'=>'required|integer',
            'start_disc'=>'required',
            'end_disc'=>'required|date|after:start_disc',
        ]);

        $doc = Insurancetemplate::where('id',$request->insurance_id)->first();
        $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
        $doc->Insurance_Company_en = $request->Insurance_Company_en;
        $doc->deliveryFee = $request->deliveryFee;
        $doc->ar_term= $request->ar_term;
        $doc->en_term = $request->en_term;
        $doc->user_id = auth()->user()->id;
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

         unset($arr['id']);
         unset($arr['vehicle_id']);
         
         $ins=new InsuranceDocument();
        $ins->where('user_id',auth()->user()->id)->update($arr);
        return redirect('dashboard/insurance')->with('success','تم الحفظ');
    }
   // renew single insurance
    public function renewTammeen($id,$type=0,$lang=null){
        return view('dashboard.insurance-user.renew',compact('type','lang','id'));
    }
   // select NewMembership insurance
    public function selectNewMembership(Request  $request,$lang=null){
        $membership=MemberInsurance::find($request->membership);
        //dd($membership);
       $type=$request->type;
       $id=auth()->user()->id;
      // DB::beginTransaction();

//       try {
           if ($membership->price == '0') {
               insertRow($id, $type, $membership->duration);
               //DB::commit();
               if ($type == '0') return redirect()->route('all_complete')->with('success', 'يمكنك الان الاضافه .... تم الاشتراك بنجاح');
               else return redirect()->route('dashboard-insurance')->with('success', 'يمكنك الان الاضافه .... تم الاشتراك بنجاح');
           } else {
               DB::beginTransaction();
               try {
               $price = $membership->price;
               $checked = checkUserBalance($id, $price);
               $balance=Balance::where('user_id',$id)->first();
               if ($checked == 0) return redirect()->back()->with('success', 'ليس لديك رصيد كافى ... من فضلك قم بشحن رصيدك');
               else {
                   $balance_before=$balance->balance;
                   $balance_after=$balance_before- $price;
                   transaction($id, 'out', $price, 'membership', -2,$balance_before,$balance_after);
                   if ($type == 0) {
                       $company = CompleteDoc::where('id', $request->id)->first()->Insurance_Company_en;
                   } else {
                       $company = Insurancetemplate::find($request->id);
                   }
                   checkMembership($membership, $id, $type, $company, $request->id);
                   DB::commit();
                   if ($type == 0) return redirect()->route('all_complete')->with('success', 'تم الاشتراك فى العضويه');
                   else return redirect()->back()->with('success', 'تم الاشتراك بنجاح');
                  // DB::commit();
               }}catch (\Exception $e) {
                       DB::rollback();
                       return redirect()->back()->with('success', 'حدث خطا ما');
                   }
               }
           }
   // add new car to insurance
   public function addNew($id,$lang=null){
    $status=checkUserSubscription('1');
     $type=1;
     $route='add';
     if ($status !=0){
         return view('dashboard.insurance-user.select_membership',compact('lang','status','type','route'));
     }
     $doc=Insurancetemplate::where('id',$id)->first();
     $brands = \App\brands::where('status',1)->where('vehicle_id',$doc->vehicle_id)->get();
     
     return view('dashboard.insurance-user.addNewBrand')->with(['lang'=>$lang,'document'=>$id,'brands'=>$brands,'models'=>\App\models::get()]);
  
    }

    // save brand to car insurance
    public function addBrands($id,$lang=null,Request  $request){
          $request->validate([
              'model_id'=>'required|array',
          ]);
         // dd($request->all());
          $brandModels = explode(',', $request->model_id[0]);
          $brand_id = $brandModels[1];
          $models = [];
          foreach ($request->model_id as $value) {
              array_push($models,explode(',', $value)[0]);
          }
          $doc=Insurancetemplate::find($id)->toArray();
          array_shift($doc);
          $user_id=$doc['user_id'];
          $insurance_id=Insurance::where('user_id',$user_id)->first()->id;
         for ($key=0;$key<count($request->firstinterval);$key++) {
             if ($request->firstinterval[$key] != null) {
                 if(!isset($models[$key])){
                    return redirect()->back()->with('error','يجب إختيار مديل');
                }
                 $data = $doc + [
                    'other_id' => $id,
                    'insurance_id' => $insurance_id,
                    'model_id' => $models[$key],
                    'brand_id' => $brand_id,
                    'price' => floatval($request->price[$key]),
                    'firstinterval' => floatval($request->firstinterval[$key]),
                    'secondinterval' => floatval($request->secondinterval[$key]),
                    'thirdinterval' => floatval($request->thirdinterval[$key]),
                    'country_id' => auth()->user()->Country->id
                 ];
                 InsuranceDocument::create($data);
               
             }
         }
         //dd($insuranceDocuments);
  
          return redirect()->back()->with('success','تم الحفظ');
  
      }
    // show insurance brands
     public function showBrands($id,$lang=null){
        $rows=InsuranceDocument::where(['user_id'=>auth()->user()->id,'other_id'=>$id])->get();
        $brands = brands::whereIn('id',$rows->pluck('brand_id'))->get();
        $doc_id = $id;
        return view('dashboard.insurance-user.getAllBrands',compact('lang','rows','brands','doc_id'));
   }
   public function deleteSingleDoc($id){
    $doc=InsuranceDocument::where('id',$id)->first();
    if(empty($doc)) abort(404);
    $doc->delete();
    return back();

   }
   // delete single insurance
   public function cmforce($id)
   {
       if($id != null)
       { //dd('dd');
           Insurancetemplate::find($id)->delete();
           return redirect('dashboard/insurance')->with('success','تم الحذف');
       }
       else
       {
           return back();
       }
   }
   // ------------------------------complete insurance----------------------------- //
   // show insurance Complete
   public function insuranceComplete($lang = null)
   {
    $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
    $insurance_document = \App\InsuranceDocument::where('user_id',auth()->user()->id)->get();
    $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
    $merge_insurance =$insurance_document->merge( $complete_insurance);

    return view('dashboard.insurance-complete-user.index')
    ->with(['lang'=>$lang,'merge_insurance'=>$merge_insurance ,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);

   }

    // create insurance Complete
   public function inDocumentCreateComplete($lang=null){
    $status=checkUserSubscription('0');
    //dd($status);
    $type='0';
    $route='create';
    if ($status !=0){
        return view('dashboard.insurance-complete-user.select_membership',compact('lang','status','type','route'));
    }
    $check=checkUploadDocument();
    if ($check==1) return redirect()->route('my-home')->with('success','من فضلك قم برفع المستندات المطلوبه اولا  ' );

    $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
    $vehicles  = \App\Vehicle::where('status','1')->get();
    $uses=Style::all();
    return view('dashboard.insurance-complete-user.create')->with(['lang'=>$lang,'insurance'=>$insurance,'vehicles'=>$vehicles,'uses'=>$uses]);
}

// store complete insurance
public function saveCompleteData(Request $request){
    $request->validate([
        'type_of_use' =>'required',
        'Insurance_Company_ar' =>'required',
        'Insurance_Company_en' =>'required',
        'deliveryFee' =>'required',
        'ar_term' =>'required',
        'en_term' =>'required',
        'max_value' =>'required',
        'max_year' =>'required',
        'ToleranceratioCheck' =>'required',
        'Tolerance_ratio'  =>'required',
        'ToleranceYearPerecenteage' =>'required' ,
        'ConsumptionRatio'  => 'required',
        'ConsumptionFirstRatio' =>'required',
        'YearPerecenteage' =>'required',
        'ConsumptionYearPerecenteage' =>'required',
        'last_percent'=>'required',
        'last_percent_en'=>'required',
        'vehicle_id'=>'required',
        'logo'=>'required|image|max:5000|mimes:jpeg,jpg,png'
    ]);

    $user=auth()->user()->id;
    $document=CompleteDoc::where('user_id',$user)->first();
    //dd($user);
    $insurance=Insurance::where('id',$request->insurance_id)->first();
        $model=models::first()->id;
        $brand=brands::first()->id;
    if($request->file('logo')){
        $imageName = time().'.'.request()->logo->getClientOriginalExtension();
        request()->logo->move(public_path('uploads'), $imageName);
    }
    $year = date("Y");
    $logo = $imageName;
    $country=auth()->user()->country->id;
    //dd($country);
    $sub=SubscriptionUser::where(['user_id'=>$user,'type'=>'0'])->latest()->first()->end_date;
    if ($sub<date('Y-m-d')) return redirect()->route('selectMembership')->with('success','انتهت مده اشتراكك من فضلك قم بالتجديد');
    $end_date = $sub;
    $mix=$year-$request->max_year;
    $requestData=[
        'type_of_use' =>$request->type_of_use,
        'Insurance_Company_ar' =>$request->Insurance_Company_ar,
        'Insurance_Company_en' =>$request->Insurance_Company_en,
        'deliveryFee' =>$request->deliveryFee,
        'ar_term' =>$request->ar_term,
        'en_term' =>$request->en_term,
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
        'country_id'=>$country,
        'vehicle_id'=>$request->vehicle_id,
        'display'=> 1,
    ];
    //dd($requestData);

        $row = CompleteDoc::create($requestData);

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
        'insurance_document_id' =>  $row->id
    ];
        $rowCon = Condition::create($arrCon);

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
    foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
        $Addition = Addition::create(
            [
                'FeatureNameAr' => $FeatureNameAr,
                'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                'FeatureCost' => $request->FeatureCost[$keyAddition],
                'FeatureNotices' => $request->FeatureNotices[$keyAddition],
                'insurance_document_id' =>  $row->id
            ]
        );
    }
    return redirect()->route('all_complete')->with('success','تم الحفظ');

}

// edit complete insurance

public function cmDocumentEdit($id , $lang=null)
{
    $id = \App\CompleteDoc::where('id',$id)->first();
    if($id)
    {
  //   return view('Cdashboard.Insurance_CFull')->with(['lang'=>$lang,'document'=>$id,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    return view('dashboard.insurance-complete-user.edit')->with(['lang'=>$lang,'document'=>$id,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }
    else
    {
        return back();
    }
}

// update complete insurance
public function generalDocCreateUpdate(Request $request){

    $request->validate([
        'type_of_use' =>'required',
        'Insurance_Company_ar' =>'required',
        'Insurance_Company_en' =>'required',
        'precent' =>'required',
        'deliveryFee' =>'required',
        'ar_term' =>'required',
        'en_term' =>'required',
        'max_value' =>'required',
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
        'max_year'=>'required',
        'FeatureNameAr'=>'required|array',
        'FeatureNameEn'=>'required|array',
        'FeatureCost'=>'required|array',
        'FeatureNotices'=>'required|array',
        'AddonNameAR'=>'required|array',
        'AddonNameEn'=>'required|array',
        'AddonMaxYear'=>'required|array',
        'AddonUnkownMaxmum'=>'required|array',
    ]);

    $user=auth()->user()->id;
    $document=CompleteDoc::where('id',$request->id)->first();
   // dd($document);
    $insurance=Insurance::where('id',$request->insurance_id)->first();
        $model=$document->model_id;
        $brand=$document->brand_id;
    if($request->file('logo')){
        $imageName = time().'.'.request()->logo->getClientOriginalExtension();
        request()->logo->move(public_path('uploads'), $imageName);
    }
    $fake=isset($request->fake_discount)?0:1;
    $year = date("Y");
    $logo = $imageName??$document->logo;
    $end_date = auth()->user()->ended_at;
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
        'insurance_id'=>$insurance->id,
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
    //return redirect()->back()->with('success','تم الحفظ');
    return redirect()->route('all_complete')->with('success','تم الحفظ');

}
// add new cars to complete brand
public function addBrand($id,$lang=null){
    $status=checkUserSubscription('0');
  //  dd($status);
    $type='0';
    $route='add';
    if ($status !=0){
        return view('dashboard.insurance-complete-user.select_membership',compact('lang','status','type','route'));
    }
    $document=CompleteDoc::where('id',$id)->first();
    // dd($brands);
    $vehicle_id = $document->vehicle_id;
    $brands = brands::where('vehicle_id',$vehicle_id)->where('status',1)->get();
    return view('dashboard.insurance-complete-user.add_brand',compact('document','lang','brands'));
}
// show cars of an complete insurance
public function getAllBrands($name,$lang=null){
    $user_id = auth()->user()->id;
    $vehicle_id = 0;
    $brands=CompleteDoc::where(['Insurance_Company_ar'=>$name,'display'=>1,'user_id'=>$user_id])
        ->get()->groupBy('brand_id');
     $doc =  CompleteDoc::where(['Insurance_Company_ar'=>$name,'display'=>1,'user_id'=>$user_id])->first();
    if(!empty($doc))
    $vehicle_id = $doc->vehicle_id;
    $allBrands = brands::whereIn('id',array_keys($brands->toArray()))->get();
    return view('dashboard.insurance-complete-user.all_brands',compact('brands','name','lang','vehicle_id','allBrands'));
}
public function getAllBrandsByAjax($brand_id,$model_id,$name,$passengers,$shape,$lang=null){
    $user_id = auth()->user()->id;

    $brands=CompleteDoc::where(['Insurance_Company_ar'=>$name,'display'=>1,'user_id'=>$user_id]);
    
    if($brand_id){
        $brands = $brands->where('brand_id',$brand_id);
    }
    if($model_id){
        $brands = $brands->where('model_id',$model_id);
    }
    if($passengers){
        $brands = $brands->whereHas('idmodel',function($q) use($passengers){
            $q->where('passengers',$passengers);
        });
    }
    if($shape){
        $brands = $brands->whereHas('idmodel',function($q) use($shape){
            $q->where('care_shape_id',$shape);
        });
    }
    $brands =  $brands->get()->groupBy('brand_id');
   
    $view = strval(view('dashboard.insurance-complete-user.complete-selected-brands',compact('brands','name')));
    $count = count($brands);
    return response()->json(compact('count','view'), 200);
}

// search for cars in complete insurance
public function getAllBrandsSearch(Request  $request,$lang=null){
    $user_id = auth()->user()->id;
    $conditions = ['display'=>1,'user_id'=>$user_id];
    if(!is_null(session()->get('selected_value')) && intval( session()->get('selected_value')) != -1){
        $country_id = intval( session()->get('selected_value'));
        array_push($conditions,['country_id','=',$country_id] );
    }
    
    $models=models::where('name', 'LIKE', '%' . $request->search . '%')->pluck('id');
    $brands=CompleteDoc::where($conditions)->whereIn('model_id',$models)->get()
    ->groupby('brand-id');
   // dd($brands);
    return view('dashboard.insurance-complete-user.all_brands',compact('brands','lang'));
}

// delete complete insurance
public function deleteDoc($id){
      $row=CompleteDoc::where('id',$id)->first();
      DB::beginTransaction();
      try {
      if ($row){
          $name=$row->Insurance_Company_ar;
          $user_id=auth()->user()->id;

          $coms=CompleteDocSubmit::where('complete_doc_id',$id);
          if (count($coms->get())>0) $coms->delete();

          $doc = CompleteDoc::where(['Insurance_Company_ar'=>$name,'user_id'=>$user_id]);
          if(count($doc->get()))  $doc->delete();
  
        $adds=Addition::where('insurance_document_id',$id);
        if (count($adds->get())>0){
            $adds->delete();
        }
         DB::commit();
          return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
      }
      else return redirect()->back()->with(['success'=>'هذا العنصر غير موجود']);
          
        }  
           catch(\Exception $ex){
          DB::rollback();
          return $this->returnError($ex->getCode(),$ex->getMessage());
      }//
  }

  public function showMcenterService($id){
    if(!empty($id))
    {
        $service =  McenterService::where('id',$id)->get()->first();
        $vehicles = McenterVehicle::where('status','1')->get();
        return view('dashboard.modals.new-mcenter-service')
        ->with([
            'service_edit'=>$service,
            'vehicles'=>$vehicles,
        ]);

    }
    return;
}
public function showAdditionalMcenterService($id){
    if(!empty($id))
    {
        $service_edit =  McenterAdditionalService::where('id',$id)->get()->first();
        $mcenter_services = McenterService::where('status','1')->get();
        return view('dashboard.modals.new-additional-mcenter-service',compact('mcenter_services','service_edit'));

    }
    return;
}

  public function getAdditionalByService(Request $request){
    $ids = $request->ids;
     if(!empty($ids))
     {
         return McenterAdditionalService::whereIn('mcenter_service_id',$ids)->
         where('status','1')->get();
     }
     return;
 }

  public function mcenterServices(Request $request,$lang = null){
    if($request->isMethod('post'))
    {
        $request->validate([
            'ar_name'=>'required',
            'en_name'=>'required',
            'ar_description'=>'required',
            'en_description'=>'required',
            'mcenter_vehicle_id'=>'required',
        ]);
        $data = $request->all();
        $data['status'] = !is_null($request->status) ? '1' : '0';
        if($request->id)
        {
            unset($data['_token']);
            McenterService::where('id',$request->id)->update($data);
            return back()->with(['success'=>'تم الحفظ']);
        }
        $data['mcenter_id']  = Mcenters::where('user_id',auth()->user()->id)->first()->id;
        McenterService::create($data);
        return back()->with(['success'=>'تم الحفظ']);
    }
    $services = McenterService::where('mcenter_id',auth()->user()->mcenter->id)->paginate();
    $vehicles = McenterVehicle::where('status','1')->get();
    return view('dashboard.mcenters-services.index',compact('lang','services','vehicles'));
} 
   public function deleteMcenterService(Request $request)
   {
       $service = McenterService::where('id',$request->id);
       if($service)
       {
           $service->delete();
       }
       return;
   }
   public function changeStatusMcenterRequests(Request $request){
    $status = $request->status;
    $id = $request->id;
    $mc_requests   = MaintenanceRequest::where('id',$id)->first();    
    if($mc_requests)
    {
    $mc_requests = $mc_requests->update(['status'=>$status]);
    session()->flash('success','تم حفظ البيانات');
    return true;
    }
    return false ;
}
    public function updateMyAgnecyInfo(Request $request){
//dd($request->all());
        $Agency = Agents::find($request->agent_id);
       // dd($Agency);
        $Agency->fill($request->except(['image','_token','agent_id']));
        if($request->image){
            $file =  $request->file('image');
            $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);
            $Agency->image = $imageName;
        }
        $Agency->save();

        return redirect()->back()->with(['message' => 'Banner updated successfully']);

    }

    public function updateMcenter(Request $request)
    {
        
        $mcenter =  Mcenters::where('id',$request->id)->first();
        $data = $request->all();
        // update image
        if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $data['image'] = $imageName;
        }
         // update day times
       if($mcenter->id)
       {
           $days =  $request->day;
           if(!is_null($days) && count($days)){
           $times = [];
           foreach ($days as $i => $day) {
             $start_times = $request->start_time;
             $end_times = $request->end_time;
              if(!is_null($start_times[$i]) && !is_null($end_times[$i]) &&  !is_null($day) ){
              $e = ['mcenter_id'=>$mcenter->id,'day' => $day,'start_time'=> $start_times[$i],'end_time'=>$end_times[$i]];
              array_push($times,$e);
              }
           }
           if(count($times))
           {
            RangeTimeMcenter::where('mcenter_id',$mcenter->id)->delete();
            RangeTimeMcenter::insert($times);
           }
           }
       }
        $mcenter->update($data);
        return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح']);

    }

    public function updateMyExhibitorInfo(Request $request){
//dd($request->all());
        $Agency = Exhibition::where('id',$request->agent_id)->first();

        if($request->country_id){
            $Agency->country_id = $request->country_id;
        }

        if($request->en_name){
            $Agency->en_name  = $request->en_name;
        }


        if($request->ar_name){
            $Agency->ar_name  = $request->ar_name;
        }

        if($request->en_description){
            $Agency->en_description  = $request->en_description;
        }

         if($request->ar_description){
            $Agency->ar_description  = $request->ar_description;
        }

        //  if($request->phones){
        //     $Agency->phones  = $request->phones;
        // }


         if($request->fb_page){
            $Agency->fb_page  = $request->fb_page;
        }


         if($request->instagram){
            $Agency->instagram  = $request->instagram;
        }



         if($request->twitter_page){
            $Agency->twitter_page  = $request->twitter_page;
        }

     if($request->website){
            $Agency->website  = $request->website;
        }



     if($request->email){
            $Agency->email  = $request->email;
        }


     if($request->google_map){
            $Agency->google_map  = $request->google_map;
        }

         if($request->days_on){
            $Agency->days_on  = $request->days_on;
        }


         if($request->times_on){
            $Agency->times_on  = $request->times_on;
        }



         if($request->car_type){
            $Agency->car_type  = $request->car_type;
        }


         if($request->image){
                     $file =  $request->file('image');
                     $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                     $file->move(public_path('uploads'), $imageName);
                     $Agency->image = $imageName;
                }
                     $Agency->save();
         return back()->with(['message'=>'Ok..']);


    }


    public function AddNewAgencyBranch(Request $request){

    }

    public function EditAgencyBranch(Request $request){

    }

    public function SoftDeleteAgencyBranch($id){

    }

    public function ForceDeleteAgencyBranch($id){

    }

// 
    public function MyAds(Request $request, $lang = null)
    {
       // $carHolder = CarHolder::where('is_user',auth()->user()->id)->get();
        $conditions = auth()->user()->guard == 1 ? [] : [['user_id','=',auth()->user()->id]];

        $cars = Cars::where($conditions)->where('sell',0)->paginate();
        $view = 'dashboard.cars-rent.index';

        if($request->isMethod('post'))
        {
            $membership = $request->input('membership');
            $order = $request->input('order');
            $search = $request->input('search');
            $status = $request->input('status');
            $filters = [];
            foreach ($request->all() as $filter => $value) {
                if($filter != 'membership' && $filter != 'order' && $filter != 'search')
                    array_push($filters,[$filter,'=',$value]);
            }
            $items =  \App\Cars::where($filters);
           
            if(!is_null($search))
            {
            $columns =   Schema::getColumnListing('cars');
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
            $items->whereHas('memberships',function($q) use ($membership){
                $q->where('type',$membership);
            });

            if(!is_null($order))
            $items->orderBy(explode('-',$order)[0],explode('-',$order)[1]);

            $cars =  $items->where($conditions)->paginate();
            $view = "dashboard.cars-sell.table";
        }

         return view($view)->with(['items'=>$cars,'lang'=>$lang,'countries'=>\App\country::where('status',1)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }


     public function CrAds($lang = null)
    {
        $check=checkUploadDocument();
        if ($check==1) return redirect()->route('my-home')->with('success','من فضلك قم برفع المستندات المطلوبه اولا  ' );
        $carHolder = CarHolder::where('is_user',auth()->user()->id)->get();
        $cars = Cars::whereIn('id',$carHolder->pluck('car_id'))->get();
        $vehicles = Vehicle::where('status','1')->get();
        //dd($cars);
        //return view('Cdashboard.index2C')->with(['ads'=>$cars,'vehicles'=>$vehicles,'lang'=>$lang,'countries'=>\App\country::where('status',1)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
        return view('dashboard.cars-rent.create')->with(['ads'=>$cars,'vehicles'=>$vehicles,'lang'=>$lang,'countries'=>\App\country::where('status',1)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }

    public function Adedit($Ad ,$lang=null)
    {
        $Ad = Cars::where('id',$Ad)->first();

        if($Ad)
        {
            return view('dashboard.cars-rent.edit')->with(['Ads'=>$Ad,'lang'=>$lang,'countries'=>country::where('parent',0)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
        }
        else{
            return back();
        }


    }

     public function Adstore(Request $request)
     {
         $request->validate([
             'country_id' => 'required|int',
             'vehicle_id' => 'required|int',
             'governorate_id'=>'required',
             'city_id'=>'required',
             'ar_brand' => 'required|int',
             'ar_model' => 'required|int',
       ///      'number_days' => 'required|int|min:1',
             'ar_name' => 'required',
             'main_image' => 'required|image|max:7000',
             'en_name' => 'required',
             'ar_description' => 'required',
             'en_description' => 'required',
             'images' => 'array|min:1',
             'cost' => 'required',
              'year' => 'required|int',
              'color' => 'required',
             'used' => 'required',
             'special'=>'required|int|exists:ads_membership,id',
             'en_features' => 'required',
             'ar_features' => 'required',
             'talap' => 'required',
             'rent_type' => 'required',
         ]);
        //  dd($request->all());

        $user_id=auth()->user()->id;
        $balance=Balance::where('user_id',$user_id)->first();
        $price=AdsMembership::where('id',$request->special)->first();
        //dd($price);
        if ((isset($price) &&$price->price==0) || auth()->user()->guard == 1){
            $this->addCar($request);
            return redirect()->back()->with('success','تم الحفظ');
        }
        else{

            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $car=$this->addCar($request);
                  //  $days=$request->number_days;
                    $total=$price->price;
                    $user_balance=$balance->balance - $total;
                    $balance->update(['balance'=>$user_balance]);
                    transaction($user_id,'out',$total,'car',$car);
                    return redirect()->back()->with('success','تم الحفظ');
                }
                else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
            }//end isset
            else return redirect()->back()->with('success','عفوا ليس لديك رصيد كافى ');
        }//end else

    }//end fun

    public function renewAdsFromBalance(Request  $request){

        $request->validate([
           // 'number_days' => 'required|int|min:1',
            'special'=>'required|int|exists:ads_membership,id',
        ]);
        $ad=Cars::find($request->ad);
        $price=AdsMembership::where('id',$request->special)->first();
        $day = date('Y-m-d');
        if ($ad->end_ad_date<$day)
        $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        else $NewDate = date('Y-m-d', strtotime($ad->end_ad_date . " +".$price->duration." days"));
        $user_id=auth()->user()->id;
        $balance=Balance::where('user_id',$user_id)->first();

        //dd($price);
        if (isset($price) &&$price->price==0){
           $ad->update(['end_ad_date'=>$NewDate]);
            return redirect()->back()->with('success','تم تجديد الاعلان');
        }
        else{

            if (isset($balance)){
                if ($balance->balance >=$price->price){
                    $ad->update(['end_ad_date'=>$NewDate]);
                 //   $days=$request->number_days;
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



    // save car fo rent
    public function addCar(Request  $request){
        $user = auth()->user();
        $user_id = $user->id;
        $agent = Agents::where('user_id', $user_id)->first();
        $agent_id = $agent ? $agent->id : 0;
        $membership = \App\membership::where('id',auth()->user()->membership_id)->first();
        $price=AdsMembership::where('id',$request->special)->first();
        if($request->file('main_image')){
            $imageName = $request->en_name.'.'.request()->main_image->getClientOriginalExtension();
            request()->main_image->move(public_path('uploads'), $imageName);
        }
        $day = date('Y-m-d');
        $NewDate = date('Y-m-d', strtotime($day . " +".$price->duration." days"));
        $car = new Cars();
      //  dd($request->all());

        $car->en_name = $request->en_name;
        $car->ar_name = $request->ar_name;
        $car->end_ad_date = $NewDate;
        $car->ar_model = $request->ar_model;
        $car->vehicle_id = $request->vehicle_id;
        $car->en_model = $request->ar_model;
        $car->ar_brand = $request->ar_brand;
        $car->main_image = $imageName;
        $car->agent_id =  $agent_id;
       // $car->ads_member =$request->special;
        $car->category_id = $request->category_id;
        $car->year = $request->year;
        $car->country_id = $request->country_id;
        $car->governorate_id=$request->governorate_id;
        $car->city_id = $request->city_id;

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
        $car->sell = 0;
        $car->user_id = $user_id;

        if (auth()->user()->type==3){
            $car->rent_type = $request->rent_type;
            $car->sell = 0;
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

     public function Adupdate(Request $request)
    {   //dd($request->all());

        $request->validate([
            'country_id'=>'required|int',
            'ar_brand'=>'required|int',
            'ar_model'=>'required|int',
            'ar_name' => 'required',
            'en_name' => 'required',
            'ar_description' => 'required',
            'en_description' => 'required',
            'cost' => 'required',
            'year' => 'required',
            // 'type_of_car' => 'required',
            'used' => 'required',
            'en_features' => 'required',
            'ar_features' => 'required',
           // 'sell' => 'required',
            'talap' => 'required',
        ]);

        $car =  Cars::where('id',$request->id)->first();
        if(auth()->user()->type==3){
            $car->rent_type = $request->rent_type;
        }
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
        $car->sell = 0;
        $car->kilo_meters = $request->kilometers;
//        $car->special = $request->special;
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

        $Agent = Agents::where('user_id',auth()->user()->id)->first();
        $Exhibitor = Exhibition::where('user_id',auth()->user()->id)->first();
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



        return redirect('/cp/ads/ar');
    }
      public function Adforce($country)
    {
        if($country != null)
        {
            Cars::where('id',$country)->forceDelete();
            return redirect('/cp/ads/ar')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }





    public function agBranchStore(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent = new AgentBranches();
        $agent->agent_id = $request->agent_id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $agent->image = $imageName;
        }
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;
        $agent->car_type = $request->car_type;
        $agent->special = 1;
        $agent->status = 1;
        $agent->phones = $request->phones;
        $agent->save();
        return redirect('Cdashboard/branches')->with('success','تم الحفظ');
    }
     public function agBranchUpdate(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent =  AgentBranches::where('id',$request->id)->first();
        $agent->agent_id = auth()->user()->id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $agent->image = $imageName;
        }
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;
        $agent->car_type = $request->car_type;
        $agent->special = 1;
        $agent->status = 1;
        $agent->phones = $request->phones;
        $agent->save();
        return redirect('Cdashboard/branches')->with('success','تم الحفظ');

    }


    public function exBranchStore(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);
        $exhibitor = new ExhibitorBranches();
        $exhibitor->exhibitor_id = $request->exhibitor_id;
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;
         if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $exhibitor->image = $imageName;
        }
        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_type;
        $exhibitor->special = $request->specific;
        $exhibitor->status = $request->status;
        $exhibitor->instagram = $request->instagram;
        $exhibitor->special = 0;
        $exhibitor->status = 1;
        $exhibitor->save();
        return redirect('Cdashboard/branches')->with('success','تم الحفظ');
    }

    public function exBranchUpdate(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $exhibitor = ExhibitorBranches::where('id',$request->id)->first();
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;
         if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $exhibitor->image = $imageName;
        }
        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_type;
        $exhibitor->special = 0;
        $exhibitor->status = 1;
        $exhibitor->instagram = $request->insta_page;

        $exhibitor->save();


        return redirect('Cdashboard/branches')->with('success','تم الحفظ');

    }
     public function agforce($id)
    {
        if($id != null)
        {
            AgentBranches::where('id',$id)->forceDelete();
            return redirect('Cdashboard/branches')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
     public function exforce($id)
    {
        if($id != null)
        {
            ExhibitorBranches::where('id',$id)->forceDelete();
            return redirect('Cdashboard/branches')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
    public function generalDocCreateUpdate_old(Request $request){

        $request->validate([
            'type_of_use' =>'required',
            'Insurance_Company_ar' =>'required',
            'Insurance_Company_en' =>'required',
            'deliveryFee' =>'required',
            'ar_term' =>'required',
            'max_value' =>'required|int',
            'en_term' =>'required',
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
        ]);

        $user=auth()->user()->id;
        $document=CompleteDoc::where('user_id',$user)->first();
        //dd($user);
        $insurance=Insurance::where('user_id',$user)->first();
        if ($request->create=='create'){
            $request->validate([
                'logo'=>'required|image|max:5000|mimes:jpeg,jpg,png'
            ]);

            $model=models::first()->id;
            $brand=brands::first()->id;
        }else{
            $model=$document->model_id;
            $brand=$document->brand_id;
        }
        if($request->file('logo')){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads'), $imageName);
        }
        $year = date("Y");
        $logo = $imageName??$document->logo;
        $end_date = auth()->user()->ended_at;
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
            'price'=>0,
            'insurance_id'=>$insurance->id,
            'logo'=>$logo,
            'year'=>$year,
            'user_id'=>$user,
            'end_date'=>$end_date,
            'model_id'=>$model,
            'brand_id'=>$brand,
        ];
        if($document !=null)  {
            $document->update($requestData);
            $row=$document;
        }
        else{
            $row = CompleteDoc::updateOrCreate($requestData);
        }
        $arrCon=[
            'ToleranceratioCheck' =>  $request->ToleranceratioCheck,
            'Tolerance_ratio'  =>  $request->Tolerance_ratio,
            'ToleranceYearPerecenteage' =>  $request->ToleranceYearPerecenteage ,
            'ConsumptionRatio'  =>  $request->ConsumptionRatio,
            'ConsumptionFirstRatio' =>  $request->ConsumptionFirstRatio,
            'YearPerecenteage' =>  $request->YearPerecenteage,
            'ConsumptionYearPerecenteage' =>  $request->ConsumptionYearPerecenteage,
            'last_percent'=>$request->last_percent,
            'insurance_document_id' =>  $row->id
        ];
        $con=Condition::where('insurance_document_id',$row->id)->first();
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
        $addition=Addition::where('insurance_document_id',$row->id)->delete();
        foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
            $Addition = Addition::create(
                [
                    'FeatureNameAr' => $FeatureNameAr,
                    'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                    'FeatureCost' => $request->FeatureCost[$keyAddition],
                    'FeatureNotices' => $request->FeatureNotices[$keyAddition],
                    'insurance_document_id' =>  $row->id
                ]
            );
        }
        return redirect()->back()->with('success','تم الحفظ');

    }//end generalDocCreateUpdate


    public function docChangeStatus(Request $request)
    {
        $row=CompleteDoc::find($request->company_id);
        $coms = CompleteDoc::where(['user_id'=>$row->user_id,'Insurance_Company_ar'=>$row->Insurance_Company_ar])->get();
        foreach ($coms as $com){
            $com->status = $request->status;
            $com->save();
        }

        return response()->json(['success'=>'Status change successfully.']);
    }


    public function docChangeShowStatus(Request $request)
    {  //dd($request->status);
        $row=CompleteDoc::find($request->company_id);
      //dd($row);
            $row->search_show = $request->status;
            $row->save();
           // dd($row);
        return response()->json(['success'=>'Status change successfully.']);
    }

 

    public function deleteDocAddon(Request  $request){
        $id=$request->id;
       Addition::where('id',$id)->forceDelete();
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function deletecondition(Request  $request){
        $id=$request->id;
       ConditionItem::where('id',$id)->forceDelete();
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function storeDocBrand(Request  $request){
        //$is_empty = current(array_filter($request->firstSlidePrice));

        $res = null;
        foreach ($request->firstSlidePrice as $key=>$v) {
            if ($v !== null) {
                $res = $key;
                break;
            }
        }

        $request->validate([
            'model_id'=>'required|array|min:1'
        ]);
//
      $doc= $request->nameOfDoc;
        $increment=$res;
        $slides=$this->arr($request,$increment);
        $find=CompleteDoc::find($doc);
        $find->update(['display'=>1]);

        $newDoc=CompleteDoc::where(['id'=>$doc,'model_id'=>$request->model_id[0]])->first();
        //dd($newDoc);
        if ($newDoc !=null){

            $newDoc->update($slides);
        }else{
          //  dd('rr');
            $newRow=CompleteDoc::where(['id'=>$doc])->first();
            $newRow->update($slides+[
                'model_id'=>$request->model_id[0],
                'brand_id'=>$request->brand_id
            ]);
        }

        $compDocument=CompleteDoc::where(['id'=>$doc])->selectionExcpt()->toArray();
        //dd($compDocument);
        for ($i=1;$i<count($request->model_id);$i++){
            $con=['model_id'=>$request->model_id[$i],'brand_id'=>$request->brand_id];
            //$a=CompleteDoc::where(['id'=>$doc,'model_id'=>$request->model_id[$i],'brand_id'=>$request->brand_id])->first();
             $arr=$this->arr($request,$i);
            $createRow=$arr+$compDocument[0]+$con;
             CompleteDoc::create($createRow);
        }
        return redirect()->route('all_complete')->with('success','تم الحفظ');

        //return redirect()->back()->with('success','تم الحفظ');
    }//storeDocBrand

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

 

 
  public function addBrandToDoc(Request  $request){
      // dd($request->all());
      $request->validate([
          'brand_id'=>'required',
          'vehicle_id'=>'required',
          'model_id'=>'required|array|min:1',
          'firstSlidePrice'=>'required|array|min:1',
          'SecondSlidePrice'=>'required|array|min:1',
          'fourthSlidePrice'=>'required|array|min:1',
          'thirdSlidePrice'=>'required|array|min:1'
      ]);
      $res = null;
      $compDocument=CompleteDoc::where(['id'=>$request->id])->selectionExcpt()->toArray();
      $j=-1;
      for ($i=0;$i<count($request->firstSlidePrice);$i++){
        if ($request->firstSlidePrice[$i] !=null) {
            $j++;
            $con = ['model_id' => $request->model_id[$j], 'brand_id' => $request->brand_id,'vehicle_id' => $request->vehicle_id];
            $arr = $this->arr($request, $i);
            $createRow = $arr + $compDocument[0] + $con;
            CompleteDoc::create($createRow);

        }//end if
      }
      return redirect()->back()->with('success','تم الحفظ');
    }//end

    public function  deleteModelFromCompleteDoc($name,$model_id){
     $doc = CompleteDoc::where('model_id',$model_id)->where('Insurance_Company_ar',$name)->first();
     if(!$doc) abort(404);

    $doc->delete();
     
     return back();
    }

     public function inDocumentStore(Request $request)
    {
//dd(auth()->user()->id);

        $request->validate([

            'model_id'=>'required',
            'type_of_use' =>'required',

        ]);

        $imageName = '';
        if(count($request->model_id) >= 1){


             if($request->file('logo')){
                      $imageName = time().'.'.request()->logo->getClientOriginalExtension();

                       request()->logo->move(public_path('uploads'), $imageName);
                    }


            foreach($request->model_id as $key=>$model){
                $doc = new CompleteDoc();
                $arr = explode(',',$model);
                $doc->brand_id = $request->brand_id;

                $doc->model_id = $request->model_id[$key];

                if($request->price[$key] != null){
                    $doc->price = $request->price[$key];
                }
                else
                {
                    $doc->price = 0;
                }


                if($request->type_of_use[$key] != null){
                    $doc->type_of_use = $request->type_of_use[$key];
                }


                $doc->user_id = auth()->user()->id;

                 $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
                 $doc->Insurance_Company_en = $request->Insurance_Company_en;
                 $doc->deliveryFee = $request->deliveryFee;

                $doc->year = date("Y");
                $doc->logo = $imageName;
                $doc->end_date = auth()->user()->ended_at;
                $doc->ar_term= $request->ar_term;
                $doc->en_term = $request->en_term;

                $doc->in_duration = $request->in_duration;
                $doc->precent = $request->precent;
                $doc->discount_q = $request->discount_q;
                $doc->start_disc = $request->start_disc ;
                $doc->end_disc = $request->end_disc;


                $doc->firstSlidePrice = $request->firstSlidePrice[$key];
                $doc->OpenFileFirstSlide = $request->OpenFileFirstSlide[$key];
                $doc->OpenFilePerecentFirstSlide = $request->OpenFilePerecentFirstSlide[$key];
                $doc->OpenFileMinimumFirstSlide = $request->OpenFileFirstSlideMin[$key];
                $doc->SecondSlidePrice = $request->SecondSlidePrice[$key];
                $doc->OpenFileSecondSlide = $request->OpenFileSecondSlide[$key];
                $doc->OpenFilePerecentSecondSlide = $request->OpenFilePerecentSecondSlide[$key];
                $doc->thirdSlidePrice = $request->thirdSlidePrice[$key];
                $doc->OpenFileThirdSlide = $request->OpenFileThirdSlide[$key];
                $doc->OpenFilePerecentThirdSlide = $request->OpenFilePerecentThirdSlide[$key];
                $doc->fourthSlidePrice = $request->fourthSlidePrice[$key];
                $doc->OpenFileFourthSlide = $request->OpenFileFourthSlide[$key];
                $doc->OpenFilePerecentFourthSlide = $request->OpenFilePerecentFourthSlide[$key];


                $doc->save();

                $Condition = Condition::create(
                    [
                        'ToleranceratioCheck' =>  $request->ToleranceratioCheck,
                        'Tolerance_ratio'  =>  $request->Tolerance_ratio,
                        'ToleranceYearPerecenteage' =>  $request->ToleranceYearPerecenteage ,
                        'ConsumptionRatio'  =>  $request->ConsumptionRatio,
                        'ConsumptionFirstRatio' =>  $request->ConsumptionFirstRatio,
                        'YearPerecenteage' =>  $request->YearPerecenteage,
                        'ConsumptionYearPerecenteage' =>  $request->ConsumptionYearPerecenteage,
                        'last_percent'=>$request->last_percent,
                        'insurance_document_id' =>  $doc->id
                    ]
                );
                foreach($request->AddonNameAR as $keyConditionItem => $AddonNameAR){
                    $ConditionItem = ConditionItem::create(
                        [
                            'AddonNameAR' => $AddonNameAR,
                            'AddonNameEn'  => $request->AddonNameEn[$keyConditionItem],
                            'AddonMaxYear'  => $request->AddonMaxYear[$keyConditionItem],
                            'AddonUnkownMaxmum'  => $request->AddonUnkownMaxmum[$keyConditionItem],
                            'condition_id' => $Condition->id
                        ]
                    );
                }

                foreach($request->FeatureNameAr as $keyAddition => $FeatureNameAr){
                    $Addition = Addition::create(
                        [
                            'FeatureNameAr' => $FeatureNameAr,
                            'FeatureNameEn'  => $request->FeatureNameEn[$keyAddition],
                            'FeatureCost' => $request->FeatureCost[$keyAddition],
                            'insurance_document_id' =>  $doc->id
                        ]
                    );
                }

                // $InsuranceDocumentBrand = InsuranceDocumentBrand::create(
                //     [
                //         'firstSlidePrice' => $request->firstSlidePrice[$key],
                //         'OpenFileFirstSlide' => $request->OpenFileFirstSlide[$key],
                //         'OpenFilePerecentFirstSlide' => $request->OpenFilePerecentFirstSlide[$key],
                //         'OpenFileFirstSlideMin'  => $request->OpenFileFirstSlideMin[$key],
                //         'SecondSlidePrice'  => $request->SecondSlidePrice[$key],
                //         'OpenFileSecondSlide' => $request->OpenFileSecondSlide[$key],
                //         'OpenFilePerecentSecondSlide' => $request->OpenFilePerecentSecondSlide[$key],
                //         'thirdSlidePrice'  => $request->thirdSlidePrice[$key],
                //         'OpenFileThirdSlide'  => $request->OpenFileThirdSlide[$key],
                //         'OpenFilePerecentThirdSlide' => $request->OpenFilePerecentThirdSlide[$key],
                //         'fourthSlidePrice' => $request->fourthSlidePrice[$key],
                //         'OpenFileFourthSlide'  => $request->OpenFileFourthSlide[$key],
                //         'OpenFilePerecentFourthSlide'  => $request->OpenFilePerecentFourthSlide[$key],
                //         'insurance_document_id' =>  $doc->id
                //     ]
                //     );

            }
        }

        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');

    }
   
 

    public function compDocumentCreate($lang=null){
        $insurance = \App\Insurance::where('user_id',auth()->user()->id)->first();
        $insurance_document = \App\InsuranceDocument::where('user_id',auth()->user()->id)->get();
        $complete_insurance = \App\CompleteDoc::where('user_id',auth()->user()->id)->get();
        $merge_insurance =$insurance_document->merge( $complete_insurance);
        $data=\App\CompleteDoc::where('user_id',auth()->user()->id)->first();
        //dd($data);dd('fff');
        $uses=Style::get();
        return view('Cdashboard.InsuranceCFull')->with(['uses'=>$uses,'lang'=>$lang,'insurance'=>$insurance,'complete_insurance'=>
            $complete_insurance,'merge_insurance'=>$merge_insurance,'insurance_document'
        =>$insurance_document,'brands'=>\App\brands::where('status',1)->get(),
            'models'=>\App\models::get(),'data'=>$data]);
    }

 
    public function cmDocumentStore(Request $request)
    {
        $request->validate([
            'brand_id'=>'required',
            'model_id'=>'required',
            'type_of_use' =>'required',

        ]);
        if(count($request->brand_id) >= 1){
            foreach($request->brand_id as $key=>$brand){


                 $doc = new CompleteDoc();
                 $doc->insurance_id = $request->insurance_id;
                $doc->brand_id = $brand;
                $doc->model_id =  $request->model_id[$key];


                if($request->year[$key] != null ){
                    $doc->year = $request->year[$key];
                }
                else
                 {
                    $doc->year = 0;
                }
                  if($request->inmethodfrom[$key] != null ){
                    $doc->inmethodfrom = $request->inmethodfrom[$key];
                }
                else
                 {
                    $doc->inmethodfrom = 0;
                }
                  if($request->inmethodto[$key] != null ){
                    $doc->inmethodto = $request->inmethodto[$key];
                }
                else
                 {
                    $doc->inmethodto = 0;
                }
                  if($request->percentage[$key] != null ){
                    $doc->percentage = $request->percentage[$key];
                }
                else
                 {
                    $doc->percentage = 0;
                }
                  if($request->fileprice[$key] != null ){

                    $doc->fileprice = $request->fileprice[$key];
                }
                else
                 {
                    $doc->fileprice = 0;
                }
                  if($request->minimum[$key] != null ){
                    $doc->minimum = $request->minimum[$key];
                }
                else
                 {
                    $doc->minimum = 0;
                }
                $doc->user_id = auth()->user()->id;

                $doc->ar_term= $request->ar_term;
                $doc->en_term = $request->en_term;
                $doc->type_of_use = $request->type_of_use;
                $doc->start_disc = $request->start_disc ;
                $doc->end_disc = $request->end_disc;
                $doc->type = 1;
                $doc->save();

            }
        }

        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');
    }

     public function cmDocumentUpdate(Request $request)
    {
        $request->validate([
            'brand_id'=>'required',
            'model_id'=>'required',

        ]);
        $doc = CompleteDoc::where('id',$request->insurance_id)->first();
        // $doc->insurance_id = $request->insurance_id;
        $doc->Insurance_Company_ar = $request->Insurance_Company_ar;
        $doc->Insurance_Company_en = $request->Insurance_Company_en;
        $doc->model_id = $request->model_id;
        $doc->brand_id = $request->brand_id;
        $doc->ar_term= $request->ar_term;
        $doc->en_term = $request->en_term;
        $doc->type_of_use = $request->type_of_use;
        $doc->year = $request->year;
        $doc->inmethodfrom = $request->inmethodfrom;
        $doc->inmethodto = $request->inmethodto;
        $doc->percentage= $request->percentage;
        $doc->fileprice = $request->fileprice;
        $doc->minimum = $request->minimum;
        // $doc->in_duration = $request->in_duration;
        // $doc->precent = $request->precent;
        // $doc->discount_q = $request->discount_q;
        $doc->start_disc = $request->start_disc ;
        $doc->end_disc = $request->end_disc;
        $doc->country_id = \auth()->user()->country->id;
        // $doc->type = 1;
        $doc->save();

        return redirect('Cdashboard/insurance')->with('success','تم الحفظ');

    }
    public function deleteinDocument($id){
        if($id != null)
        {
            \App\userinsurance::where('id',$id)->Forcedelete();
            return back();
        }
        else
         {
             return back();
         }
    }
 

    public function inforce($id)
    {
        if($id != null)
        {
            InsuranceDocument::where('id',$id)->forceDelete();
            return redirect('dashboard/insurance')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }



    public function changeDateBrands($id,$lang=null,Request  $request){
      //  dd($id);
        $row=InsuranceDocument::find($id);

        if (! $row) {
            return redirect()->back()->with('success' , 'حدث خطا ما');
        }
        $row->update($request->except('_token'));
        //$row->save();
        return redirect()->back()->with('success','تم التحديث بنجاح');
    }//end changeDateBrands

     public function CompDoc_delete($id)
    {
        if($id != null)
        {
            \App\CompleteDoc::where('id',$id)->forceDelete();

            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
    public function CompDoc_active($id){
        $insurnace =  \App\CompleteDoc::where('id',$id)->first();
        $insurnace->status = 1 ;
        $insurnace->save();
        return back()->with('success' , 'تم التفعيل بنجاح');
    }

      public function CompDoc_deactive($id){
        $insurnace =  \App\CompleteDoc::where('id',$id)->first();
        $insurnace->status = 0 ;
        $insurnace->save();
        return back()->with('success' , 'تم التعطيل بنجاح');
    }

     public function IncCompDoc_active($id){
        $insurnace =  \App\InsuranceDocument::where('id',$id)->first();
        $insurnace->status = 1 ;
        $insurnace->save();
        return back()->with('success' , 'تم التفعيل بنجاح');
    }
      public function IncCompDoc_deactive($id){
        $insurnace =  \App\InsuranceDocument::where('id',$id)->first();
        $insurnace->status = 0 ;
        $insurnace->save();
        return back()->with('success' , 'تم التعطيل بنجاح');
    }

     public function IncCompDoc_delete($id)
    {
        if($id != null)
        {
            \App\InsuranceDocument::where('id',$id)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function active_insurnace(Request $request){
        $insurance_company = \App\Insurance::where('id' , $request->id)->first();
        $insurance_documents = \App\InsuranceDocument::where('user_id',$request->user_id)->get();
        $complete_insurances = \App\CompleteDoc::where('user_id',$request->user_id)->get();
        if($insurance_documents){
            foreach($insurance_documents as $insurance_document){
                $insurance_document->status = 1 ;
                $insurance_document->save();
            }
        }
         if($complete_insurances){
            foreach($complete_insurances as $complete_insurance){
                $complete_insurance->status = 1 ;
                $complete_insurance->save();
            }
        }
        $insurance_company->status = 1;
        $insurance_company->save();
        return back()->with('success' , 'تم التفعيل بنجاح');
    }

     public function deactive_insurnace(Request $request){
        $insurance_company = \App\Insurance::where('id' , $request->id)->first();
        $insurance_documents = \App\InsuranceDocument::where('user_id',$request->user_id)->get();
        $complete_insurances = \App\CompleteDoc::where('user_id',$request->user_id)->get();
        if($insurance_documents){
            foreach($insurance_documents as $insurance_document){
                $insurance_document->status = 0 ;
                $insurance_document->save();
            }
        }
         if($complete_insurances){
            foreach($complete_insurances as $complete_insurance){
                $complete_insurance->status = 0 ;
                $complete_insurance->save();
            }
        }

        $insurance_company->status = 0;
        $insurance_company->save();
        return back()->with('success' , 'تم التعطيل بنجاح');
    }


    public function mcenterAdditionalServices(Request $request,$lang = null){
        if($request->isMethod('post'))
        {
            $request->validate([
                'ar_name'=>'required',
                'en_name'=>'required',
                'mcenter_service_id'=>'required',
                'ar_description'=>'required',
                'en_description'=>'required',
            ]);
            $data = $request->all();
            $data['status'] = !is_null($request->status) ? '1' : '0';
            if($request->id)
            {
                unset($data['_token']);
                McenterAdditionalService::where('id',$request->id)->update($data);
                return back()->with(['success'=>'تم الحفظ']);
            }
            McenterAdditionalService::create($request->all());
            return back()->with(['success'=>'تم الحفظ']);
        }
        $mcenter_services = McenterService::where('mcenter_id',auth()->user()->mcenter->id)->where('status','1')->get();
        $services_ids =  $mcenter_services->pluck('id');
        $services = McenterAdditionalService::whereIn('mcenter_service_id',$services_ids)->paginate();
        $vehicles = McenterVehicle::where('status','1')->get();

        return view('dashboard.additional-mcenter-services.index',compact('lang','mcenter_services','services','vehicles'));
    }  

    public function deleteMcenterAdditionalService(Request $request ){
        $service = McenterAdditionalService::where('id',$request->id);
        if($service)
        {
            $service->delete();
        }
        return;
    }
    public function mcenterRequests(Request $request, $lang = null){
        $view = 'dashboard.mcenters-requests.index';
        if(auth()->user()->type == 0)
        $mc_requests   = MaintenanceRequest::where('user_id',auth()->user()->id);
        elseif(auth()->user()->type == 5)
        $mc_requests   = MaintenanceRequest::where('mcenter_id',auth()->user()->mcenter->id);        
        else
        return redirect('dashboard/index');
        $mc_requests = $mc_requests->with(['rate']);

        $mcenter_services = McenterService::where('mcenter_id',auth()->user()->mcenter->id)->where('status','1')->get();
        $users = User::whereIn('id',$mc_requests->pluck('user_id'))->get();

        if($request->isMethod('post'))
        {
            $data = $request->all();
            $view = 'dashboard.mcenters-requests.table';
            if(!empty($data['service_id']))
            {
                $mc_requests-where(function($q){
                        $q->orwhere('services','like',$data['service_id'].'-%')
                        ->orwhere('services','like','%-'.$data['service_id'].'-%')
                        ->orwhere('services','like',$data['service_id'].'-%');            
                });
            }
            if(!empty($data['user_id']))
            {
                $mc_requests->where('user_id',$data['user_id']);
            }

            if(!empty($data['status']))
            {
                $mc_requests->where('status',$data['status']);
            }
        }

        $mc_requests = $mc_requests->paginate();
        return view($view,compact('lang','users','mcenter_services','mc_requests'));
    }

    public function MaintenanceRequest($id)
    {
        $service = MaintenanceRequest::where('id',$id);
        if(!empty($service))
        {
            $service->delete();
        }
        return;
    }

    public function UpdateBrand(Request  $request){
        $row=CompleteDoc::find($request->id);
        $row->fill($request->except(['_token','id']));
        $row->save();
        return redirect()->back()->with(['success' => 'Banner updated successfully']);
    }//end UpdateBrand

    public function contactUs(Request  $request){
        $request->validate([
            'txtName' => 'required|string|max:255',
            'txtPhone' => 'required|string|max:255',
            'txtMsg' => 'required',
            'txtEmail' => 'required|email|email'
            //'password' => ['required', 'string', 'min:8'],
        ]);
        //dd($request->all());
        $email=$request->txtEmail;
        $name=$request->txtName;
        $phone=$request->txtPhone;
        $msg=$request->txtMsg;
        $mail='soouqnet235@gmail.com';
        Mail::send([], [], function ($message) use ($email,$name,$phone,$msg,$mail) {

            $message->to($mail, 'New Message')->subject
            ('New Request')// here comes what you want
            ->setBody(
                '<h4> Phone :  ' . $phone . '  </h4> <p> Name :  '.$name.' </p>
                <h4>Email:'.$email.'</h4><p>Message : '.$msg.'</p>', 'text/html'); // assuming text/plain
            $message->from('info@tameenistore.com', 'New Message');
        });
        return redirect()->back()->with(['success'=>'تم الارسال بنجاح']);
    }//end aboutUs

//selectMembership
   public function selectMembership(Request  $request,$lang=null){
        $membership=MemberInsurance::find($request->membership);
        $type=$request->type;
       $id=auth()->user()->id;
        if($membership->price=='0'){
            checkMembership($membership,$id,$type);
            if ($type=='0') return redirect()->route('all_complete')->with('success','تم الاشتراك بنجاح');
            else return redirect()->route('dashboard-insurance')->with('success','تم الاشتراك بنجاح');
        }
        else{
            $price=$membership->price;
            $checked=checkUserBalance($id,$price);
            if ($checked==0) return redirect()->back()->with('success','ليس لديك رصيد كافى ... من فضلك قم بشحن رصيدك');
            else {
                transaction($id,'out',$price,'membership',-2);
                checkMembership($membership,$id,$type);
                if ($type==0) return redirect()->route('all_complete')->with('success','تم الاشتراك فى العضويه');
                else return redirect()->route('dashboard-insurance')->with('success','تم الاشتراك بنجاح');

            }
        }

   }
   public function updateMyInfo (Request $request){
        $user = User::where('id',auth()->user()->id)->first();
                $request->validate([
                    'name' => 'required|string|max:255',
                    'phone' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    //'password' => ['required', 'string', 'min:8'],
                ]);
            

                 $user->name = $request->name;
                 $user->email = $request->email;
                 $user->phones = $request->phone;
                if($request->img){
                    $file =  $request->file('img');
                    $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $imageName);
                    $user->image = $imageName;
                }
                //dd($request->password);
                if ($request->password) $user->password= Hash::make($request->password);
                $user->save();
    
                return back()->with(['success'=>'تم التعديل بنجاح']);
    //            if(Hash::check($request->password,$user->password)){
    //                 if($request->ar_name){
    //                     $user->name = $request->ar_name;
    //                 }
    //                 if($request->phone){
    //                     $user->phones = $request->phone;
    //                 }
    //                if($request->email){
    //                    $user->email = $request->email;
    //                }
    //                 if($request->img){
    //                     $file =  $request->file('img');
    //                     $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
    //                     $file->move(public_path('uploads'), $imageName);
    //                     $user->image = $imageName;
    //                }
    //
    //                    $user->update();
    //
    //                    return back()->with(['message'=>'Ok..']);
    //            }
    //            else{
    //               return back()->with(['message'=>'Password is incorrect']);
    //            }
        }

}//end class

