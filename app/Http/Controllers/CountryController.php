<?php

namespace App\Http\Controllers;

use App\country;
use Illuminate\Http\Request;

class CountryController extends Controller
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
           $countries=country::paginate('20');
           else
           $countries=country::where([['ar_name','like','%'.$search.'%']])->orWhere([['en_name','like','%'.$search.'%']])->paginate('20');
           return view('dashboard.countries.table',compact('countries'));
       }
       $countries=country::paginate('20');
       return view('dashboard.countries.index',compact('countries'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.countries.create')->with('countries',country::where('parent',0)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ar_name'=>'required|max:191|string',
            'en_name'=>'required|max:191|string',
            'ar_code'=>'max:191|string',
            'en_code'=>'max:191|string',
            'ar_currency'=>'max:191|string',
            'en_currency'=>'max:191|string',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);


        $country = new country();
        $country->parent = $request->parent;
        $country->ar_name = $request->ar_name;
        $country->en_name = $request->en_name;
        $country->ar_code = $request->ar_code;
        $country->en_code = $request->en_code;
        $country->ar_currency = $request->ar_currency;
        $country->en_currency = $request->en_currency;
        if($request->status != '1')
        {
            $country->status = 0;
        }
            if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $country->image = $imageName;
        }

        $country->save();



        if($request->stay == 1)
        {
            return back()->with('success','تم الحفظ بنجاح');
        }
        else
        {
            return redirect()->route('countries')->with('success','تم الحفظ بنجاح');

        }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($country)
    {
        $country = country::where('id',$country)->first();

        if($country)
        {
            return view('dashboard.countries.edit')->with(['country'=>$country,'countries'=>country::where('parent',0)->get()]);
        }
        else{
            return back();
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {  //dd($request->all());
         $request->validate([
            'ar_name'=>'required|max:191|string',
            'en_name'=>'required|max:191|string',
            'ar_code'=>'max:191|string',
            'en_code'=>'max:191|string',
            'ar_currency'=>'max:191|string',
            'en_currency'=>'max:191|string',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);


        $country =  country::where('id',$request->id)->first();

        $country->ar_name = $request->ar_name;
        $country->en_name = $request->en_name;
        $country->ar_code = $request->ar_code;
        $country->en_code = $request->en_code;
        $country->ar_currency = $request->ar_currency;
        $country->en_currency = $request->en_currency;
        $request->has('status')?$country->status = 1:$country->status = 0;

            if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $country->image = $imageName;
        }

        $country->save();



        if($request->stay == 1)
        {
            return back()->with('success','تم الحفظ بنجاح');
        }
        else
        {
            return redirect()->route('countries')->with('success','تم الحفظ بنجاح');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($country)
    {
        if($country != null)
        {
            country::where('id',$country)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($country)
    {
        if($country != null)
        {
            country::where('id',$country)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($country)
    {
        if($country != null)
        {
            country::where('id',$country)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }



    public function archive()
    {
        return view('dashboard.countries.archive')->with('countries',country::onlyTrashed()->paginate(1000));
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
