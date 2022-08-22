<?php

namespace App\Http\Controllers;

use App\Cars;
use App\items;
use App\UserBanner;
use Validator;
use App\brands;
use App\Notify;
use App\NewServices;
use App\country;
use App\Cat;
use App\SubCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdvertisementController extends Controller
{

      public function __construct()
        {
            $this->middleware(['admin']);
        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = UserBanner::orderBy('id','desc')->paginate();
        return view('dashboard.advertisements.index', compact('rows'));
    } //end index

        public function watchAds($id){
        $ads=Notify::find($id)->forceDelete();
//        $ads->status=0;
//        $ads->save();
        return redirect()->back()->with('success','تم التحديث بنجاح');
        }//end watchAds

     public function editServices($id,$lang = null)
      {
        $countries=country::all();
        $row=NewServices::find($id);
        return view('Cdashboard.update_service',compact('countries','lang','cats','sub_cats','mini_subcat','row','lang'));
      }//end editServices

    public function delete($id){
        $ads=UserBanner::find($id);
         $ads->delete();
        // Cars::where('id',$ads->ads_id)->forceDelete();

        return redirect()->back()->with('success','تم حذف الاعلان بنجاح');
    }//end delete



    public function showItem(Request $request){

       $items = \App\UserBanner::paginate(12);
       $countries = country::where('status',1)->get();
        if($request->isMethod('post'))
        {
//            $membership = $request->input('membership');
            $order = $request->input('order');
            $search = $request->input('search');
            $filters = [];
            foreach ($request->all() as $filter => $value) {
                //if($filter != 'membership' && $filter != 'order' && $filter != 'search')
                if( $filter != 'order' && $filter != 'search')
                    array_push($filters,[$filter,'=',$value]);
            }
            $items =  \App\UserBanner::where($filters);
           
            if(!is_null($search))
            {
            $columns =   Schema::getColumnListing('user_banners');
            foreach ($columns as $column) {
                $items->orWhere(function($q) use ($column,$search){
                    $q->where([[$column,'LIKE','%'.$search.'%']]);
                });
            }
            $items->orWhereHas('user',function($q) use ($search){
                $q->where([['name','LIKE','%'.$search.'%']]);
            });
            }
            //  return $items->toSql();
//            if(!is_null($membership))  $items->where('type',$membership);
            if(!is_null($order))
            $items->orderBy(explode('-',$order)[0],explode('-',$order)[1]);


            $items =  $items->paginate(12);
           // dd($items);
            return view('dashboard.advertisements.table',compact('items','countries'));
        }
   // dd($countries);
        return view('dashboard.advertisements.index',compact('items','countries'));
    }

    public function itemshow(){
        $countries = country::where('status',1)->get();
        $viewcategories = \App\Categories::where('status',1)->get();
        return view('dashboard.items.create',compact('viewcategories','countries'));
    }


    public function itemChangeStatus(Request $request)
    {  
        //Log::info($request->all());
        $cat = UserBanner::find($request->brand_id);
        $cat->active = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus

   public function renewItem(Request $request)
  {
       $ads= UserBanner::findOrFail( $request->item_date_id);
        $days=$request->item_days;
        if (Date('Y-m-d')>$ads->end_date) $date=Date('Y-m-d');
        else $date=$ads->end_date;
        $ads->end_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        // $ads->end_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        $ads->save();
        return redirect()->back()->with('success','تم تجديد الاعلان بنجاح');
    
  }//end renewServices

}//end class
