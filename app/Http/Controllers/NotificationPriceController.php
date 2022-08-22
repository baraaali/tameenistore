<?php

namespace App\Http\Controllers;

use App\NotificationPrice;
use Illuminate\Http\Request;

class NotificationPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices = NotificationPrice::paginate(20);
        return view('dashboard.notificationsprice.index',compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'number'=>'required|numeric',
            'price'=>'required|numeric',
        ]);
        NotificationPrice::create($request->all());

            return redirect()->route('notification-price.index')->with('success',' تم الحفظ بنجاح');
    }

    /**
     * Show the form for update the specified resource.
     *
     * @param  \App\NotificationPrice  $notificationPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name_ar'=>'required|max:255',
            'name_en'=>'required|max:255',
            'number'=>'required|numeric',
            'price'=>'required|numeric',
        ]);

        $price=  NotificationPrice::find($request->id);
        if (!$price){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        $price->update($request->all());

        return redirect()->route('notification-price.index')->with('success','تم الحفظ بنجاح');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NotificationPrice  $notificationPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $price = NotificationPrice::find($id);
        if (! $price) {
            return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
        }
        $price->delete();
        return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
    }
}
