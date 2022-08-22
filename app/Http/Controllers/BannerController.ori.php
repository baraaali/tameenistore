<?php

namespace App\Http\Controllers;

use Validator;
use App\Banner;
use App\banners;
use App\country;
use App\DocumentsUser;
use Illuminate\Http\Request;

class BannerController extends Controller
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
        $lang = null;
        $banners=Banner::orderBy('id','desc')->paginate(10);
        $countries=country::where(['status'=>1])->get();

        return view('dashboard.banners.index',compact('banners','countries','lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('dashboard.banners.create');
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
            'duration'=>'required|integer',
            'type'=>'required|integer',
            'page'=>'required|integer',
        ]);
        Banner::create($request->all());

        return redirect()->route('banners.index')->with('success',' تم الحفظ بنجاح');
    }


    public function edit($id)
    {
        return view('dashboard.banners.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'price'=>'required|integer',
            'duration'=>'required|integer',
        ]);

        $use=  Banner::find($request->id);
        if (!$use){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        $use = $use->fill($request->all());
        $use->save();

        return redirect()->route('banners.index')->with('success','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $use = Banner::find($id);
        if (! $use) {
            return redirect()->route('banners.index')->with(['error' => 'بيانات غير موجودة']);
        }
        $use->delete();
        return redirect()->route('banners.index')->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy



}//end class
