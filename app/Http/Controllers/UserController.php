<?php

namespace App\Http\Controllers;

use App\City;
use App\User;
use App\Agents;
use App\carImages;
use Carbon\Carbon;
use App\Governorate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['getGovernorates','getCities']);
    }

    public function index()
    {
        $users=User::where('guard','!=',1)->orderBy('id','Desc')->paginate(20);
    	return view('dashboard.users.index',compact('users'));
    }
    public function edit($id)
    {
        $user=User::find($id);
        $countries = \App\country::where('status', 1)->get();
        return view('dashboard.users.edit',compact('user','countries'));
    }

     public function destroy($User)
    {
        if($User != null)
        {
            $user = User::where('id',$User)->first();
            $user->block = 0;
            $user->save();

            return back()->with('success','تم  الحظر');
        }
        else
        {
            return back();
        }
    }

     public function un_block($User)
     {
         if ($User != null) {
             $user = User::where('id', $User)->first();
             $user->block = 1;
             $user->save();
             return back()->with('success','تم  الاسترجاع');
         }
     }

    public function restore($User)
    {
        if($User != null)
        {
            User::where('id',$User)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($User)
    {
        if($User != null)
        {
            Mcenters::where('id',$User)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }



    public function archive()
    {
        return view('dashboard.users.archive')->with('users',User::onlyTrashed()->paginate(1000));
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (! $user) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $user->forceDelete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }//end destroy

    public function renewMemberUser(Request  $request){
       // dd($request->all());
        $user=User::find($request->user);
        //$user->started_at = Date('Y-m-d h:i:s');
       // $old_date=Carbon::createFromFormat('Y-m-d h:i:s', $user->ended_at);
        $user->ended_at = $request->date;
        //$user->ended_at = $old_date->addDays($request->duration);
        $user->save();
        //dd($user);
        return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
    }//end renewMemberUser

    public function update(Request  $request){
       // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|unique:users,email,'.$request->id,
            'country_id' => 'required|int'
            ]);
        $user=User::find($request->id)->fill($request->except('_token'));
        if($request->image)
        {
            $file = $request->file('image');
            $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);
            $user->image = $imageName;
        }
        $user->save();

        return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
    }

    public function getGovernorates(Request $request)
    {
        $id = $request->input('id');
        if(!is_null($id) && !empty($id))
        {
            $governorates  = Governorate::where('country_id',$id)->get();
            return response()->json($governorates, 200);
        }
        return response()->json([], 200);
    } 
     public function getCities(Request $request)
    {
        $id = $request->input('id');
        if(!is_null($id) && !empty($id))
        {
            $cities  = City::where('governorate_id',$id)->get();
            return response()->json($cities, 200);
        }
        return response()->json([], 200);
    }

}//end class
