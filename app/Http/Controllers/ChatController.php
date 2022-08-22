<?php

namespace App\Http\Controllers;

use App\City;
use App\User;
use App\country;
use App\Message;
use App\Insurance;
use App\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }//end construct
  public function index(Request  $request,$id){
      //dd($request->all());
     // if (!$request->user) return redirect()->back();
        $receiver=User::find(Crypt::decrypt($id));
        $website = \App\Website::where('id',1)->first();
        $website->description= strip_tags(preg_replace('/\s+/', ' ', $website->description));
        $user_id=auth()->user()->id;
        $msgs = DB::select('select * from messages where from_user='.$user_id.' and to_user='.$receiver->id.' or from_user='.$receiver->id.' and to_user='.$user_id);
      return view('front.chat.index',compact('receiver','website','user_id','msgs'));
  }//end index

    public function send(Request  $request)
    {
        $request->validate([
            'banner_id'=>'msg',
        ]);
     //   dd($request->all);
        $from=auth()->user()->id;
        $to=$request->user;
        $receiver=User::find($request->user);
        $msg=$request->msg;
        Message::create(['body'=>$msg,'from_user'=>$from,'to_user'=>$to]);
        return redirect()->back();
    }//end send

}//end class
