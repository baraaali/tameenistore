<?php

namespace App\Http\Controllers;

use Validator;
use App\brands;
use App\models;
use App\Vehicle;
use App\CareShape;
use Illuminate\Http\Request;

class ModelController extends Controller
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
        $brand_id = $request->brand_id;
        $status = $request->status;
        $care_shape_id = $request->care_shape_id;
        $vehicle_id = $request->vehicle_id;
        $models = models::where('id','>',0);
        if(!is_null($search))
        {
            $models= $models->where([['name','like','%'.$search.'%']]);
        }
        if(!is_null($brand_id))
        {
            $models= $models->where('brand_id',$brand_id);
        } 
        if(!is_null($vehicle_id))
        {
            $models= $models->whereHas('brands',function($q) use($vehicle_id){
                $q->where('vehicle_id',$vehicle_id);
            });
        }
        if(!is_null($care_shape_id))
        {
            $models= $models->where('care_shape_id',$care_shape_id);
        }
        if(!is_null($status))
        {
            $models= $models->where('status',$status);
        }
        
       // $models = $models->paginate();
         $models = $models->get();
         $is_search = true;

       return view('dashboard.models.table',compact('models','is_search'));
    }
        $models=models::latest()->paginate();
        $brands=brands::all();
        $careshapes=CareShape::all();
        $vehicles=Vehicle::all();
        return view('dashboard.models.index',compact('models','brands','careshapes','vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands=brands::get();
        $careshapes  = CareShape::get();
        return view('dashboard.models.create',compact('brands','careshapes'));
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
        'brand_id'=>'required',
        'care_shape_id'=>'required',
        'name'=>'required|array',
      ]);
    
        if($validate->fails())
        return response()->json($validate->errors, 200);
        
       $models = [];
       foreach ($data['name'] as $key => $e) {
         $e = [
             'name' => $e, 
             'brand_id' => $request->input('brand_id'),
             'care_shape_id' => $request->input('care_shape_id'),
         ];
             
         if(isset($data['status']))
         {
             $e['status'] = $data['status'][$key];
         } 
        if(isset($data['passengers']))
         {
             $e['passengers'] = $data['passengers'][$key];
         }
       
         array_push($models,$e);
       }
       $res  = models::insert($models);
       return redirect()->route('models.index')->with('success','تم الحفظ بنجاح');
    }

    public function edit($id)
    {

    if(!empty($id))
        {
            $model = models::where('id',$id)->get()->first();
            $brands=brands::get();
            $careshapes  = CareShape::get();
            return view('dashboard.models.edit',compact('model','brands','careshapes'));
        } 
        return;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'name'=>'required|max:255',
            'brand_id'=>'required|integer',
            'care_shape_id'=>'required|integer',
        ]);
        if (isset($request->status)) $data['status']='1';
        else $data['status']='0';

        $brand=  models::find($request->id);
        // dd($brand);
        if (!$brand){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        $brand = $brand->fill($data);
        $brand->save();
        return redirect()->route('models.index')->with('success','تم الحفظ بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models  $models
     * @return \Illuminate\Http\Response
     */
 public function delete($id)
    {
        $brand = models::find($id);
        if (! $brand) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $brand->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

//    public function modelChangeStatus(Request $request)
//    {
//        //\Log::info($request->all());
//        $model = models::find($request->model_id);
//        $model->status = $request->status;
//        $model->save();
//        //   dd($user);
//
//        return response()->json(['success'=>'Status change successfully.']);
//    }//end catChangeStatus

}
