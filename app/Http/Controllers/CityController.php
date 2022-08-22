<?php

namespace App\Http\Controllers;

use App\City;
use App\country;
use App\Insurance;
use App\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
       if($request->isMethod('post'))
       {
           $search = $request->all()['search'];
           if(empty($search))
           $cities=City::paginate('20');
           else
           $cities=City::where([['ar_name','like','%'.$search.'%']])->orWhere([['en_name','like','%'.$search.'%']])->paginate('20');
           
           return view('dashboard.cities.table',compact('cities'));
       }
       $cities=City::paginate('20');
       $governorates  = Governorate::where('status',1)->get();
       return view('dashboard.cities.index',compact('cities','governorates'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $governorates  = Governorate::where('status',1)->get();
        $countries  = country::where('status',1)->get();
        return view('dashboard.cities.create',compact('governorates','countries'));
    }

    public function getGovernorates($id)
    {
        $governorates  = Governorate::where('country_id',$id)->get();
        return response()->json($governorates, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       $cities = $request->all()['data'];
       $validate = Validator::make($cities,[
           '*.ar_name'=>'required|max:191|string',
           '*.en_name'=>'required|max:191|string',
           '*.governorate_id'=>'required|numeric',
        ]);

       if($validate->fails())
       return response()->json($validate->errors(), 200);

       $res  = City::insert($cities);
       return response()->json($res, 200);
       

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\city  $governorate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::where('id',$id)->first();
        $governorates  = Governorate::where('country_id',$city->governorate->country->id)->get();

        if($city)
        {
            return view('dashboard.cities.edit',compact('city','governorates'));
        }
        else{
            return back();
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\city  $governorate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {  
         $request->validate([
            'ar_name'=>'required|max:191|string',
            'en_name'=>'required|max:191|string',
            'governorate_id'=>'required|numeric',
        ]);


        $governorate =  City::where('id',$request->id)->first();

        $governorate->ar_name = $request->ar_name;
        $governorate->en_name = $request->en_name;
        $governorate->governorate_id = $request->governorate_id;

        $governorate->save();

        if($request->stay == 1)
        {
            return back()->with('success','تم الحفظ بنجاح');
        }
        else
        {
            return redirect()->route('cities')->with('success','تم الحفظ بنجاح');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\city  $governorate
     * @return \Illuminate\Http\Response
     */
    public function destroy($governorate)
    {
        if($governorate != null)
        {
            City::where('id',$governorate)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($governorate)
    {
        if($governorate != null)
        {
            City::where('id',$governorate)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($governorate)
    {
        if($governorate != null)
        {
            City::where('id',$governorate)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }



    public function archive()
    {
        return view('dashboard.cities.archive')->with('cities',City::onlyTrashed()->paginate(1000));
    }

        public function companyChangeStatus(Request $request)
    {
        \Log::info($request->all());
        $user = \App\Insurance::find($request->company_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
