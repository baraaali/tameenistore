
@extends('layouts.app')


@section('content')
<div class="col-md-12 direction my-4">
    <div class="row">
        <div class="col-md-4">
             <img src="{{url('/')}}/uploads/{{$car->main_image}}" class="card-image" alt="{{$car->getName()}}" style="width: 100%">
             <div class="col-lg-12">
                <div class="row bg-white p-2">
                    <div class="col-md-2 p-0 m-0 border-left">
                        <div class="text-center  p-3">
                            <img  class="d-block m-auto" style="width: 40px" src="{{url('/')}}/uploads/001-gas-pump.png" alt="">
                                  <p class="text-center pt-3" >{{$car->fuel}} </p>
                        </div>
                    </div>
                    <div class="col-md-2 p-0 m-0 border-left">
                        <div class="text-center  p-3">
                            <img  class="d-block m-auto" style="width: 40px" src="{{url('/')}}/uploads/002-meter.png" alt="">
                                  <p class="text-center pt-3" >{{$car->kilo_meters}} KM </p>
                        </div>
                    </div>
                    <div class="col-md-2 p-0 m-0 border-left">
                        <div class="text-center  p-3">
                            <img  class="d-block m-auto" style="width: 40px" src="{{url('/')}}/uploads/003-engine.png" alt="">
                                  <p class="text-center pt-3" >{{$car->engine}} CC</p>
                        </div>
                    </div>
                    <div class="col-md-2 p-0 m-0 border-left">
                        <div class="text-center  p-3">
                            <img  class="d-block m-auto" style="width: 40px" src="{{url('/')}}/uploads/004-calendar.png" alt="">
                                  <p class="text-center pt-3" >{{$car->year}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 p-0 m-0 border-left">
                        <div class="text-center  p-3">
                            <img  class="d-block m-auto" style="width: 40px" src="{{url('/')}}/uploads/006-shift.png" alt="">
                                  <p class="text-center pt-3" >{{$car->transmission == 0 ? 'Manual' : 'Automatic'}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 p-0 m-0 border-left">
                        <div class="text-center  p-3">
                            <img  class="d-block m-auto" style="width: 40px" src="{{url('/')}}/uploads/007-car.png" alt="">
                                  <p class="text-center pt-3" >{{$car->model->name}}</p>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="col-md-12 mt-3 bg-white">
                <div class="p-3">
                    <div class="row">
                        <strong class="mb-3">تواصل مع المعلن</strong>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn border my-1 w-100" href="#" role="button"> <i class="fab fa-whatsapp-square text-success mx-1" aria-hidden="true"></i> {{__('site.whatsApp')}}</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn border my-1 w-100" href="#" role="button"> <i class="fa fa-phone text-success mx-1" aria-hidden="true"></i> {{__('site.phone number')}}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="col-lg-12 bg-white p-3 ">
                @if(app()->getLocale() == 'ar')
                    <h5 style="font-weight: 600">وصف السيارة</h5>
                    <hr>
                    <p>{!! $car->ar_description !!}</p>
                    <div class="row">
                        <div class="col-lg-4">
                            <span class="font-weight-bold">النوع </span>
                            @if(isset($car->brand))
                            <p> {{$car->brand->name}}</p><br>
                            @endif
                            <span class="font-weight-bold">{{__('site.status')}}</span>
                            <p> {{$car->used == 1 ? 'مستعمل'  : 'جديد'}}</p><br>
                            <span class="font-weight-bold">السنة</span>
                            <p> {{$car->year}}</p><br>
                            <span class="font-weight-bold">سعة الموتور</span>
                            <p> {{$car->engine}} CC</p><br>
                            <span class="font-weight-bold">الللون</span>
                            <p> {{$car->color}}</p><br>
                        </div>
                        <div class="col-lg-4">
                            <span class="font-weight-bold">التارخ </span>
                            <p> {{Carbon\Carbon::parse($car->created_at)->toFormattedDateString()}}</p><br>
                            <span class="font-weight-bold">النوع</span>
                            <p> {{$car->type_of_car == 0 ? 'بيع ' : 'تأجير'}}</p><br>
                            <span class="font-weight-bold">مجسم العربية </span>
                            @if(isset($car->model))
                            <p> {{$car->model->name}}</p><br>
                            @endif
                            <span class="font-weight-bold">نوع المحرك</span>
                            <p> {{$car->fuel}}</p><br>
            
            
                        </div>
                        <div class="col-lg-4">
                            <span class="font-weight-bold">كم الاميال </span>
                            <p> {{$car->kilo_meters	}}</p><br>
            
                            <span class="font-weight-bold">نوع الفتيس </span>
                            <p> {{$car->transmission == 0 ? 'مانيوال' : 'اوتوماتيك'}} </p><br>
                            <span class="font-weight-bold">عدد المشاهدات</span>
                            <p> {{$car->visitors}} </p><br>
                            @if($car->rent_type!=0)
                                <span class="font-weight-bold"> نوع الايجار :</span>
                                <p> @if($car->rent_type==1) يومى
                                    @elseif($car->rent_type==2)اسبوعى
                                    @elseif($car->rent_type==3)شهرى
                                    @else ايجار بالتملك
                                    @endif
                                </p><br>
                           @endif
                        </div>
                        <div class="col-lg-4">
                            @if($car->Price->discount_percent>0)
                                <span class="font-weight-bold">نسبه الخصم  </span>
                                <p> {{$car->Price->discount_percent}}</p><br>
                            @endif
                            @if($car->Price->discount_amount>0)
                                <span class="font-weight-bold">اقصى قيمه للخصم </span>
                                <p> {{$car->Price->discount_amount}}</p><br>
                            @endif
                        </div>
                    </div>
                @else
                    <h5>Description</h5>
                    <hr>
                    <p>{!! $car->en_description !!}</p>
                    <div class="row">
                        <div class="col-lg-4">
                            <span class="font-weight-bold">Category</span>
                           @if(isset($car->brand))
                            <p> {{$car->brand->name}}</p><br>
                            @endif
                            <br>
                            <span class="font-weight-bold">Price</span>
                            <p>
                                {{$car->Price->cost}} {{$car->Price->currency}}
                            </p><br>
                            <span class="font-weight-bold">Condition</span>
                            <p> {{$car->used == 1 ? 'Used'  : 'New'}}</p><br>
                            <span class="font-weight-bold">Year</span>
                            <p> {{$car->year}}</p><br>
                            <span class="font-weight-bold">Engine Size</span>
                            <p> {{$car->engine}} CC</p><br>
                            <span class="font-weight-bold">Color</span>
                            <p> {{$car->color}}</p><br>
                        </div>
                        <div class="col-lg-4">
                            <span class="font-weight-bold">Data </span>
                            <p> {{Carbon\Carbon::parse($car->created_at)->toFormattedDateString()}}</p><br>
                            <span class="font-weight-bold">Type</span>
                            <p> {{$car->type_of_car == 0 ? 'Sell ' : 'Leasing'}}</p><br>
                            <span class="font-weight-bold">Body Type </span>
                            @if(isset($car->model))
                            <p> {{$car->model->name}}</p><br>
                            @endif
                            <br>
            
            
                        </div>
                        <div class="col-lg-4">
            
                            <span class="font-weight-bold">Transimission </span>
                            <p> {{$car->transmission == 0 ? 'Manual' : 'Automatic'}}</p><br>
                            <span class="font-weight-bold">Visitor Count</span>
                            <p> {{$car->visitors}} </p><br>
                            @if($car->rent_type!=0)
                                <span class="font-weight-bold">Rent Type:</span>
                                <p> @if($car->rent_type==1) Daily
                                    @elseif($car->rent_type==2)Weekly
                                    @elseif($car->rent_type==2)Monthly
                                    @else Rent to own
                                    @endif
                                </p><br>
                           @endif
                        </div>
                        <div class="col-lg-4">
                            @if($car->Price->discount_percent>0)
                                <span class="font-weight-bold">Discount Percent </span>
                                <p> {{$car->Price->discount_percent}}</p><br>
                            @endif
                            @if($car->Price->discount_amount>0)
                                <span class="font-weight-bold">Max Discount Amount </span>
                                <p> {{$car->Price->discount_amount}}</p><br>
                            @endif
                        </div>
                    </div>
            
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-lg-12 bg-white p-3">
                @if(app()->getLocale() == 'ar')
                    <h5>مميزات السيارة</h5>
                    <hr>
            
                    <div class="row">
                        <div class="col-lg-12">
                            {!!$car->ar_features!!}
                        </div>
            
                    </div>
            
                @else
                    <h5>Car Features</h5>
                    <hr>
            
                    <div class="row">
                        <div class="col-lg-12">
                            {!!$car->en_features!!}
                        </div>
            
                    </div>
            
                @endif
            
            </div>
        </div>
    </div>
</div>



@endsection