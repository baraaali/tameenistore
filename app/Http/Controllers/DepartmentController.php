<?php

namespace App\Http\Controllers;

use App\Exhibition;
use App\Agents;
use App\carImages;
use App\Cars;
use App\CarHolder;
use App\carPrices;
use App\country;
use App\AgentBranches;
use App\ExhibitorBranches;
use App\items;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\membership;
use App\User;
use App\models;

use Hash;

class DepartmentController extends Controller
{
    public function allDepartments($lang=null){
        if($lang == 'ar' || $lang == 'en')
        {
            App::setlocale($lang);
        }
        else
        {
            App::setlocale('ar');
        }
        // $day = date('Y-m-d');
        // $items=items::where(['status'=>1])->where('end_ad_date','>',$day);
        // if (getCountry() !=0) $items=$items->where('country_id',getCountry());
        // $items=$items->whereHas('user', function($q)
        // {$q->where('block',1);})
        //     ->paginate(15);
        return view('content.all_departments');
    }//end allDepartments

    public function searchDepartment(Request $request,$lang=null)
    {
        if ($lang == 'ar' || $lang == 'en') {
            App::setlocale($lang);
        } else {
            App::setlocale('ar');
        }
        $day = date('Y-m-d');
        $items = items::where(['status' => 1])->where('end_ad_date','>',$day);
        if (isset($request->category)){
            if ($request->category != 0) $items = $items->where(['category_id' => $request->category]);
        }
        if (getCountry() !=0) $items=$items->where('country_id',getCountry());
       if ($request->start_price) $items=$items->where('price','>=',intval($request->start_price));
       if ($request->end_price) $items=$items->where('price','<=',intval($request->end_price));
       if ($request->name) $items=$items->where('ar_name', 'like', '%' .$request->name. '%')->
       orWhere('en_name', 'like', '%' . $request->name. '%');
        $items=$items->whereHas('user', function($q)
        {$q->where('block',1);})->paginate(15);
        if (isset($request->category)) {
            return view('content.all_departments', compact('items', 'lang'));
        }else  return view('content.items',compact('items', 'lang'));
    }

}//end class
