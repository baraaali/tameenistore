@extends('layouts.app')

@section('content')

<div class="container direction">
    <div class="p-3">
        <div class="col-md-12">
        
            <div class="row">
                <div class="col-md-4">
                    <div class="bg-white p-3">
                        <h3 class="text-center text-primary mb-3">{{$car->getName()}}</h3>
                        <ul class="list-unstyled p-0 m-0">
                            <li class="border-bottom p-3">
                                <strong>الفئة</strong>
                                <span  class="mx-3"> 
                                    @if ($car->talap == 1 )
                                    <span class="badge badge-success text-white"> مطلوب</span>
                                    @else 
                                    <span class="badge badge-info text-white"> معروض</span>
                                    @endif
                                </span>
                            </li>
                              <li class="border-bottom p-3">
                                <strong>الحالة</strong>
                                <span  class="mx-3"> 
                                    @if ($car->used == "1")
                                    <span class="badge badge-success  text-white p-1">جديد</span>
                                    @else
                                    <span class="badge badge-secondary text-white p-1">مستعمل</span>
                                    @endif
                                </span>
                            </li>
                               <li class="border-bottom p-3">
                                <strong>الماركة</strong>
                                @if ($car->brand)
                                <span  class="mx-3"> {{$car->brand->name}}</span>
                                @endif
                            </li>
                            <li class="border-bottom p-3">
                                <strong>المودل</strong>
                                @if ($car->model)
                                <span  class="mx-3"> {{$car->model->name}}</span>
                                @endif
                            </li>
                             <li class="border-bottom p-3">
                                <strong>اللون</strong>
                                <span  class="mx-3">{{$car->color}} </span>
                            </li>
                             <li class="border-bottom p-3">
                                <strong>تاريخ الإعلان</strong>
                                <span  class="mx-3"> {{Carbon\Carbon::parse($car->created_at)->toFormattedDateString()}} </span>
                            </li>

                            <li class="border-bottom p-3">
                                <strong>الوقود</strong>
                                <span  class="mx-3"> {{$car->fuel}}</span>
                            </li>
                            <li class="border-bottom p-3">
                                <strong>عدد الكيلومترات</strong>
                                <span  class="mx-3"> {{$car->kilo_meters}}</span>
                            </li>
                            <li class="border-bottom p-3">
                                <strong>المحرك</strong>
                                <span  class="mx-3"> {{$car->engine}}</span>
                            </li>
                            <li class="border-bottom p-3">
                                <strong>سنة الصنع</strong>
                                <span  class="mx-3"> {{$car->year}}</span>
                            </li>
                            <li class="border-bottom p-3">
                                <strong>ناقل الحركة</strong>
                                <span  class="mx-3"> {{$car->transmission == 0 ? 'Manual' : 'Automatic'}}</span>
                            </li>
                               <li class="border-bottom p-3">
                                <strong>عدد المشاهدات</strong>
                                <span  class="mx-3"> {{$car->visitors}}</span>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="w-100">
                        <div class="p-3 bg-white">
                        <div class="fotorama" data-nav="thumbs">
                            <img  data-minwidth="1000" data-width="800"  data-height="800" src="{{url('/')}}/uploads/{{$car->main_image}}">
                            @if (isset($car->Images) && !empty($car->Images))
                            @foreach ($car->Images as $e)
                            <img data-minwidth="1000"  data-width="800"  data-height="800" src="{{url('/')}}/uploads/{{$e->image}}">
                            @endforeach
                            @endif
                        </div>
                     
                    </div>
                      
                    </div>
                    <div class="w-100">
                     <div class="p-3 bg-white mt-2">
                         <div class="price">
                             <strong class="h1">
                                  <span class="text-dark"> {{$car->Price->cost}}
                                    @if ($car->country)
                                    {{$car->country->getCurrency()}}
                                    @endif
                                </span>
                                  {{-- {{$car->Price->currency}}  --}}
                             </strong>
                             {{-- <strong class="mx-3">
                                @if($car->Price->discount_percent ==0)
                                <span class="font-weight-bold">قيمة التخفيض </span>
                                12%
                                 {{$car->Price->discount_percent}}
                            @endif
                            @if($car->Price->discount_amount == 0)
                                <span class="font-weight-bold">السعر بعد التخفيض </span>
                                 4000  دينار
                                 {{$car->Price->discount_amount}}
                            @endif
                             </strong> --}}

                         </div>
                     </div>
                     <div class="w-100 bg-white m-0 mt-3 row p-2">
                       
                            <div class="col-md-6 p-0 m-0">
                                <button style="height: 50px;" class="btn btn-primary border my-1 w-100" href="#" >  <strong> <i class="fab  fa-whatsapp-square text-success mx-1" ></i> {{__('site.whatsApp')}}  </strong></button>
                            </div>
                            <div class="col-md-6 p-0 m-0">
                                <button style="height: 50px;" class="btn btn-primary border my-1 w-100" href="#" > <strong> <i class="fa fa-phone text-success mx-1" aria-hidden="true"></i> {{__('site.phone number')}}  </strong></button>
                            </div>
                            <div class="col-md-12 p-0 m-0">
                                <form class="d-block" action="{{route('chat.index',Crypt::encrypt($car->user->id))}}" method="get">
                                    <button style="height: 50px" type="submit" class="btn btn-success w-100">{{__('site.chat')}}</button>
                                </form>
                            </div>
                    </div>
                     <div class="mt-3 bg-white p-3">
                        <h5 class="font-weight-bold">مميزات السيارة</h5> 
                        <p>   {!!$car->getFeatures()!!}</p>
                     </div>
                    </div>
                   
                     <div class="mt-3 bg-white p-3">
                        <h5 class="font-weight-bold">الوصف</h5> 
                        <p>   {!!$car->getDescription()!!}</p>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('front.vehicles-rent.request-modal')

@endsection
