<?php

namespace App\Http\Controllers;

use App\CareShape;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CareShapeController extends Controller
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
  public function index(Request $request)
  {
    if($request->isMethod('post'))
    {
        $search = $request->all()['search'];
        if(empty($search))
        $careshapes=CareShape::paginate('20');
        else
        $careshapes=CareShape::where([['ar_name','like','%'.$search.'%']])->orWhere([['en_name','like','%'.$search.'%']])->paginate('20');
        
        return view('dashboard.careshapes.table',compact('careshapes'));
    }
      $careshapes=CareShape::paginate();
      return view('dashboard.careshapes.index',compact('careshapes'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('dashboard.careshapes.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
       $data = $request->all();
       $validate = Validator::make($data,[
        'ar_name'=>'required|array',
        'en_name'=>'required|array',
    ]);
    
        if($validate->fails())
        return response()->json($validate->errors, 200);
        
       $careshapes = [];
       foreach ($data['ar_name'] as $key => $e) {
         $e = ['ar_name' => $e,'en_name' => $data['en_name'][$key]];
         if(isset($data['status']))
         {
             $e['status'] = $data['status'][$key];
         }
         if(isset($data['image']))
         {
             $image = $data['image'][$key];
             $e['image'] = time().$key.'.'.$image->getClientOriginalExtension();
             $image->move(public_path('uploads'),$e['image']);
         }
         array_push($careshapes,$e);
       }


       $res  = CareShape::insert($careshapes);
       return redirect()->route('careshapes.index')->with('success','تم الحفظ بنجاح');

    }

  public function edit($id)
  {
   return view('dashboard.careshapes.edit');
  }

  public function update(Request $request)
  {
      $request->validate([
          'ar_name'=>'required|max:255',
          'en_name'=>'required|max:255'
        ]);
        $status = isset($request->status) ? $request->status  : '0' ;
        $imagename = null ;
        $careshape=  CareShape::find($request->id);
        if (!$careshape){
            return redirect()->back()->with(['error' => 'حدث خطا ما']);
        }
        if($request->file('image'))
        {
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads'),$imagename);
        }
        $data = ['ar_name'=>$request->ar_name, 'en_name'=>$request->en_name, 'status'=>$status ];

        if($imagename) $data['image'] = $imagename;

        $careshape = $careshape->fill($data);
        $careshape->save();
        $careshape=  CareShape::find($request->id);

      return redirect()->route('careshapes.index')->with('success','تم الحفظ بنجاح');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\careshapes  $careshapes
   * @return \Illuminate\Http\Response
   */
public function delete($id)
  {
      $careshape = CareShape::find($id);
      if (! $careshape) {
          return redirect()->back()->with(['error' => 'بيانات غير موجودة']);
      }
      $careshape->delete();
      return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
  }//end destroy

  public function careshapeChangeStatus(Request $request)
  {
      $cat = CareShape::find($request->careshape_id);
      $cat->status = $request->status;
      $cat->save();
      return response()->json(['success'=>'Status change successfully.']);
  }//end catChangeStatus

}
