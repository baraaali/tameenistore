<?php

namespace App;

namespace App\Http\Controllers;
use App\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
     public function __construct()
        {
            $this->middleware('admin');
        }
    public function edit() {
       return view('dashboard.website');
    }

    public function update_model(Request $request) {
         //dd($request->all());
        $request->validate([
            'keywords'=>'required',
            'auth_meta_tags'=>'required',
            'description'=>'required',
            'phone'=>'required',
            'token'=>'required',
        ]);
//$ar=strip_tags(preg_replace('/\s+/', ' ', $request->description_ar));
//$en=strip_tags(preg_replace('/\s+/', ' ', $request->description_en));
//$des=strip_tags(preg_replace('/\s+/', ' ', $request->description));
        $website = Website::where('id',1)->first();
        if($website){
            $website->auth_meta_tags= $request->auth_meta_tags;
            $website->description= $request->description;
             $website->description_ar= $request->description_ar;
            $website->description_en= $request->description_en;
            $website->token= $request->token;
            $website->email_1= $request->email_1;
            $website->email_2= $request->email_2;
            $website->phone_1= $request->phone_1;
            $website->phone_2= $request->phone_2;
            $website->google_map= $request->google_map;
            $website->keywords= $request->keywords;
            $website->phone= $request->phone;
            $request->has('status')?$website->data = 1:$website->data = 0;
            $request->has('whats')?$website->whats = 1:$website->whats = 0;
            $request->has('fatoorah')?$website->fatoorah = 1:$website->fatoorah = 0;
            $request->has('fatoorah_tameen')?$website->fatoorah_tameen = 1:$website->fatoorah_tameen = 0;
            $website->save();
      //  dd($website);
        } else {
            $website = new website();
            $website->authorize_meta_tag= $request->authorize_meta_tag;
            $website->description= $request->description;
            $website->description_ar= $request->description_ar;
            $website->description_en= $request->description_en;
            $website->token= $request->token;
            $website->email_1= $request->email_1;
            $website->email_2= $request->email_2;
            $website->phone_1= $request->phone_1;
            $website->phone_2= $request->phone_2;
            $website->google_map= $request->google_map;
            $website->keywords= $request->keywords;
            $request->has('status')?$website->data = 1:$website->data = 0;
            $request->has('whats')?$website->whats = 1:$website->whats = 0;
            $request->has('fatoorah')?$website->fatoorah = 1:$website->fatoorah = 0;
            $request->has('fatoorah_tameen')?$website->fatoorah_tameen = 1:$website->fatoorah_tameen = 0;
            $website->save();
        }
        return back();
    }
}
