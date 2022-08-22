<?php

namespace App\Http\Controllers;

use App\AdsMembership;
use App\Price;
use App\prices;
use Illuminate\Http\Request;
use Validator;

class AdsMembershipController extends Controller
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
        $prices=AdsMembership::paginate();
       // $prices=AdsMembership::get()->dd();
        return view('dashboard.adsmemberships.index',compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.adsmemberships.create');
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
            'type'=>'required|integer|in:0,1,2,3',
            'duration'=>'required|integer|max:50',
        ]);
       // dd($request->all());
        AdsMembership::create($request->all());

            return redirect()->route('ads-memberships.index')->with('success',' تم الحفظ بنجاح');
    }


    public function edit($id)
    {
     return view('dashboard.adsmemberships.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'price'=>'required|integer',
            'type'=>'required|integer|in:0,1,2,3',
            'duration'=>'required|integer|max:50',
        ]);

        $price=  AdsMembership::find($request->id);
        if (!$price){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        $price = $price->fill([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'price'=>$request->price,
            'duration'=>$request->duration,
            'type'=>$request->type,
        ]);
        $price->save();

        return redirect()->route('ads-memberships.index')->with('success','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\prices  $prices
     * @return \Illuminate\Http\Response
     */
 public function delete($id)
    {
        $price = AdsMembership::find($id);
        if (! $price) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $price->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

}//end class
