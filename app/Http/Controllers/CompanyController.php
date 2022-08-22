<?php

namespace App\Http\Controllers;

use App\country;
use App\Insurance;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $Companies = \App\Insurance::paginate(15);
        //dd($Companies);
       return view('dashboard.insurance.company',compact('Companies'));
    }



        public function companyChangeStatus(Request $request)
    {
        //\Log::info($request->all());
       // dd($request->status);
        $user = Insurance::find($request->company_id);
        $user->status = $request->status;
        $user->save();
     //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }
}
