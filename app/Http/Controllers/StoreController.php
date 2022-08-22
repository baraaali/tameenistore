<?php

namespace App\Http\Controllers;

use App\Store;
use App\ServiceCategory;
use App\ServiceSubCategory;
use Illuminate\Http\Request;
use App\ServiceChildCategory;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{

    public function __construct()
      {
          $this->middleware('admin')->except(['getStores']);
      }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if($request->isMethod('post'))
    {
        $search = $request->all()['search'];
        if(empty($search))
        $stores=Store::paginate('20');
        else
        {
         $stores=Store::where([['ar_name','like','%'.$search.'%']])
         ->orWhere([['en_name','like','%'.$search.'%']])
         ->paginate('20');
        }
        
        return view('dashboard.stores.table',compact('stores'));
    }
      $stores=Store::paginate();
      $categories = ServiceCategory::get();
      return view('dashboard.stores.index',compact('stores','categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      $categories = ServiceCategory::get();
      return view('dashboard.stores.create',compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
       $data = $request->all();
       $validate = Validator::make($data,[
        'ar_name'=>'required|array',
        'en_name'=>'required|array',
        'category'=>'required',
    ]);
    
        if($validate->fails())
        return response()->json($validate->errors, 200);
        
       $stores = [];
       foreach ($data['ar_name'] as $key => $e) {
         $e = ['ar_name' => $data['ar_name'][$key] ,'en_name' => $data['en_name'][$key],
         'category' => $data['category']];

         if(isset($data['status']))
         {
             $e['status'] =  $data['status'][$key];;
         }
         if(isset($data['sub_category']))
         {
             $e['sub_category'] =  $data['sub_category'];
         }
         if(isset($data['child_category']))
         {
             $e['child_category'] =  $data['child_category'];
         }
   
         array_push($stores,$e);
       }

       $res  = Store::insert($stores);
       return redirect()->route('stores.index')->with('success','تم الحفظ بنجاح');

    }

  public function edit($id)
  {
   if(!empty($id))
   {
       $store = Store::where('id',$id)->get()->first();
       $categories = ServiceCategory::get();
       return view('dashboard.stores.edit',compact('store','categories'));
   }
   return;
  }

  public function update(Request $request)
  {
      $request->validate([
          'ar_name'=>'required|max:255',
          'en_name'=>'required|max:255',
          'category'=>'required',
        ]);
        $status = isset($request->status) ? $request->status  : '0' ;
        $store=  Store::find($request->id);
        if (!$store){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }

        $data = $request->all();
        $data['status'] = $status;
        $data['sub_category'] =  null;
        $data['child_category'] =  null;

        if(!is_null($request->sub_category))
        {
            $data['sub_category'] =  $request->sub_category;
        }
        if(!is_null($request->child_category))
        {
            $data['child_category'] =  $request->child_category;
        }

        $store = $store->update($data);

      return redirect()->route('stores.index')->with('success','تم الحفظ بنجاح');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\stores  $stores
   * @return \Illuminate\Http\Response
   */
public function delete($id)
  {
      $store = Store::find($id);
      if (! $store) {
          return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
      }
      $store->delete();
      return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
  }//end destroy

  public function storeChangeStatus(Request $request)
  {
      $cat = Store::find($request->store_id);
      $cat->status = $request->status;
      $cat->save();
      return response()->json(['success'=>'Status change successfully.']);
  }//end catChangeStatus

  public function getStores(Request $request)
  {
      $data = $request->all();
      $category  = isset($data['category']) ? $data['category'] : null;
      $sub_category  = isset($data['sub_category']) ? $data['sub_category'] : null;
      $child_category  = isset($data['child_category']) ? $data['child_category'] : null;
      
      if(!is_null($child_category))
      return Store::where('child_category',$child_category)->where('status','1')->get();
      if(!is_null($sub_category))
      return Store::where('sub_category',$sub_category)->where('status','1')->get();
      if(!is_null($category))
      return Store::where('category',$category)->where('status','1')->get();
  }

}
