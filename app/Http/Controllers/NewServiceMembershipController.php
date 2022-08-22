<?php

namespace App\Http\Controllers;

use App\NewServiceMembership;
use App\Price;
use App\prices;
use Illuminate\Http\Request;
use Validator;

class NewServiceMembershipController extends Controller
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
        $prices=NewServiceMembership::paginate();
       // $prices=NewServiceMembership::get()->dd();
        return view('dashboard.newservicesmemberships.index',compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.newservicesmemberships.create');
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
            'duration'=>'required|integer|max:500',
        ]);
       // dd($request->all());
        NewServiceMembership::create($request->all());

            return redirect()->route('new-service-memberships.index')->with('success',' تم الحفظ بنجاح');
    }


    public function edit($id)
    {
     return view('dashboard.newservicesmemberships.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'price'=>'required|integer',
            'type'=>'required|integer|in:0,1,2,3',
            'duration'=>'required|integer|max:500',
        ]);

        $price=  NewServiceMembership::find($request->id);
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

        return redirect()->route('new-service-memberships.index')->with('success','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\prices  $prices
     * @return \Illuminate\Http\Response
     */
 public function delete($id)
    {
        $price = NewServiceMembership::find($id);
        if (! $price) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $price->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

}//end class
