@extends('layouts.app')
@section('content')
    <?php
    use Carbon\Carbon;
    Carbon::setLocale(LC_TIME, $lang);;
    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css"
          integrity="sha512-uMIpMpgk4n6esmgdfJtATLLezuZNRb96YEgJXVeo4diHFOF/gqlgu4Y5fg+56qVYZfZYdiqnAQZlnu4j9501ZQ=="
          crossorigin="anonymous"/>
    @include('dashboard.layout.message')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="container">
                    <div class="row">
                        @if($car->Images)
                            <div class="swiper-container">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-wrapper">
                                    @foreach($car->Images as $image)
                                        <div class="swiper-slide col-lg-12 ads"
                                             style="width:100%;height: 300px;background-image: url({{url('/')}}/uploads/{{$image->image}});background-size: cover;background-repeat: no-repeat;border-style: solid;border-color:#eee;border-radius: 5px;border-width: 5px;margin-bottom:10px;">

                                        </div>

                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        @else

                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#CCE6F4;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/001-gas-pump.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">
                                            {{$car->fuel}}
                                        </p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#FFDDCC;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/002-meter.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$car->kilo_meters}} KM</p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#FFEBD6;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/003-engine.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$car->engine}} CC</p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#FAD5D4;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/004-calendar.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$car->year}}</p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#CCEDDC;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/006-shift.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$car->transmission == 0 ? 'Manual' : 'Automatic'}}</p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#E4DFF8;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/007-car.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">@if(isset($car->model))
                                            <p> : {{$car->model->name}}</p><br>
                                            @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 desc">
                                @if(app()->getLocale() == 'ar')
                                    <h5 style="font-weight: 600">وصف السيارة</h5>
                                    <hr>
                                    <p>{!! $car->ar_description !!}</p>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <span>النوع </span>
                                            @if(isset($car->brand))
                                            <p> : {{$car->brand->name}}</p><br>
                                            @endif
                                            <span>{{__('site.status')}}</span>
                                            <p> : {{$car->used == 1 ? 'مستعمل'  : 'جديد'}}</p><br>
                                            <span>السنة</span>
                                            <p> : {{$car->year}}</p><br>
                                            <span>سعة الموتور</span>
                                            <p> : {{$car->engine}} CC</p><br>
                                            <span>الللون</span>
                                            <p> : {{$car->color}}</p><br>
                                        </div>
                                        <div class="col-lg-4">
                                            <span>التارخ </span>
                                            <p> {{Carbon::parse($car->created_at)->toFormattedDateString()}}</p><br>
                                            <span>النوع</span>
                                            <p> : {{$car->type_of_car == 0 ? 'بيع ' : 'تأجير'}}</p><br>
                                            <span>مجسم العربية </span>
                                            @if(isset($car->model))
                                            <p> : {{$car->model->name}}</p><br>
                                            @endif
                                            <span>نوع المحرك</span>
                                            <p> : {{$car->fuel}}</p><br>


                                        </div>
                                        <div class="col-lg-4">
                                            <span>كم الاميال </span>
                                            <p> : {{$car->kilo_meters	}}</p><br>

                                            <span>نوع الفتيس </span>
                                            <p> : {{$car->transmission == 0 ? 'مانيوال' : 'اوتوماتيك'}} </p><br>
                                            <span>عدد المشاهدات</span>
                                            <p> : {{$car->visitors}} </p><br>
                                            @if($car->rent_type!=0)
                                                <span> نوع الايجار :</span>
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
                                                <span>نسبه الخصم  </span>
                                                <p> : {{$car->Price->discount_percent}}</p><br>
                                            @endif
                                            @if($car->Price->discount_amount>0)
                                                <span>اقصى قيمه للخصم </span>
                                                <p> : {{$car->Price->discount_amount}}</p><br>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <h5>Description</h5>
                                    <hr>
                                    <p>{!! $car->en_description !!}</p>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <span>Category</span>
                                           @if(isset($car->brand))
                                            <p> : {{$car->brand->name}}</p><br>
                                            @endif
                                            <br>
                                            <span>Price</span>
                                            <p> :
                                                {{$car->Price->cost}} {{$car->Price->currency}}
                                            </p><br>
                                            <span>Condition</span>
                                            <p> : {{$car->used == 1 ? 'Used'  : 'New'}}</p><br>
                                            <span>Year</span>
                                            <p> : {{$car->year}}</p><br>
                                            <span>Engine Size</span>
                                            <p> : {{$car->engine}} CC</p><br>
                                            <span>Color</span>
                                            <p> : {{$car->color}}</p><br>
                                        </div>
                                        <div class="col-lg-4">
                                            <span>Data </span>
                                            <p> : {{Carbon::parse($car->created_at)->toFormattedDateString()}}</p><br>
                                            <span>Type</span>
                                            <p> : {{$car->type_of_car == 0 ? 'Sell ' : 'Leasing'}}</p><br>
                                            <span>Body Type </span>
                                            @if(isset($car->model))
                                            <p> : {{$car->model->name}}</p><br>
                                            @endif
                                            <br>


                                        </div>
                                        <div class="col-lg-4">

                                            <span>Transimission </span>
                                            <p> : {{$car->transmission == 0 ? 'Manual' : 'Automatic'}}</p><br>
                                            <span>Visitor Count</span>
                                            <p> : {{$car->visitors}} </p><br>
                                            @if($car->rent_type!=0)
                                                <span>Rent Type:</span>
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
                                                <span>Discount Percent </span>
                                                <p> : {{$car->Price->discount_percent}}</p><br>
                                            @endif
                                            @if($car->Price->discount_amount>0)
                                                <span>Max Discount Amount </span>
                                                <p> : {{$car->Price->discount_amount}}</p><br>
                                            @endif
                                        </div>
                                    </div>

                                @endif
                            </div>
                            <div class="col-lg-12 desc">
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
                            <div class="col-lg-12 bid" style="margin-bottom:30px;">
                                <div class="row">
                                    @if(app()->getLocale() == 'ar')
                                        <div class="col-lg-4" style="background-color: #FFDDCC;padding: 20px;">
                                            <h5>السعر</h5>
                                            <h5 style="color: #FF7229">
                                                {{$car->Price->cost}}  {{$car->Price->currency}}
                                            </h5>
                                        </div>

                                        <div class="col-lg-4" style="background-color: #CCE6F4;padding: 20px;">
                                            <h5>عرض خاص</h5>
                                            <h5 style="color: #2997D2">
                                                @if($car->Price->discount_start_date)

                                                    <?php

                                                    $today = Carbon::now();
                                                    $start = Carbon::parse($car->Price->discount_start_date);
                                                    $end = Carbon::parse($car->Price->discount_end_date);
                                                    ?>
                                                    @if($today >= $start && $today < $end)

                                                        @if($car->Price->discount_amount)
                                                            {{(float) $car->Price->cost - (float) $car->Price->discount_amount}} {{$car->Price->currency}}
                                                        @elseif($car->Price->discount_percent)

                                                        @endif

                                                    @elseif ($today < $start)

                                                        قريبا
                                                    @else
                                                        0
                                                    @endif






                                                @else

                                                    N/A

                                                @endif
                                            </h5>
                                        </div>
                                        <div class="col-lg-4" style="background-color: #FFEBD6;padding: 20px;">
                                            <h5>ينتهي في</h5>
                                            <h5 style="color: #FF7229">
                                                @if($car->Price->discount_start_date)

                                                    <?php

                                                    $today = Carbon::now();
                                                    $start = Carbon::parse($car->Price->discount_start_date);
                                                    $end = Carbon::parse($car->Price->discount_end_date);
                                                    ?>
                                                    @if($today >= $start && $today < $end)

                                                        {{Carbon::parse($car->Price->discount_end_date)->toFormattedDateString()}}


                                                    @else
                                                        N/A
                                                    @endif






                                                @else

                                                    N/A

                                                @endif
                                            </h5>
                                        </div>
                                    @else

                                        <div class="col-lg-4" style="background-color: #FFDDCC;padding: 20px;">
                                            <h5>Price</h5>
                                            <h5 style="color: #FF7229">
                                                {{$car->Price->cost}}  {{$car->Price->currency}}
                                            </h5>
                                        </div>
                                        <div class="col-lg-4" style="background-color: #CCE6F4;padding: 20px;">
                                            <h5>Special Offer</h5>
                                            <h5 style="color: #2997D2">
                                                @if($car->Price->discount_start_date)

                                                    <?php

                                                    $today = Carbon::now();
                                                    $start = Carbon::parse($car->Price->discount_start_date);
                                                    $end = Carbon::parse($car->Price->discount_end_date);
                                                    ?>
                                                    @if($today >= $start && $today < $end)

                                                        @if($car->Price->discount_amount)
                                                            {{(float) $car->Price->cost - (float) $car->Price->discount_amount}} {{$car->Price->currency}}
                                                        @elseif($car->Price->discount_percent)

                                                        @endif

                                                    @elseif ($today < $start)

                                                        قريبا
                                                    @else
                                                        0
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="col-lg-4" style="background-color: #FFEBD6;padding: 20px;">
                                            <h5>End in</h5>
                                            <h5 style="color: #FF7229">
                                                @if($car->Price->discount_start_date)

                                                    <?php

                                                    $today = Carbon::now();
                                                    $start = Carbon::parse($car->Price->discount_start_date);
                                                    $end = Carbon::parse($car->Price->discount_end_date);
                                                    ?>
                                                    @if($today >= $start && $today < $end)

                                                        {{Carbon::parse($car->Price->discount_end_date)->toFormattedDateString()}}


                                                    @else
                                                        N/A
                                                    @endif






                                                @else

                                                    N/A

                                                @endif
                                            </h5>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <?php  $ads = \App\Notify::where('ads_id', $car->id)->first(); ?>
                            @if(isset($ads)&&$ads->status !=1)
                                <div class="col-lg-12 bid text-center">
                                    <form action="{{route('user_notify')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="ads_id" value="{{$car->id}}">
                                        <i class="fa fa-ban text-danger fa-2x py-2"></i> <input type="submit">
                                    </form>
                                </div>
                            @else
                                <div class="col-lg-12 bid text-center">
                                    <form action="{{route('user_notify')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="ads_id" value="{{$car->id}}">
                                        <i class="fa fa-ban text-danger fa-2x py-2"></i> <input type="submit" class="btn btn-primary" value="{{__('site.notify')}}">
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <div class="col-lg-12 card" style="padding: 0px;">
                                <div class="col-lg-12 card-head" style="border-bottom: 1px solid #d3d3d3;">
                                    <h5 style="text-align: center;padding: 10px;">
                                        @if(app()->getLocale() == 'ar')
                                            بيانات المعلن
                                        @else
                                            Publisher Information
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-lg-12 card-body" style="padding:10px;overflow: hidden;">

                                    <div class="container">
                                        @if($car->OwnerInformation->is_exhibitor != 0)
                                            @if(app()->getLocale() == 'ar')
                                                <h5 style="font-weight:600">
                                                    {{$car->OwnerInformation->exhibitor->ar_name}}
                                                </h5>
                                            @else
                                                <h5 style="font-weight:600">
                                                    {{$car->OwnerInformation->exhibitor->en_name}}
                                                </h5>
                                            @endif
                                            @if($car->OwnerInformation->exhibitor->phones)

                                                @foreach($car->OwnerInformation->exhibitor->phones as $phone)
                                                    <button class="btn btn-success btn-block"
                                                            style="margin-bottom:10px;">
                                                        <i class="fas fa-phone"></i> {{$phone->phone}}
                                                    </button>
                                                @endforeach

                                            @endif
                                        @elseif ($car->OwnerInformation->is_agent != 0)
                                            @if(app()->getLocale() == 'ar')
                                                <h5 style="font-weight:600">
                                                    {{$car->OwnerInformation->agent->ar_name}}
                                                </h5>
                                            @else
                                                <h5 style="font-weight:600">
                                                    {{$car->OwnerInformation->agent->en_name}}
                                                </h5>
                                            @endif
                                            @if($car->OwnerInformation->agent->phones)
                                                @php
                                                    $phones = explode('-',$car->OwnerInformation->agent->phones);
                                                @endphp
                                                @foreach($phones as $phone)
                                                    <button class="btn btn-success btn-block"
                                                            style="margin-bottom:10px;">
                                                        <i class="fas fa-phone"></i> {{$phone}}
                                                    </button>
                                                @endforeach

                                            @endif
                                        @else
                                            {{$car->OwnerInformation->User->name}}
                                            <button class="btn btn-success btn-block" style="margin-bottom:10px;">
                                                <i class="fas fa-phone"></i> {{$car->OwnerInformation->User->phones}}
                                            </button>
                                            <hr>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12 card" style="padding: 0px;">
                                <div class="col-lg-12 card-head" style="border-bottom: 1px solid #d3d3d3;">
                                    <h5 style="text-align: center;padding: 10px;">
                                        @if(app()->getLocale() == 'ar')
                                            الموقع علي الخريطة
                                        @else
                                            Location on Map
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-lg-12 card-body" style="padding:0px;overflow: hidden;height:300px;">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d13813.549126081274!2d31.274070149999996!3d30.0544315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sar!2seg!4v1586815987643!5m2!1sar!2seg"
                                        frameborder="0" style="border:0;width: 100%;height: 100%;" allowfullscreen=""
                                        aria-hidden="false" tabindex="0"></iframe>
                                </div>
                            </div>
                            <div class="col-lg-12 card">
                                <div class="col-lg-12 card-head" style="border-bottom: 1px solid #d3d3d3;">
                                    <h5 style="text-align: center;padding: 10px;">
                                        @if(app()->getLocale() == 'ar')
                                            نصائح السلامة للصفقة
                                        @else
                                            Safety tips for deal
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-lg-12 card-body safety"
                                     style="padding:20px;overflow: hidden;height:auto;">
                                    <ol>
                                        @if(app()->getLocale() == 'ar')
                                            <li>استخدم موقع آمن لمقابلة البائع</li>
                                            <li>تجنب المعاملات النقدية</li>
                                            <li>احذر من العروض غير الواقعية</li>
                                        @else
                                            <li>Use a safe location to meet seller</li>
                                            <li>Avoid cash transactions</li>
                                            <li>Beware of unrealistic offers</li>
                                        @endif
                                    </ol>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"
            integrity="sha512-VHsNaV1C4XbgKSc2O0rZDmkUOhMKPg/rIi8abX9qTaVDzVJnrDGHFnLnCnuPmZ3cNi1nQJm+fzJtBbZU9yRCww=="
            crossorigin="anonymous"></script>

    <script>
        var mySwiper = new Swiper('.swiper-container', {
            // Optional parameters
            slidesPerView: 1,
            spaceBetween: 0,
            autoplay: {delay: 3000,},

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        })
    </script>
    </script>

@endsection
