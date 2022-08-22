<?php

namespace App\Http\Controllers;

use App\Agents;
use App\items;
use Illuminate\Http\Request;

class AgentsController extends Controller
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
    public function index($type)
    {
        return view('dashboard.agents.index')->with('agents',Agents::where('agent_type',$type)->orderBy('id','Desc')->paginate(1000));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.agents.create')->with('countries',\App\country::where('status',1)->get());
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

        $agent = new Agents();

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function show(Agents $agents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function edit($agents)
    {
        if($agents != null)
        {
            return view('dashboard.agents.edit')
            ->with([
                    'agent'=>Agents::where('id',$agents)->first(),
                    'countries' => \App\country::where('status',1)->get()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agents  $agents
     * @return \Illuminate\Http\Response
     */
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
            return back()->with('success','تم الحفظ');
        }
        else
        {
            return back()->with('success','تم الحفظ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agents  $agents
     * @return \Illuminate\Http\Response
     */
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
        return view('dashboard.agents.archive')->with('agents',Agents::onlyTrashed()->paginate(1000));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agents  $agents
     * @return \Illuminate\Http\Response
     */
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

    public function agentChangeStatus(Request $request)
    {
        //\Log::info($request->all());
        // dd($request->status);
        $cat = Agents::find($request->agent_id);
        $cat->status = $request->status;
        $cat->save();
        $items=items::where('user_id',$cat->user_id)->get();
        foreach ($items as $item){
            $item->status=$request->status;
            $item->save();
        }
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus

}
