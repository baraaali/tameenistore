<?php

namespace App\Http\Controllers;

use \App\User;
use App\Agents;
use App\country;
use App\Mcenters;
use App\DocumentsUser;
use App\ServiceCategory;
use App\RangeTimeMcenter;
use App\MaintenanceRequest;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class SecurityController extends Controller
{


	 use AuthenticatesUsers;


    public function login(Request $request)
    {
    	$request->validate([
    		'email'=>'required',
    		'password'=>'required',
    	]);


    	$isAdmin = User::where('email',$request->email)->first();
        if (isset($isAdmin)) {
            if ($isAdmin->guard == 1) {
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    return redirect('/dashboard/index');        
                }
                return back()->with('errors', 'Email Or Password is Incorrect');

            } else {
                return back()->with('errors', 'Email Or Password is Incorrect');
            }
        }else return back()->with('errors','Email Or Password is Incorrect');


    }
    public function redirectRequests()
    {
        if(!is_null(session()->get('save-request-mcenter')))
        {
            $request = session()->get('save-request-mcenter');
            $request['user_id'] = auth()->user()->id;
            $request['services'] = implode('-',$request['services']);
            $request['additional_services'] = isset($request['additional_services']) ?  implode('-',$request['additional_services']) : null;
            if(auth()->user()->type == 0)
            {
                MaintenanceRequest::create($request);
                session()->flash('success','تم إرسال الطلب نجاح');
                session()->forget('save-request-mcenter');
                return redirect('/cp/mcenter-requests');
            }
            
        }
       return redirect('/home');

    }
    public function user_login(Request $request){
        $request->validate([
    		'email'=>'required',
    		'password'=>'required',
    	]);


    	$isAdmin = \App\User::where('email',$request->email)->first();
    	if($isAdmin){
    	    	if($isAdmin->block != 0)
            	{
            		$credentials = $request->only('email','password');

            		if(Auth::attempt($credentials)){

            		    $isAdmin->last_login = Date('d-m-Y h:i A');
            		    $isAdmin->ip_address = $request->ip();
            		    $isAdmin->save();
                        return $this->redirectRequests();
            		} else {
            		   return back()->with('error','Email Or Password is Incorrect');
            		}


            	} else if ($isAdmin->block == 0) {
            	    	return back()->with('error','Your Account is Blocked :(');
            	}
            	else
            	{
            		return back()->with('error','Email Or Password is Incorrect');
            	}
    	} else {
    	    return back()->with('error','Email Or Password is Incorrect');
    	}


    }
    public function saveMaintenanceCenter($request)
    {
        $validator = [
            'day' => 'required | array',
            'start_time' => 'required | array',
            'end_time' => 'required | array',
            'category' => 'required ',
            'ar_description' => 'required ',
            'en_description' => 'required ',
            'special' => 'required ',
        ];
        if(auth()->user()->mcenter && !auth()->user()->mcenter->image)
        $validator['image'] = 'required';

        $request->validate($validator);
        $mcenter = $request->all();
       // dd($mcenter);
        $mcenter['user_id'] = auth()->user()->id;

        if(!is_null($request->file('image')))
        {
            $image = $request->file('image');
            $mcenter['image'] = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads'),$mcenter['image']);
        }
        if(empty($mcenter['id'])){
            $mcenter = Mcenters::create($mcenter);
            $id = $mcenter->id;
        }else{
            $toUpdate = Mcenters::where('id',$mcenter['id']);
            unset($mcenter['_token']);
            unset($mcenter['day']);
            unset($mcenter['start_time']);
            unset($mcenter['end_time']);
            $toUpdate->update($mcenter);
            $id = $mcenter['id'];
        }
        
        // save day times
        if($id)
        {
            $days =  $request->day;
            $times = [];
            RangeTimeMcenter::where('mcenter_id',$id)->delete();
            foreach ($days as $i => $day) {
              $start_times = $request->start_time;
              $end_times = $request->end_time;
              if(!empty($day) && !empty($start_times[$i]) && !empty($end_times[$i]))
              {
                  $e = ['mcenter_id'=>$id,'day' => $day,'start_time'=> $start_times[$i],'end_time'=>$end_times[$i]];
                  array_push($times,$e);
              }
            }
           // dd($times);
            if(count($times)){
                RangeTimeMcenter::where('mcenter_id',$id)->delete();
                RangeTimeMcenter::insert($times);
            }
        }
        return redirect()->back()->with('success','تم التسجيل بنجاح'); 
    }
    public function accountInfo(Request $request,$lang = null){
      //  dd(auth()->user()->agentDetails);
       if($request->isMethod('post'))
       {
           $user = auth()->user();
        if($user->type == 2 || $user->type == 3){ //agent buy & sell or agent rent
          return $this->saveAgent($request);

        }else if($user->type == 4){ // insurance
            $request->validate([
                'ar_name' => 'required',
                'en_name' => 'required',
                'ar_address' => 'required',
                'en_address' => 'required',
                'phones' => 'required',
                'email' => 'required',
                'days_on' => 'required',
                'days_on' => 'required',
            ]);
            $insurance = new \App\Insurance();
            $insurance->country_id =  auth()->user()->country_id;
            $insurance->user_id = auth()->user()->id;
            $insurance->ar_name = $request->ar_name;
            $insurance->en_name = $request->en_name;
            $insurance->ar_address = $request->ar_address;
            $insurance->en_address = $request->en_address;
            $insurance->phones = $request->phones;
            $insurance->website = $request->website;
            $insurance->email = $request->email;
            $insurance->days_on = $request->days_on;
            $insurance->times_on = $request->times_on;
            $insurance->visitors = 0;
            $insurance->status = 1;
            $insurance->special = 1;

            $insurance->save();

        }else if($user->type == 5){
            return $this->saveMaintenanceCenter($request);
        }
        return redirect()->back()->with('success','تم الحفظ');
       }
       $countries = country::where('status','1')->get();
       $categories = ServiceCategory::where('status','1')->get();
       $doc=\App\DocumentsUser::where('user_id',auth()->user()->id)->first();
       $agent = Agents::where('user_id',auth()->user()->id)->first();
      
       return view('dashboard.user-info.index',compact('countries','agent','categories','doc'));
    }
    public function register(Request $request,$lang = null)
    {   
        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:15',
            'country_id' => 'required|integer|min:0',
            'governorate_id' => 'required|integer|min:0',
            'city_id' => 'required|integer|min:0',
            'email' => 'required|unique:users,email',
            'password'=>'required|confirmed|min:8'  ,      
            'user_type' => 'required',
            'phones' => 'required|min:8',
        ]);
        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->country_id = $request->country_id; //normal person
        $newUser->governorate_id = $request->governorate_id;
        $newUser->city_id = $request->city_id;
        $newUser->type = $request->user_type;
        $newUser->phones = $request->phones;
        $newUser->password = bcrypt($request->password);

        $newUser->save();
        // fire event
        NotificationEvent::dispatch(["purpose"=>"welcome_message","params"=>['full_name'=>$request->user_name,'email'=>$request->email,'password'=>$request->password]]);
        return redirect('user/login');
    }
    
    public function saveAgent(Request $request)
    {
        $request->validate([
            'country_id'=>'required',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent =   new Agents();

        $agent->country_id = $request->country_id;
        $agent->user_id = auth()->user()->id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $agent->image = $imageName;
        }

        $agent->fb_page = $request->fb_page;
        $agent->twitter_page = $request->twitter_page;
        $agent->website = $request->website;
        $agent->email = $request->email;
        $agent->google_map = $request->google_map;
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;
        $agent->car_type = $request->car_types;
        //$agent->special = $request->specific;
        $agent->special = 0;
        $agent->status = $request->status;
        $agent->instagram = $request->insta_page;
        $agent->phones = $request->phones;
        $agent->agent_type = $request->agent_type;
        $agent->save();

        return back()->with('success','تم الحفظ');

    }
    
 
    public function uploadUserDocuments(Request  $request){
       // dd($request->all());
        $request->validate([
            'company_name'=>'required|min:3|max:100',
            'license_number'=>'required|int',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'license_image'=>'required|image|max:5000',
            'id_image'=>'required|image|max:5000',
        ]);
        $license_image=uploadImage($request->license_image);
        $id_image=uploadImage($request->id_image);
        $doc = DocumentsUser::create([
            'user_id'=>auth()->user()->id,
            'company_name'=>$request->company_name,
            'license_number'=>$request->license_number,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'license_image'=>$license_image,
            'id_image'=>$id_image,
        ]);
        $doc->save();
        return redirect()->back()->with('success','تم الحفظ');
    }//end fun

}//end class
