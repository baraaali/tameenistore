<?php

namespace App\Http\Controllers;

use App\Insurance;
use App\userinsurance;
use App\CompleteDocSubmit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InsuranceController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function insurancerequestsuser($lang=null)
    {   
        $items = [];
        if(auth()->user()->type == 4) // company
        {
            $insurance = Insurance::where('user_id',auth()->user()->id)->get();
            $items = userinsurance::whereIn('insurance_id',$insurance->pluck('id'))->get();
        }else{ // normal user
            $items = userinsurance::where('user_id',auth()->user()->id)->get();
        }
        return view('dashboard.insurancerequestsuser.index',compact('items'));
    }

    public function complete($lang=null){
        // $CompleteDocSubmits = CompleteDocSubmit::all();
         $user_id=auth()->user()->id;
         if(auth()->user()->type == 4) // company
         {
            $items = CompleteDocSubmit::where('owner_id',$user_id)->where('status','!=',0)->get();
        }else{ // normal user
            $items = CompleteDocSubmit::where('user_id',$user_id)->where('status','!=',0)->get();
         }
         
         return view('dashboard.insurancerequescomplete.index',compact('lang','items'));
 
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
 
     }
     public function hiddenRequest($id){
        $row=CompleteDocSubmit::find($id);
        if ($row !=null){
            $row->status=0;
            $row->save();
            return redirect()->back()->with('sucess','تم الحذف بنجاح');
        }
        return redirect()->back()->with('sucess','not found');
    }
}
