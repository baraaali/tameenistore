<?php

namespace App\Http\Controllers;

use App\ServiceSubCategory;
use Illuminate\Http\Request;
use App\ServiceChildCategory;
use Illuminate\Support\Facades\Validator;

class ServiceChildCategoryController extends Controller
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
  public function index(Request $request)
  {
     
    if($request->isMethod('post'))
    {
        $search = $request->search;
        $service_sub_category_id = $request->service_sub_category_id;
        $status = $request->status;

        $service_child_categories = ServiceChildCategory::where('id','>',0);
        if(!is_null($search))
        {
            $service_child_categories = $service_child_categories->
            where('ar_name','like','%'.$search.'%')
            ->orWhere([['en_name','like','%'.$search.'%']])
            ->orWhere([['ar_description','like','%'.$search.'%']])
            ->orWhere([['en_description','like','%'.$search.'%']]);
        }
        if(!is_null($service_sub_category_id))
        {
        $service_child_categories->where('service_sub_category_id',$service_sub_category_id);
        }  
        if(!is_null($status))
        {
        $service_child_categories->where('status', $status);
        }
        $service_child_categories = $service_child_categories->paginate();
        return view('dashboard.service_child_categories.table',compact('service_child_categories'));
      
    }
    $service_child_categories=ServiceChildCategory::paginate();
    $service_sub_categories = ServiceSubCategory::get();

      return view('dashboard.service_child_categories.index',compact('service_child_categories','service_sub_categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      $service_sub_categories = ServiceSubCategory::get();
      return view('dashboard.service_child_categories.create',compact('service_sub_categories'));
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
        'service_sub_category_id'=>'required',
        'en_name'=>'required|array',
        'en_name'=>'required|array',
    ]);
    
        if($validate->fails())
        return response()->json($validate->errors, 200);
        
       $service_child_categories = [];
       foreach ($data['ar_name'] as $key => $e) {
         $e = ['ar_name' => $data['ar_name'][$key] ,'en_name' => $data['en_name'][$key],'service_sub_category_id'=>$request->service_sub_category_id];
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
         array_push($service_child_categories,$e);
       }

       $res  = ServiceChildCategory::insert($service_child_categories);
       return redirect()->route('service_child_categories.index')->with('success','تم الحفظ بنجاح');

    }

  public function edit($id)
  {
   return view('dashboard.service_child_categories.edit');
  }

  public function update(Request $request)
  {
      $request->validate([
          'ar_name'=>'required|max:255',
          'en_name'=>'required|max:255',
          'service_sub_category_id' => 'required'
        ]);
        $status = isset($request->status) ? $request->status  : '0' ;
        $imagename = null ;
        $service_child_category=  ServiceChildCategory::find($request->id);
        if (!$service_child_category){
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

        $service_child_category = $service_child_category->update($data);

      return redirect()->route('service_child_categories.index')->with('success','تم الحفظ بنجاح');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\service_child_categories  $service_child_categories
   * @return \Illuminate\Http\Response
   */
public function delete($id)
  {
      $service_child_category = ServiceChildCategory::find($id);
      if (! $service_child_category) {
          return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
      }
      $service_child_category->delete();
      return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
  }//end destroy

  public function service_child_categoryChangeStatus(Request $request)
  {
      $cat = ServiceChildCategory::find($request->service_child_category_id);
      $cat->status = $request->status;
      $cat->save();
      return response()->json(['success'=>'Status change successfully.']);
  }//end catChangeStatus

}
