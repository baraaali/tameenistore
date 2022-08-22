<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
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
        $vehicles=Vehicle::paginate('20');
        else
        $vehicles=Vehicle::where([['ar_name','like','%'.$search.'%']])->orWhere([['en_name','like','%'.$search.'%']])->paginate('20');
        
        return view('dashboard.vehicles.table',compact('vehicles'));
    }
      $vehicles=Vehicle::paginate();
      return view('dashboard.vehicles.index',compact('vehicles'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('dashboard.vehicles.create');
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
             $image->move(public_path('uploads/vehicles'),$e['image']);
         }
         array_push($vehicles,$e);
       }


       $res  = Vehicle::insert($vehicles);
       return redirect()->route('vehicles.index')->with('success','تم الحفظ بنجاح');

    }

  public function edit($id)
  {
   return view('dashboard.vehicles.edit');
  }

  public function update(Request $request)
  {
      $request->validate([
          'ar_name'=>'required|max:255',
          'en_name'=>'required|max:255'
        ]);
        $status = isset($request->status) ? $request->status  : '0' ;
        $imagename = null ;
        $vehicle=  Vehicle::where('id',$request->id)->first();
        if (!$vehicle){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        if($request->file('image'))
        {
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/vehicles'),$imagename);
        }
        $data = ['ar_name'=>$request->ar_name, 'en_name'=>$request->en_name, 'status'=>$status ];

        if($imagename) $data['image'] = $imagename;

        $vehicle = $vehicle->fill($data);
        $vehicle->save();
        $vehicle=  Vehicle::where('id',$request->id)->first();

      return redirect()->route('vehicles.index')->with('success','تم الحفظ بنجاح');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\vehicles  $vehicles
   * @return \Illuminate\Http\Response
   */
public function delete($id)
  {
      $vehicle = Vehicle::where('id',$id)->first();
      if (! $vehicle) {
          return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
      }
      $vehicle->delete();
      return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
  }//end destroy

  public function vehicleChangeStatus(Request $request)
  {
      $cat = Vehicle::where('id',$request->vehicle_id)->first();
      $cat->status = $request->status;
      $cat->save();
      return response()->json(['success'=>'Status change successfully.']);
  }//end catChangeStatus

}
