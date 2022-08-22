<?php

namespace App\Http\Controllers;

use App\DepartmentMembership;
use App\Price;
use App\prices;
use Illuminate\Http\Request;
use Validator;

class DepatementMembershipController extends Controller
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
        $prices=DepartmentMembership::paginate();
        return view('dashboard.departmentmemberships.index',compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.departmentmemberships.create');
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
            'duration'=>'required|integer|max:50',
        ]);
        DepartmentMembership::create($request->all());

            return redirect()->route('dep-memberships.index')->with('success',' تم الحفظ بنجاح');
    }


    public function edit($id)
    {
     return view('dashboard.departmentmemberships.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'price'=>'required|integer',
            'type'=>'required|integer',
            'duration'=>'required|integer|max:50',
        ]);

        $price=  DepartmentMembership::find($request->id);
        if (!$price){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        $price = $price->fill([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'price'=>$request->price,
            'type'=>$request->type,
            'duration'=>$request->duration,
        ]);
        $price->save();

        return redirect()->route('dep-memberships.index')->with('success','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\prices  $prices
     * @return \Illuminate\Http\Response
     */
 public function delete($id)
    {
        $price = DepartmentMembership::find($id);
        if (! $price) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $price->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

}//end class
