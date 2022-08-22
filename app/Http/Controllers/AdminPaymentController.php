<?php

namespace App\Http\Controllers;
use App\PaymentHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminPaymentController extends Controller
{

      public function __construct()
        {
            $this->middleware(['admin']);
        }
        public function index()
        {
            $items = PaymentHistory::orderBy('id','desc')->paginate(10);
            $users=User::all();
            return view('dashboard.reports.index', compact('items','users'));
        } //end index

      public function showItem(Request $request){
        $items = \App\PaymentHistory::paginate(12);
          $users=User::all();
        if($request->isMethod('post'))
        {
//            $membership = $request->input('membership');
            $order = $request->input('order');
            $search = $request->input('search');
            $type = $request->input('type');
            $value = $request->input('value');
            $filters = [];
            foreach ($request->all() as $filter => $value) {
                //if($filter != 'membership' && $filter != 'order' && $filter != 'search')
                if( $filter != 'order' && $filter != 'search'&&$filter != 'type'&&$filters !=$value)
                    array_push($filters,[$filter,'=',$value]);
            }
            $items =  PaymentHistory::where($filters);
            if(!is_null($search))
            {
                $columns =   Schema::getColumnListing('payment_history');
                foreach ($columns as $column) {
                    $items->orWhere(function($q) use ($column,$search){
                        $q->where([[$column,'LIKE','%'.$search.'%']]);
                    });
                }
                $items->orWhereHas('user',function($q) use ($search){
                    $q->where([['name','LIKE','%'.$search.'%']]);
                });
                $items->orWhereHas('user',function($q) use ($search){
                    $q->where([['email','LIKE','%'.$search.'%']]);
                });
            }
            //  return $items->toSql();
//            if(!is_null($membership))  $items->where('type',$membership);
            if(!is_null($order))
                $items->orderBy(explode('-',$order)[0],explode('-',$order)[1]);
            if(!is_null($value))
                $items->orderBy('value','asc');
            if(!is_null($type))
                $items->where('type',$type);

            $items =  $items->paginate(12);
            // dd($items);
            return view('dashboard.reports.table',compact('items','users'));
        }
        // dd($countries);
        return view('dashboard.reports.index',compact('items','users'));
    }



}//end class
