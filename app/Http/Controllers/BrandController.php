<?php

namespace App\Http\Controllers;

use App\brands;
use App\Vehicle;
use App\CareShape;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
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
            $vehicle_id = $request->vehicle_id;
            $brands = brands::where('id','>',0);
            if(!is_null($search))
            {
                $brands = $brands->where([['name','like','%'.$search.'%']]);
            }
            if(!is_null($vehicle_id))
            {
                $brands = $brands->where('vehicle_id',$vehicle_id);
            }
            $brands = $brands->paginate();
            return view('dashboard.brands.table',compact('brands'));
        }
        $brands=brands::paginate();
        $vehicles = Vehicle::get();
        return view('dashboard.brands.index',compact('brands','vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles  = Vehicle::get();
        return view('dashboard.brands.create',compact('vehicles'));
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
        'vehicle_id'=>'required',
        'name'=>'required|array',
        'manufacturing_country'=>'required|array',
      ]);
    
        if($validate->fails())
        return response()->json($validate->errors, 200);
        
       $brands = [];
       foreach ($data['name'] as $key => $e) {
         $e = ['name' => $e,'manufacturing_country' => $data['manufacturing_country'][$key], 'vehicle_id' => $request->input('vehicle_id')];
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
         array_push($brands,$e);
       }
       $res  = brands::insert($brands);
       return redirect()->route('brands.index')->with('success','تم الحفظ بنجاح');

     }


    public function edit($id)
    {
        if(!empty($id))
        {
            $brand = brands::where('id',$id)->get()->first();
            $vehicles = Vehicle::get();
            return view('dashboard.brands.edit',compact('brand','vehicles'));
        }
        return;
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'vehicle_id'=>'required|max:255',
        ]);
        if (!isset($request->status)) $status=0;
        else $status=1;
        $brand=  brands::find($request->id);
        if (!$brand){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        $brand = $brand->fill([
            'name'=>$request->name,
            'vehicle_id'=>$request->vehicle_id,
            'manufacturing_country'=>$request->manufacturing_country,
            'status'=>$status,
        ]);
        $brand->save();

        return redirect()->route('brands.index')->with('success','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\brands  $brands
     * @return \Illuminate\Http\Response
     */
 public function delete($id)
    {
        $brand = brands::find($id);
        if (! $brand) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $brand->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

    public function brandChangeStatus(Request $request)
    {
        //\Log::info($request->all());
        $cat = brands::find($request->brand_id);
        $cat->status = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus

}
