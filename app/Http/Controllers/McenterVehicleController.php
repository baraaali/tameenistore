<?php

namespace App\Http\Controllers;

use App\McenterVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class McenterVehicleController extends Controller
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
        $search = $request->all()['search'];
        if(empty($search))
        $vehicles=McenterVehicle::paginate('20');
        else
        $vehicles=McenterVehicle::where([['ar_name','like','%'.$search.'%']])->orWhere([['en_name','like','%'.$search.'%']])->paginate('20');
        
        return view('dashboard.mcentervehicles.table',compact('vehicles'));
    }
      $vehicles=McenterVehicle::paginate();
      return view('dashboard.mcentervehicles.index',compact('vehicles'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('dashboard.mcentervehicles.create');
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
        
       $vehicles = [];
       foreach ($data['ar_name'] as $key => $e) {
         $e = ['ar_name' => $e,'en_name' => $data['en_name'][$key]];
         if(isset($data['status']))
         {
             $e['status'] = $data['status'][$key];
         }
         if(isset($data['image']))
         {
             $image = $data['image'][$key];
             $e['image'] = time().$key.'.'.$image->getClientOriginalExtension();
             $image->move(public_path('uploads'),$e['image']);
         }
         array_push($vehicles,$e);
       }


       $res  = McenterVehicle::insert($vehicles);
       return redirect()->route('mcentervehicles.index')->with('success','تم الحفظ بنجاح');

    }

  public function edit($id)
  {
   return view('dashboard.mcentervehicles.edit');
  }

  public function update(Request $request)
  {
      $request->validate([
          'ar_name'=>'required|max:255',
          'en_name'=>'required|max:255'
        ]);
        $status = isset($request->status) ? $request->status  : '0' ;
        $imagename = null ;
        $vehicle=  McenterVehicle::find($request->id);
        if (!$vehicle){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        if($request->file('image'))
        {
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads'),$imagename);
        }
        $data = ['ar_name'=>$request->ar_name, 'en_name'=>$request->en_name, 'status'=>$status ];

        if($imagename) $data['image'] = $imagename;

        $vehicle = $vehicle->fill($data);
        $vehicle->save();
        $vehicle=  McenterVehicle::find($request->id);

      return redirect()->route('mcentervehicles.index')->with('success','تم الحفظ بنجاح');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\vehicles  $vehicles
   * @return \Illuminate\Http\Response
   */
public function delete($id)
  {
      $vehicle = McenterVehicle::find($id);
      if (! $vehicle) {
          return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
      }
      $vehicle->delete();
      return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
  }//end destroy

  public function vehicleChangeStatus(Request $request)
  {
      $cat = McenterVehicle::find($request->vehicle_id);
      $cat->status = $request->status;
      $cat->save();
      return response()->json(['success'=>'Status change successfully.']);
  }//end catChangeStatus
}
