<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
         return view('dashboard.pages.index')->with('pages',Categories::paginate(1000));
    }


    public function store(Request $request)
    {
        $request->validate([
            'ar_name' => 'required',
            'en_name' => 'required',
        ]);

        $newpage = new Categories();

        $newpage->ar_name = $request->ar_name;
        $newpage->en_name = $request->en_name;
        if($request->status != null)
        {
            $newpage->status = $request->status;
        }
        else
        {
            $newpage->status = 1;
        }


        $newpage->save();

        return back();
    }



    public function update(Request $request)
    {

        $request->validate([
            'ar_name' => 'required',
            'en_name' => 'required',
             ]);

        $newpage =  Categories::where('id',$request->id)->first();

        $newpage->ar_name = $request->ar_name;
        $newpage->en_name = $request->en_name;
        if($request->status != null)
        {
            $newpage->status = $request->status;
        }else
        {
            $newpage->status = 0;
        }


        $newpage->save();

        return back();
    }


    public function destroy($Pages)
    {
        if($Pages != null)
        {
            Categories::where('id',$Pages)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($Pages)
    {
        if($Pages != null)
        {
            Categories::where('id',$Pages)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($Pages)
    {
        if($Pages != null)
        {
            Categories::where('id',$Pages)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function archive()
    {
        return view('dashboard.pages.archive')->with('pages',Categories::onlyTrashed()->paginate(1000));
    }//end archive

    public function catChangeStatus(Request $request)
    {
        //\Log::info($request->all());
        // dd($request->status);
        $cat = Categories::find($request->cat_id);
        $cat->status = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus




}
