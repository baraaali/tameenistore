<?php

namespace App\Http\Controllers;

use App\DocumentsUser;
use App\uses;
use App\Style;
use Illuminate\Http\Request;
use Validator;

class UseController extends Controller
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
        $uses=Style::orderBy('id','desc')->paginate();
        return view('dashboard.uses.index',compact('uses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.uses.create');
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
        ]);
        Style::create($request->all());

            return redirect()->route('uses.index')->with('success',' تم الحفظ بنجاح');
    }


    public function edit($id)
    {
     return view('dashboard.uses.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
        ]);

        $use=  Style::find($request->id);
        if (!$use){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        $use = $use->fill([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
        ]);
        $use->save();

        return redirect()->route('uses.index')->with('success','تم الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\uses  $uses
     * @return \Illuminate\Http\Response
     */
 public function delete($id)
    {
        $use = Style::find($id);
        if (! $use) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $use->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

    public function documents(){
        $docs=DocumentsUser::paginate('20');
        return view('dashboard.uses.docs',compact('docs'));
    }//end documents

}
