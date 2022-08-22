<?php

namespace App\Http\Controllers;

use App\Agents;
use App\Balance;
use App\brands;
use App\CompleteDoc;
use App\Insurance;
use App\InsuranceDocument;
use App\User;
use Illuminate\Http\Request;
use Validator;

class IncreseController extends Controller
{

      public function __construct()
        {
            $this->middleware('admin');
        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function increase($type)
    {
         $agents=Insurance::paginate();

        return view('dashboard.dates.index',compact('agents','type'));
    }

   public function renew($id,$type,Request  $request){
       try {
           if ($type=='shamel'){
            CompleteDoc::where('user_id',$id)->update(['end_date'=>$request->date]);
           }
           else{
               InsuranceDocument::where('user_id',$id)->update(['end_date'=>$request->date]);
           }
       }catch (Exception $e) {
           return redirect()->back()->with(['error' => 'حدث خطا ما']);
       }
       return redirect()->route('increase-date',$type)->with('success','تم التجديد بنجاح');
   }//end fun renew

    public function addPriceToUsers(){
        $users=User::with('balance')->where('guard','!=',1)
           ->orderBy('id','Desc')->paginate();
        return view('dashboard.dates.increase-price',compact('users'));
    }//end addPriceToUsers

    public function chargePrice($id,Request  $request){

        $balance=Balance::where('user_id',$id)->first();
        transaction($id,'in',$request->value,'charge',-1);
        if ($balance) {
            $value=$balance->balance+$request->value;
            $balance->update(['balance'=>$value]);
        }else Balance::create([
            'balance'=>$request->value,
            'user_id'=>$id
        ]);
        return redirect()->back()->with('success','تم اضافه الرصيد بنجاح');

    }//end chargePrice

}//end class
