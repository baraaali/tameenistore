<?php

namespace App\Http\Controllers;

use App\SubCat;
use Illuminate\Http\Request;

class SubCatController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('dashboard.subcats.index')->with('subcats',SubCat::paginate(20));
    }


    public function store(Request $request)
    {
      // dd($request->all());
        $request->validate([
            'name_en' => 'required',
            'name_en' => 'required',
            'cat_id' => 'required|exists:cats,id',
            'image' => 'sometimes:nullable|image',
        ]);
        $newcat = new SubCat();
        $newcat->name_ar = $request->name_ar;
        $newcat->name_en = $request->name_en;
        $newcat->cat_id = $request->cat_id;
        if(isset($request->status))
        {
            $newcat->status = $request->status;
        }
        else
        {
            $newcat->status = 0;
        }
    
        if($request->file('image')){
            $imageName = rand().time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $newcat->image = $imageName;
        }
        $newcat->save();
        return back();
    }



    public function update(Request $request)
    {
//dd($request->all());
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'cat_id' => 'required|exists:cats,id',
             'image' => 'sometimes:nullable|image',
             ]);

        $newcat =  SubCat::where('id',$request->id)->first();

        $newcat->name_ar = $request->name_ar;
        $newcat->name_en = $request->name_en;
        $newcat->cat_id = $request->cat_id;
         if($request->file('image')){
            $imageName = rand().time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
            $newcat->image = $imageName;
        }
        if($request->status != null)
        {
            $newcat->status = $request->status;
        }else
        {
            $newcat->status = 0;
        }


        $newcat->save();

        return back();
    }


    public function destroy($cats)
    {
        if($cats != null)
        {
            SubCat::where('id',$cats)->forceDelete();
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
            Cat::where('id',$cats)->restore();
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
            SubCat::where('id',$cats)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function archive()
    {
        return view('dashboard.subcats.archive')->with('cats',Cat::onlyTrashed()->paginate(20));
    }//end archive

    public function catChangeStatus(Request $request)
    {
        //\Log::info($request->all());
        // dd($request->status);
        $cat = SubCat::find($request->cat_id);
        $cat->status = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus




}
