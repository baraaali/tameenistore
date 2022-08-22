<?php

namespace App\Http\Controllers;

use App\Exhibition;
use App\ExhibitorBranches;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
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
        return view('dashboard.exhibitors.index')->with('exhibitors',Exhibition::paginate(1000));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.exhibitors.create')->with('countries',\App\country::where('status',1)->get());
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
            'country_id'=>'required',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',
            
        ]);

        $exhibitor = new Exhibition();

        $exhibitor->country_id = $request->country_id;
        $exhibitor->user_id = auth()->user()->id;
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();

  

            request()->image->move(public_path('uploads'), $imageName);

            $exhibitor->image = $imageName;
        }

        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_types;
        $exhibitor->special = $request->specific;
        $exhibitor->status = $request->status;
        $exhibitor->instagram = $request->insta_page;

        $exhibitor->save();


        if($request->phones)
        {
            $list = explode('-',$request->phones);
            if(count($list) >= 1)
            {
                foreach($list as $phone)
                {
                    $phoneNumber = new \App\exhibitionPhones();

                    $phoneNumber->exhbitor_id = $exhibitor->id;
                    $phoneNumber->phone = $phone;
                    $phoneNumber->save();
                }
            }
        }

        return redirect('dashboard/exhibitors/index')->with('success','تم الحفظ');
    }


    public function storeBranch(Request $request)
    {
        $request->validate([
            'exhibitor_id'=>'required',
            
        ]);

        $exhibitor = new ExhibitorBranches();

        $exhibitor->exhibitor_id = $request->exhibitor_id;
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();

  

            request()->image->move(public_path('uploads'), $imageName);

            $exhibitor->image = $imageName;
        }

        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_types;
        $exhibitor->special = $request->specific;
        $exhibitor->status = $request->status;
        $exhibitor->instagram = $request->insta_page;
        $exhibitor->phones = $request->phone;
        $exhibitor->save();


       

        return redirect('dashboard/exhibitors/index')->with('success','تم الحفظ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exhibition  $exhibition
     * @return \Illuminate\Http\Response
     */
    public function show(Exhibition $exhibition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exhibition  $exhibition
     * @return \Illuminate\Http\Response
     */
    public function edit($exhibition)
    {
        if($exhibition != null)
        {
            return view('dashboard.exhibitors.edit')
            ->with([
                    'exhibitor'=>Exhibition::where('id',$exhibition)->first(),
                    'countries' => \App\country::where('status',1)->get()]);
        }
    }
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exhibition  $exhibition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $request->validate([
            'country_id'=>'required',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',
            
        ]);

        $exhibitor = Exhibition::where('id',$request->id)->first();

        $exhibitor->country_id = $request->country_id;
        $exhibitor->user_id = auth()->user()->id;
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();

  

            request()->image->move(public_path('uploads'), $imageName);

            $exhibitor->image = $imageName;
        }

        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_types;
        $exhibitor->special = $request->specific;
        $exhibitor->status = $request->status;
        $exhibitor->instagram = $request->insta_page;

        $exhibitor->save();


        if($request->phones)
        {
            

            $list = explode('-',$request->phones);
            if(count($list) >= 1)
            {
                $olds =  \App\exhibitionPhones::where('exhbitor_id',$exhibitor->id)->get();
                    foreach($olds as $old)
                    {
                        $old->delete();
                    }
                foreach($list as $phone)
                {
                    $phoneNumber = new \App\exhibitionPhones();

                    $phoneNumber->exhbitor_id = $exhibitor->id;
                    $phoneNumber->phone = $phone;
                    $phoneNumber->save();
                }
            }
        }

        return redirect('dashboard/exhibitors/index')->with('success','تم الحفظ');
    }


        public function updateBranch(Request $request)
         {
         $request->validate([
            'exhibitor_id'=>'required',
            
        ]);

        $exhibitor = ExhibitorBranches::where('id',$request->id)->first();

        $exhibitor->country_id = $request->country_id;
        $exhibitor->user_id = auth()->user()->id;
        $exhibitor->ar_name = $request->ar_name;
        $exhibitor->en_name = $request->en_name;
        $exhibitor->ar_description = $request->ar_description;
        $exhibitor->en_description = $request->en_description;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();

  

            request()->image->move(public_path('uploads'), $imageName);

            $exhibitor->image = $imageName;
        }

        $exhibitor->fb_page = $request->fb_page;
        $exhibitor->twitter_page = $request->twitter_page;
        $exhibitor->website = $request->website;
        $exhibitor->email = $request->email;
        $exhibitor->google_map = $request->google_map;
        $exhibitor->days_on = $request->days_on;
        $exhibitor->times_on = $request->times_on;
        $exhibitor->car_type = $request->car_types;
        $exhibitor->special = $request->specific;
        $exhibitor->status = $request->status;
        $exhibitor->instagram = $request->insta_page;
        $exhibitor->phones = $request->phone;
        $exhibitor->save();

        $exhibitor->save();


      

        return redirect('dashboard/exhibitors/index')->with('success','تم الحفظ');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exhibition  $exhibition
     * @return \Illuminate\Http\Response
     */
     public function destroy($Exhibition)
    {
        if($Exhibition != null)
        {
            Exhibition::where('id',$Exhibition)->delete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($Exhibition)
    {
        if($Exhibition != null)
        {
            Exhibition::where('id',$Exhibition)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($Exhibition)
    {
        if($Exhibition != null)
        {
            Exhibition::where('id',$Exhibition)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


         public function destroyBranch($Exhibition)
    {
        if($Exhibition != null)
        {
            ExhibitorBranches::where('id',$Exhibition)->delete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restoreBranch($Exhibition)
    {
        if($Exhibition != null)
        {
            ExhibitorBranches::where('id',$Exhibition)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function forceBranch($Exhibition)
    {
        if($Exhibition != null)
        {
            ExhibitorBranches::where('id',$Exhibition)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }




    public function archive()
    {
        return view('dashboard.exhibitors.archive')->with('exhibitors',Exhibition::onlyTrashed()->paginate(1000));
    }
}
