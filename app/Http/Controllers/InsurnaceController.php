<?php

namespace App\Http\Controllers;

use App\Agents;
use App\country;
use App\Insurance;
use App\User;
use Illuminate\Http\Request;

class InsurnaceController extends Controller
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
        $insurnaces=Insurance::orderBy('id','desc')->orderBy('id','Desc')->paginate('20');
        return view('dashboard.insurnaces.index',compact('insurnaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries=country::where('status',1)->get();
        return view('dashboard.insurnaces.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'user_name'=>'required',
            'user_email'=>'required|unique:users,email',
            'password'=>'required|confirmed',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',
            'ar_address'=>'required',
            'en_address'=>'required',
            'image'=>'required|image|max:7000',
        ]);
        $newUser = new User();

        $newUser->name = $request->user_name;
        $newUser->email = $request->user_email;
        $newUser->country_id = $request->country_id; //normal person
        $newUser->password = bcrypt($request->password);
        $newUser->type = 4 ;
        $newUser->save();
        $insurance = new \App\Insurance();
        $insurance->country_id = $request->country_id;
        $insurance->user_id = $newUser->id;
        $insurance->ar_name = $request->ar_name;
        $insurance->en_name = $request->en_name;
        $insurance->ar_address = $request->ar_address;
        $insurance->en_address = $request->en_address;
        $insurance->phones = $request->phones;
        $insurance->website = $request->website;
        $insurance->email = $request->email;
        $insurance->google_map = $request->google_map;
        $insurance->days_on = $request->days_on;
        $insurance->times_on = $request->times_on;
        $insurance->visitors = 0;
        $insurance->status = 1;
        $insurance->special = 1;
         if($request->file('image')){
            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads'), $imageName);
             $insurance->image = $imageName;
        }
        $insurance->save();
        return redirect()->back()->with('success','تم الحفظ');

    }

    public function show(Agents $agents)
    {
        //
    }

    public function edit($agents)
    {
        if($agents != null)
        {
            return view('dashboard.insurnaces.edit')
            ->with([
                    'agent'=>Agents::where('id',$agents)->first(),
                    'countries' => \App\country::where('status',1)->get()]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'country_id'=>'required',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent =  Agents::where('id',$request->id)->first();

        $agent->country_id = $request->country_id;
        $agent->user_id = auth()->user()->id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $agent->image = $imageName;
        }

        $agent->fb_page = $request->fb_page;
        $agent->twitter_page = $request->twitter_page;
        $agent->website = $request->website;
        $agent->email = $request->email;
        $agent->google_map = $request->google_map;
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;
        $agent->car_type = $request->car_types;
        $agent->special = $request->specific;
        $agent->status = $request->status;
        $agent->instagram = $request->insta_page;
        $agent->phones = $request->phones;
        $agent->agent_type = $request->agent_type;
        $agent->save();


        if($request->agent_type == 1)
        {
            return redirect('dashboard/agents/index/1')->with('success','تم الحفظ');
        }
        else
        {
            return redirect('dashboard/agents/index/0')->with('success','تم الحفظ');
        }
    }

    public function destroy($agent)
    {
        if($agent != null)
        {  //dd($agent);
            Agents::where('id',$agent)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($agent)
    {
        if($agent != null)
        {
            Agents::where('id',$agent)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function force($agent)
    {
        if($agent != null)
        {   dd('dd');
            Agents::where('id',$agent)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }
    public function archive()
    {
        return view('dashboard.insurnaces.archive')->with('agents',Agents::onlyTrashed()->paginate(1000));
    }

    public function Cupdate(Request $request)
    {
        $request->validate([
            'country_id'=>'required',
            'ar_name'=>'required|string|max:191',
            'en_name'=>'required|string|max:191',

        ]);

        $agent =  Agents::where('id',$request->id)->first();
        $agent->country_id = $request->country_id;
        $agent->user_id = auth()->user()->id;
        $agent->ar_name = $request->ar_name;
        $agent->en_name = $request->en_name;
        $agent->ar_address= $request->ar_address;
        $agent->en_address = $request->en_address;

         if($request->file('image')){


            $imageName = $request->en_name.'.'.request()->image->getClientOriginalExtension();



            request()->image->move(public_path('uploads'), $imageName);

            $agent->image = $imageName;
        }

        $agent->fb_page = $request->fb_page;
        $agent->twitter_page = $request->twitter_page;
        $agent->website = $request->website;
        $agent->email = $request->email;
        $agent->google_map = $request->google_map;
        $agent->days_on = $request->days_on;
        $agent->times_on = $request->times_on;
        $agent->car_type = $request->car_types;
        $agent->special = $request->specific;
        $agent->status = $request->status;
        $agent->instagram = $request->insta_page;
        $agent->phones = $request->phones;
        $agent->agent_type = $request->agent_type;
        $agent->save();
        return redirect('Cdashboard/index')->with('success','تم الحفظ');
    }

    public function insurChangeStatus(Request $request)
    {

        $cat = Insurance::find($request->agent_id);
        $cat->status = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus

}
