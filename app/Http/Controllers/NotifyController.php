<?php

namespace App\Http\Controllers;

use App\Cars;
use App\items;
use Validator;
use App\brands;
use App\Notify;
use App\country;
use App\NewServices;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class NotifyController extends Controller
{
    use GeneralTrait;
     
      public function __construct()
        {
            
            $this->middleware(['auth']);
        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type=0)
    {  
   
        $rows = Notify::where('status', 1)->where('type',$type)->orderBy('id','desc')->paginate();
        return view('dashboard.notify.index', compact('rows','type'));
    } //end index

        public function watchAds($id){
        $ads=Notify::find($id)->forceDelete();
//        $ads->status=0;
//        $ads->save();
        return redirect()->back()->with('success','تم التحديث بنجاح');
        }//end watchAds

    public function delete($id,$type=0){
        $ads=Notify::find($id);
        if ($type==0) {
            Cars::where('id',$ads->ads_id)->forceDelete();
        }
        else{
            NewServices::where('id',$ads->ads_id)->forceDelete();
        }
       $ads->delete();
        return redirect()->back()->with('success','تم حذف الاعلان بنجاح');
    }//end delete


}//end class
