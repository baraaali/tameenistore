<?php

namespace App\Http\Controllers;

use App\membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
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
        return view('dashboard.memberships.index')->with('memberships',membership::orderBy('id','Desc')->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.memberships.create');
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
            'name'=>'required',
            'cost'=>'required',
            'duration'=>'required',
            'limit_posts'=>'required',
            'limit_docs'=>'required',
            'limit_person'=>'required',
            'ar_featuers'=>'required',
            'en_featuers'=>'required',
        ]);


        $membership = new membership();

        $membership->name = $request->name;
        $membership->cost = $request->cost;
        $membership->discount = $request->discount;
        $membership->start_date = $request->start_date;
        $membership->end_date = $request->end_date;
        $membership->duration = $request->duration;
        $membership->limit_posts = $request->limit_posts;
        $membership->limit_deps = $request->limit_deps;
        $membership->limit_docs = $request->limit_docs;
        $membership->limit_person = $request->limit_person;
        $membership->ar_m_feature = $request->ar_featuers;
        $membership->en_m_feature = $request->en_featuers;

        $membership->save();


        return redirect()->route('membership');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show(membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.memberships.edit')->with('membership',membership::where('id',$id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $request->validate([

            'name'=>'required',
            'cost'=>'required',
            'duration'=>'required',
            'limit_posts'=>'required',
            'ar_featuers'=>'required',
            'en_featuers'=>'required',
        ]);


        $membership = membership::where('id',$request->id)->first();

        $membership->name = $request->name;
        $membership->cost = $request->cost;
        $membership->discount = $request->discount;
        $membership->start_date = $request->start_date;
        $membership->end_date = $request->end_date;
        $membership->duration = $request->duration;
        $membership->limit_posts = $request->limit_posts;
        $membership->limit_deps = $request->limit_deps;
        $membership->limit_docs = $request->limit_docs;
        $membership->ar_m_feature = $request->ar_featuers;
        $membership->en_m_feature = $request->en_featuers;

        $membership->save();


        return redirect()->route('membership');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
       public function destroy($membership)
    {
        if($membership != null)
        {
            membership::where('id',$membership)->delete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($membership)
    {
        if($membership != null)
        {
            membership::where('id',$membership)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($Exhibition)
    {
        if($membership != null)
        {
            membership::where('id',$membership)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }



    public function archive()
    {
        return view('dashboard.memberships.archive')->with('memberships',membership::onlyTrashed()->paginate(1000));
    }
}
