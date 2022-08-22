<?php

namespace App\Http\Controllers;

use App\ServiceCategory;
use App\ServiceMemberShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceMemberShipController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['getServiceMemberShip']);
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
      $category = $request->category;
      $sub_category = $request->sub_category;
      $child_category = $request->child_category;
      $status = $request->status;
      $service_member_ships = ServiceMemberShip::where('id','>',0);
      if(!is_null($search))
      $service_member_ships=$service_member_ships->where([['ar_name','like','%'.$search.'%']])
      ->orWhere([['en_name','like','%'.$search.'%']]);
      
      if(!is_null($category))
      $service_member_ships = $service_member_ships->where('category',$category);
      
      if(!is_null($sub_category))
      $service_member_ships = $service_member_ships->where('sub_category',$sub_category);
      
      if(!is_null($child_category))
      $service_member_ships = $service_member_ships->where('child_category',$child_category);
      
      if(!is_null($status))
      $service_member_ships = $service_member_ships->where('status',$status);
      
      $service_member_ships = $service_member_ships->paginate();
      return view('dashboard.service_member_ships.table',compact('service_member_ships'));
  }
    $service_member_ships=ServiceMemberShip::paginate();
    $categories = ServiceCategory::get();
    return view('dashboard.service_member_ships.index',compact('service_member_ships','categories'));
}

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    $categories = ServiceCategory::get();
    return view('dashboard.service_member_ships.create',compact('categories'));
}

/**
 * ServiceMemberShip a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
     $data = $request->all();
    //  dd($data);
     $validate = Validator::make($data,[
      'ar_name'=>'required|array',
      'en_name'=>'required|array',
      'category'=>'required',
      'type'=>'required',
      'ads_number'=>'required',
      'price'=>'required',
      'months_number'=>'required',
  ]);
  
      if($validate->fails())
      return response()->json($validate->errors, 200);
      
     $service_member_ships = [];
     foreach ($data['ar_name'] as $key => $e) {
       $e = ['ar_name' => $data['ar_name'][$key] ,'en_name' => $data['en_name'][$key],
       'category' => $data['category'], 'type' => $data['type'][$key],
       'price'=>$data['price'][$key],
       'months_number'=>$data['months_number'][$key],
       'ads_number'=>$data['ads_number'][$key],
    ];

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
 
       array_push($service_member_ships,$e);
     }

     $res  = ServiceMemberShip::insert($service_member_ships);
     return redirect()->route('service_member_ships.index')->with('success','تم الحفظ بنجاح');

  }

public function edit($id)
{
 if(!empty($id))
 {
     $service_member_ship = ServiceMemberShip::where('id',$id)->get()->first();
     $categories = ServiceCategory::get();
     return view('dashboard.service_member_ships.edit',compact('service_member_ship','categories'));
 }
 return;
}

public function update(Request $request)
{
    $request->validate([
        'ar_name'=>'required|max:255',
        'en_name'=>'required|max:255',
        'category'=>'required',
        'type'=>'required',
        'ads_number'=>'required',
        'price'=>'required',
        'months_number'=>'required',
  
      ]);
      $status = isset($request->status) ? $request->status  : '0' ;
      $service_member_ship=  ServiceMemberShip::find($request->id);
      if (!$service_member_ship){
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

      $service_member_ship = $service_member_ship->update($data);

    return redirect()->route('service_member_ships.index')->with('success','تم الحفظ بنجاح');

}

/**
 * Remove the specified resource from storage.
 *
 * @param  \App\service_member_ships  $service_member_ships
 * @return \Illuminate\Http\Response
 */
public function delete($id)
{
    $service_member_ship = ServiceMemberShip::find($id);
    if (! $service_member_ship) {
        return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
    }
    $service_member_ship->delete();
    return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
}//end destroy

public function service_member_shipChangeStatus(Request $request)
{
    $cat = ServiceMemberShip::find($request->service_member_ship_id);
    $cat->status = $request->status;
    $cat->save();
    return response()->json(['success'=>'Status change successfully.']);
}//end catChangeStatus

public function getServiceMemberShip(Request $request)
{
    $data = $request->all();
    $category  = isset($data['category']) ? $data['category'] : null;
    $sub_category  = isset($data['sub_category']) ? $data['sub_category'] : null;
    $child_category  = isset($data['child_category']) ? $data['child_category'] : null;
    
    if(!is_null($child_category))
    return ServiceMemberShip::where('child_category',$child_category)->where('status','1')->get();
    if(!is_null($sub_category))
    return ServiceMemberShip::where('sub_category',$sub_category)->where('status','1')->get();
    if(!is_null($category))
    return ServiceMemberShip::where('category',$category)->where('status','1')->get();
}
}