<?php

namespace App\Http\Controllers;

use App\Agents;
use App\User;
use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
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
    public function showUsers()
    {
        $users=User::where(['block'=>1,'guard'=>0])->paginate(39);
        return view('dashboard.mails.index',compact('users'));
    }//end index

   public function sendEmail(Request  $request){
    //dd($request->all());
       $request->validate([
           'message' => 'required',
           'emails' => 'array|min:1|required',
           ]);
       $text=$request->message;
       foreach ($request->emails as $email){
           Mail::send([], [], function($message) use ($email,$text) {

               $message->to($email, 'Tameenin Store')->subject
               ('New Request')// here comes what you want
               ->setBody($text, 'text/html'); // assuming text/plain
               $message->from('info@tameenistore.com','Customer Services');
           });
       }
       return redirect()->back()->with('success','تم الارسال بنجاح');
   }//end sendEmail


}//end class
