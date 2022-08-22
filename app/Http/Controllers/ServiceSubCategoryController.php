<?php

namespace App\Http\Controllers;

use App\ServiceCategory;
use App\ServiceSubCategory;
use Illuminate\Http\Request;
use App\ServiceChildCategory;
use Illuminate\Support\Facades\Validator;

class ServiceSubCategoryController extends Controller
{

    public function __construct()
      {
          $this->middleware('admin')->except(['getChildrens']);
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
        $search = $request->search;
        $service_category_id = $request->service_category_id;
        $status = $request->status;

        $service_sub_categories = ServiceSubCategory::where('id','>',0);
        if(!is_null($search))
        {
            $service_sub_categories = $service_sub_categories->
            where('ar_name','like','%'.$search.'%')
            ->orWhere([['en_name','like','%'.$search.'%']])
            ->orWhere([['ar_description','like','%'.$search.'%']])
            ->orWhere([['en_description','like','%'.$search.'%']]);
        }
        if(!is_null($service_category_id))
        {
        $service_sub_categories->where('service_category_id',$service_category_id);
        }  
        if(!is_null($status))
        {
        $service_sub_categories->where('status', $status);
        }
        $service_sub_categories = $service_sub_categories->paginate();
        return view('dashboard.service_sub_categories.table',compact('service_sub_categories'));
      
    }
    $service_sub_categories=ServiceSubCategory::paginate();
    $service_categories = ServiceCategory::get();
      return view('dashboard.service_sub_categories.index',compact('service_sub_categories','service_categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      $service_categories = ServiceCategory::get();
      return view('dashboard.service_sub_categories.create',compact('service_categories'));
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
        'service_category_id'=>'required',
        'en_name'=>'required|array',
        'en_name'=>'required|array',
    ]);
    
        if($validate->fails())
        return response()->json($validate->errors, 200);
        
       $service_sub_categories = [];
       foreach ($data['ar_name'] as $key => $e) {
         $e = ['ar_name' => $data['ar_name'][$key] ,'en_name' => $data['en_name'][$key],'service_category_id'=>$request->service_category_id];
         if(isset($data['ar_description']))
         {
             $e['ar_description'] = $data['ar_description'][$key];
         }
         if(isset($data['en_description']))
         {
             $e['en_description'] = $data['en_description'][$key];
         }
         if(isset($data['status']))
         {
             $e['status'] =  $data['status'][$key];;
         }
         if(isset($data['image']))
         {
             $image = $data['image'][$key];
             $e['image'] = time().$key.'.'.$image->getClientOriginalExtension();
             $image->move(public_path('uploads'),$e['image']);
         }
         array_push($service_sub_categories,$e);
       }

       $res  = ServiceSubCategory::insert($service_sub_categories);
       return redirect()->route('service_sub_categories.index')->with('success','تم الحفظ بنجاح');

    }

  public function edit($id)
  {
   return view('dashboard.service_sub_categories.edit');
  }

  public function update(Request $request)
  {
      $request->validate([
          'ar_name'=>'required|max:255',
          'en_name'=>'required|max:255',
          'service_category_id' => 'required'
        ]);
        $status = isset($request->status) ? $request->status  : '0' ;
        $imagename = null ;
        $service_sub_category=  ServiceSubCategory::find($request->id);
        if (!$service_sub_category){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        if($request->file('image'))
        {
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads'),$imagename);
        }
        $data = $request->all();
        $data['status'] = $status;

        if($imagename) $data['image'] = $imagename;

        $service_sub_category = $service_sub_category->update($data);

      return redirect()->route('service_sub_categories.index')->with('success','تم الحفظ بنجاح');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\service_sub_categories  $service_sub_categories
   * @return \Illuminate\Http\Response
   */
public function delete($id)
  {
      $service_sub_category = ServiceSubCategory::find($id);
      if (! $service_sub_category) {
          return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
      }
      $service_sub_category->delete();
      return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
  }//end destroy

  public function service_sub_categoryChangeStatus(Request $request)
  {
      $cat = ServiceSubCategory::find($request->service_sub_category_id);
      $cat->status = $request->status;
      $cat->save();
      return response()->json(['success'=>'Status change successfully.']);
  }//end catChangeStatus

  
  /**
   * get childrens
   */

  public function getChildrens($id)
  {
      if(!empty($id))
      {
          $service_child_categories = ServiceChildCategory::where('service_sub_category_id',$id)->where('status','1')->get();
          return response()->json($service_child_categories, 200);
      }
      return [];
  }

}
