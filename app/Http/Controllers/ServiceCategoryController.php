<?php

namespace App\Http\Controllers;

use App\ServiceCategory;
use App\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
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
        $search = $request->all()['search'];
        if(empty($search))
        $service_categories=ServiceCategory::paginate('20');
        else
        {
         $service_categories=ServiceCategory::where([['ar_name','like','%'.$search.'%']])
         ->orWhere([['en_name','like','%'.$search.'%']])
         ->orWhere([['ar_description','like','%'.$search.'%']])
         ->orWhere([['en_description','like','%'.$search.'%']])
         ->paginate('20');
        }
        
        return view('dashboard.service_categories.table',compact('service_categories'));
    }
      $service_categories=ServiceCategory::paginate();
      return view('dashboard.service_categories.index',compact('service_categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('dashboard.service_categories.create');
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
    ]);
    
        if($validate->fails())
        return response()->json($validate->errors, 200);
        
       $service_categories = [];
       foreach ($data['ar_name'] as $key => $e) {
         $e = ['ar_name' => $data['ar_name'][$key] ,'en_name' => $data['en_name'][$key]];
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
         array_push($service_categories,$e);
       }

       $res  = ServiceCategory::insert($service_categories);
       return redirect()->route('service_categories.index')->with('success','تم الحفظ بنجاح');

    }

  public function edit($id)
  {
   return view('dashboard.service_categories.edit');
  }

  public function update(Request $request)
  {
      $request->validate([
          'ar_name'=>'required|max:255',
          'en_name'=>'required|max:255'
        ]);
        $status = isset($request->status) ? $request->status  : '0' ;
        $imagename = null ;
        $service_category=  ServiceCategory::find($request->id);
        if (!$service_category){
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
        // $data = ['ar_name'=>$request->ar_name, 'en_name'=>$request->en_name, 
        // 'status'=>$status,'ar_description'=>$request->ar_description, 'en_description'=>$request->en_description ];

        if($imagename) $data['image'] = $imagename;

        $service_category = $service_category->update($data);

      return redirect()->route('service_categories.index')->with('success','تم الحفظ بنجاح');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\service_categories  $service_categories
   * @return \Illuminate\Http\Response
   */
public function delete($id)
  {
      $service_category = ServiceCategory::find($id);
      if (! $service_category) {

          return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
      }
      $service_category->delete();
      return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
  }//end destroy

  public function service_categoryChangeStatus(Request $request)
  {
      $cat = ServiceCategory::find($request->service_category_id);
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
           $service_sub_categories = ServiceSubCategory::where('service_category_id',$id)->where('status','1')->get();
           return response()->json($service_sub_categories, 200);
       }
       return [];
   }
}
