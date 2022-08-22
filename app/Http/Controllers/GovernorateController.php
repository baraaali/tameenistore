<?php

namespace App\Http\Controllers;

use App\country;
use App\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GovernorateController extends Controller
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
           $governorates=Governorate::paginate('20');
           else
           $governorates=Governorate::where([['ar_name','like','%'.$search.'%']])->orWhere([['en_name','like','%'.$search.'%']])->paginate('20');
           
           return view('dashboard.governorates.table',compact('governorates'));
       }
       $governorates=Governorate::paginate('20');
       $countries  = country::where('status',1)->get();
       return view('dashboard.governorates.index',compact('governorates','countries'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries  = country::where('status',1)->get();
        return view('dashboard.governorates.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $governorates = $request->all()['data'];
       $validate = Validator::make($governorates,[
        '*.ar_name'=>'required|max:191|string',
        '*.en_name'=>'required|max:191|string',
        '*.country_id'=>'required|numeric',
       ]);

       if($validate->fails())
       return response()->json($validate->errors, 200);

        
       $res  = Governorate::insert($governorates);
       return response()->json($res, 200);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $governorate = Governorate::where('id',$id)->first();
        $countries  = country::where('status',1)->get();

        if($governorate)
        {
            return view('dashboard.governorates.edit',compact('governorate','countries'));
        }
        else{
            return back();
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {  
         $request->validate([
            'ar_name'=>'required|max:191|string',
            'en_name'=>'required|max:191|string',
            'country_id'=>'required|numeric',
        ]);


        $governorate =  Governorate::where('id',$request->id)->first();

        $governorate->ar_name = $request->ar_name;
        $governorate->en_name = $request->en_name;
        $governorate->country_id = $request->country_id;

        $governorate->save();

        if($request->stay == 1)
        {
            return back()->with('success','تم الحفظ بنجاح');
        }
        else
        {
            return redirect()->route('governorates')->with('success','تم الحفظ بنجاح');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function destroy($governorate)
    {
        if($governorate != null)
        {
            Governorate::where('id',$governorate)->forceDelete();
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
            Governorate::where('id',$governorate)->restore();
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
            Governorate::where('id',$governorate)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }



    public function archive()
    {
        return view('dashboard.governorates.archive')->with('governorates',Governorate::onlyTrashed()->paginate(1000));
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

