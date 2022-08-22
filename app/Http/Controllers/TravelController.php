<?php

namespace App\Http\Controllers;
use App\Travel;
use Illuminate\Http\Request;


class TravelController extends Controller
{
    public function editCompany($lang){
        $user_id=auth()->user()->id;
        $com=Travel::where('user_id',$user_id)->first();
        return view('Cdashboard.travel.index',compact('lang'));
    }//end editCompany

}//end class
