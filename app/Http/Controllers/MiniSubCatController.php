<?php

namespace App\Http\Controllers;

use App\MiniSubCat;
use Illuminate\Http\Request;

class MiniSubCatController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('dashboard.minisubcats.index')->with('minisubcats',MiniSubCat::paginate(20));
    }


    public function store(Request $request)
    {
      // dd($request->all());
        $request->validate([
            'name_en' => 'required',
            'name_en' => 'required',
            'subCat_id' => 'required|exists:subCats,id',
        ]);
        $newcat = new MiniSubCat();
        $newcat->name_ar = $request->name_ar;
        $newcat->name_en = $request->name_en;
        $newcat->subCat_id = $request->subCat_id;

        $newcat->save();
        return back();
    }



    public function update(Request $request)
    {
//dd($request->all());
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'subCat_id' => 'required|exists:subCats,id',
             ]);

        $newcat =  MiniSubCat::where('id',$request->id)->first();

        $newcat->name_ar = $request->name_ar;
        $newcat->name_en = $request->name_en;
        $newcat->subCat_id = $request->subCat_id;
       
        $newcat->save();

        return back();
    }


    public function destroy($cats)
    {
        if($cats != null)
        {
            MiniSubCat::where('id',$cats)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($cats)
    {
        if($cats != null)
        {
            MiniSubCat::where('id',$cats)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($cats)
    {
        if($cats != null)
        {
            MiniSubCat::where('id',$cats)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function archive()
    {
        return view('dashboard.sminiubcats.archive')->with('cats',Cat::onlyTrashed()->paginate(20));
    }//end archive

    // public function catChangeStatus(Request $request)
    // {
    //     //\Log::info($request->all());
    //     // dd($request->status);
    //     $cat = MiniSubCat::find($request->cat_id);
    //     $cat->status = $request->status;
    //     $cat->save();
    //     //   dd($user);

    //     return response()->json(['success'=>'Status change successfully.']);
    // }//end catChangeStatus




}
