<?php

namespace App\Http\Controllers;

use App\MemberInsurance;
use App\Price;
use App\prices;
use Illuminate\Http\Request;
use Validator;

class MemberInsuranceController extends Controller
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
    public function index()
    {
        $prices=MemberInsurance::paginate();
        return view('dashboard.memberinsurances.index',compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.memberinsurances.create');
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
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'price'=>'required|integer',
            'type'=>'required|integer',
            'duration'=>'required|integer',
//            'free'=>'required|integer',
        ]);
        MemberInsurance::create($request->all());

            return redirect()->route('member-insurance.index')->with('success',' تم الحفظ بنجاح');
    }


    public function edit($id)
    {
     return view('dashboard.memberinsurances.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'price'=>'required|integer',
            'type'=>'required|integer',
            'duration'=>'required|integer',
        //    'free'=>'required|integer',
        ]);
        //dd($request->all());
        if (!isset($request->free)) $paid='0';
        else $paid='1';

        $price=  MemberInsurance::find($request->id);
        if (!$price){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        //dd($paid);
        $price = $price->update([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'type'=>$request->type,
            'duration'=>$request->duration,
            'free'=>$paid,
            'price'=>$request->price,
        ]);
       //dd($price);
     //  $price->save();

        return redirect()->route('member-insurance.index')->with('success','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\prices  $prices
     * @return \Illuminate\Http\Response
     */
 public function delete($id)
    {
        $price = MemberInsurance::find($id);
        if (! $price) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $price->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

}//end class
