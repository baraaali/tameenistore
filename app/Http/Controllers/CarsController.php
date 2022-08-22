<?php

namespace App\Http\Controllers;

use App\Cars;
use App\brands;
use App\models;
use App\country;
use App\Vehicle;
use App\CarHolder;
use App\carImages;
use App\carPrices;
use App\AdsMembership;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CarsController extends Controller
{


    public function __construct()
    {
       $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conditions = auth()->user()->guard == 1 ? [] : [['user_id','=',auth()->user()->id]];
        $cars= Cars::where($conditions)->where('sell',1)->orderBy('id','desc')->paginate();
        $countries = Country::where('status',1)->get();
        $view = "dashboard.cars-sell.index";
        
        if($request->isMethod('post'))
        {
            $membership = $request->input('membership');
            $order = $request->input('order');
            $search = $request->input('search');
            $status = $request->input('status');
            $filters = [];
            foreach ($request->all() as $filter => $value) {
                if($filter != 'membership' && $filter != 'order' && $filter != 'search')
                    array_push($filters,[$filter,'=',$value]);
            }
            $items =  \App\Cars::where($filters);
           
            if(!is_null($search))
            {
            $columns =   Schema::getColumnListing('cars');
            foreach ($columns as $column) {
                $items->orWhere(function($q) use ($column,$search){
                    $q->where([[$column,'LIKE','%'.$search.'%']]);
                });
            }
            $items->orWhereHas('user',function($q) use ($search){
                $q->where([['name','LIKE','%'.$search.'%']]);
            });
            }

            if(!is_null($membership)) 
            $items->whereHas('memberships',function($q) use ($membership){
                $q->where('type',$membership);
            });

            if(!is_null($order))
            $items->orderBy(explode('-',$order)[0],explode('-',$order)[1]);

            $cars =  $items->where($conditions)->paginate();
            $view = "dashboard.cars-sell.table";
        }
        return view($view,compact('cars','countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles = Vehicle::where('status','1')->get();
        $brands = brands::where('status',1)->get();
        $models = models::get();
        $countries= country::where('status',1)->get();
        return view('dashboard.cars-sell.create',compact('vehicles','brands','models','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // save car for sell
    public function store(Request $request)
    {

        $request->validate([
            'country_id'=>'required',
            'governorate_id'=>'required',
            'city_id'=>'required',
            'vehicle_id'=>'required',
            'ar_name' => 'required',
            'en_name' => 'required',
            'ar_brand' => 'required',
            'ar_model' => 'required',
            'year' => 'required',
            'color' => 'required',
            'transmission' => 'required',
            'used' => 'required',
            'ar_description' => 'required',
            'en_description' => 'required',
            'ar_features' => 'required',
            'en_features' => 'required',
            'images' => 'min:1',
            'cost' => 'required',
            'main_image' => 'required',


        ]);

        $car = new Cars();

        $car->en_name = $request->en_name;
        $car->ar_name = $request->ar_name;
        $car->ar_model = $request->ar_model;
        $car->en_model = $request->ar_model;
        $car->ar_brand = $request->ar_brand;
        $car->year = $request->year;
        $car->country_id = $request->country_id;
        $car->vehicle_id = $request->vehicle_id;
        $car->governorate_id = $request->governorate_id;
        $car->city_id = $request->city_id;
        $car->color = $request->color;
        $car->transmission = $request->transmission;
        $car->fuel = $request->fuel;
        $car->used = $request->used;
        $car->en_description = $request->en_description;
        $car->ar_description = $request->ar_description;
        $car->en_features = $request->en_features;
        $car->ar_features = $request->ar_features;
        $car->max = $request->maxSpeed;
        $car->engine = $request->engine;
        $car->kilo_meters = $request->kilometers;
        $car->special = $request->special;
        $car->status =$request->status;
        $car->sell = 1;
        $car->status = 1;
        $car->agent_id  = 0;
        $car->user_id  = auth()->user()->id;

        // main image
        $car->main_image = Str::random(8).$request->main_image->getClientOriginalExtension();
        $request->main_image->move(public_path('uploads'), $car->main_image);

       //ad end date
        $price=AdsMembership::where('id',$request->special)->first();
        $car->end_ad_date = date('Y-m-d', strtotime(date('Y-m-d') . " +".$price->duration." days"));

        // agent or single seller
        if(isset(auth()->user()->agentDetails))
        {
            $car->agent_id = auth()->user()->agentDetails->id;
        }
        $car->save();

        if($request->images)
        {
            $files = $request->file('images');

            foreach($files as $file)
            {

                $newImage = new carImages();
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();



            $file->move(public_path('uploads'), $imageName);

                $newImage->car_id = $car->id;
                $newImage->image = $imageName;
                $newImage->save();
            }
        }

        $holder = new CarHolder();

        $holder->car_id = $car->id;
        $holder->is_user = auth()->user()->id;

        $holder->save();


        $country = country::where('id',$request->country_id)->first();
        $price = new carPrices();

        $price->car_id = $car->id;

        $price->currency = $country->en_currency;

        $price->cost = $request->cost;

        $price->discount_amount = $request->discount_amount;

        $price->discount_percent = $request->discount_percent;

        $price->discount_start_date = $request->discount_start_date;

        $price->discount_end_date = $request->discount_end_date;

        $price->save();

        return redirect('dashboard/cars/index')->with('success','تم الحفظ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function show(Cars $cars)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function edit($car)
    {
       return view('dashboard.cars-sell.edit')->with(['car'=>Cars::where('id',$car)->first(),'countries'=>\App\country::where('status',1)->get(),'brands'=>\App\brands::where('status',1)->get(),'models'=>\App\models::get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
          $request->validate([
            'country_id'=>'required',
            'ar_name' => 'required',
            'en_name' => 'required',
            'ar_brand' => 'required',
            'ar_model' => 'required',
            'year' => 'required',
            'color' => 'required',
            'transmission' => 'required',
            'used' => 'required',
            'ar_description' => 'required',
            'en_description' => 'required',
            'ar_features' => 'required',
            'en_features' => 'required',
            'images' => 'min:1',
            'cost' => 'required',


        ]);

        $car =  Cars::where('id',$request->id)->first();

        $car->en_name = $request->en_name;
        $car->ar_name = $request->ar_name;
        $car->ar_model = $request->ar_model;
        $car->en_model = $request->ar_model;
        $car->ar_brand = $request->ar_brand;
        $car->year = $request->year;
        $car->country_id = $request->country_id;
        $car->color = $request->color;
        $car->transmission = $request->transmission;
        $car->fuel = $request->fuel;
        $car->used = $request->used;
        $car->en_description = $request->en_description;
        $car->ar_description = $request->ar_description;
        $car->en_features = $request->en_features;
        $car->ar_features = $request->ar_features;
        $car->max = $request->maxSpeed;
        $car->engine = $request->engine;
        $car->kilo_meters = $request->kilometers;
        $car->special = $request->special;
        $car->status = $request->status;

        $car->save();

        if($request->images)
        {

            $olds = carImages::where('car_id',$car->id)->get();

            if(count($olds) >= 1)
            {
                foreach ($olds as $key => $old) {
                    $old->delete();
                }
            }

            $files = $request->file('images');

            foreach($files as $file)
            {

                $newImage = new carImages();
                $imageName = Str::random(8).'.'.$file->getClientOriginalExtension();



            $file->move(public_path('uploads'), $imageName);

                $newImage->car_id = $car->id;
                $newImage->image = $imageName;
                $newImage->save();
            }
        }

        $holder = new CarHolder();

        $holder->car_id = $car->id;
        $holder->is_user = auth()->user()->id;

        $holder->save();

        $oldPrice = carPrices::where('car_id',$car->id)->first();

        if($oldPrice)
        {
            $oldPrice->delete();
        }
        $country = country::where('id',$request->country_id)->first();
        $price = new carPrices();

        $price->car_id = $car->id;

        $price->currency = $country->en_currency;

        $price->cost = $request->cost;

        $price->discount_amount = $request->discount_amount;

        $price->discount_percent = $request->discount_percent;

        $price->discount_start_date = $request->discount_start_date;

        $price->discount_end_date = $request->discount_end_date;

        $price->save();



        return redirect('/dashboard/cars/index');
    }


      /**
     * Remove the specified resource from storage.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($country)
    {
        if($country != null)
        {
            Cars::where('id',$country)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }

    public function restore($country)
    {
        if($country != null)
        {
            Cars::where('id',$country)->restore();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }


      public function force($country)
    {
        if($country != null)
        {
            Cars::where('id',$country)->forceDelete();
            return back()->with('success','تم الحذف');
        }
        else
        {
            return back();
        }
    }



    public function archive()
    {
        return view('dashboard.cars-sell.archive')->with('cars',Cars::onlyTrashed()->paginate(1000));
    }

    public function carChangeStatus(Request $request)
    {
        //\Log::info($request->all());
        // dd($request->status);
        $cat = Cars::find($request->car_id);
        $cat->status = $request->status;
        $cat->save();
        //   dd($user);

        return response()->json(['success'=>'Status change successfully.']);
    }//end catChangeStatus

    public function renewDateAds(Request  $request){
        $ads = \App\Cars::findOrFail( $request->item_date_id);
        $days = $request->item_days;

        if (Date('Y-m-d') > $ads->end_ad_date)
         $date=Date('Y-m-d');
        else
         $date=$ads->end_ad_date;

        $ads->end_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        $ads->end_ad_date = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
        $ads->save();
        return redirect()->back()->with('success','تم تجديد الاعلان بنجاح');

    }

}//end class
