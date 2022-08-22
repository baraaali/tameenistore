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
 $name = $lang.'_name';
       $name2 ='name_'.$lang;
    ?>
    <style>
        .icon_sty{
            width: 64px !important;
            height: 64px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css"
          integrity="sha512-uMIpMpgk4n6esmgdfJtATLLezuZNRb96YEgJXVeo4diHFOF/gqlgu4Y5fg+56qVYZfZYdiqnAQZlnu4j9501ZQ=="
          crossorigin="anonymous"/>
    @include('dashboard.layout.message')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                <div class="container">
                    <div class="row">
                        @if($service->Images)
                            <div class="swiper-container">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-wrapper">
                                    @foreach($service->Images as $image)
                                        <div class="swiper-slide col-lg-12 ads"
                                             style="width:100%;height: 300px;background-image: url({{url('/')}}/uploads/{{$image->file}});background-size: cover;background-repeat: no-repeat;border-style: solid;border-color:#eee;border-radius: 5px;border-width: 5px;margin-bottom:10px;">

                                        </div>

                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        @else
                         <div class="swiper-slide col-lg-12 ads"
                              style="width:100%;height: 300px;background-image: url({{url('/')}}/uploads/{{$service->image}});background-size: cover;background-repeat: no-repeat;border-style: solid;border-color:#eee;border-radius: 5px;border-width: 5px;margin-bottom:10px;">
                         </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-8">  
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#CCE6F4;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/flag.png" class="icon_sty" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">
                                            {{$service->country->$name}}
                                        </p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#FFDDCC;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/category.png" alt="" class="icon_sty">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$service->cats->$name2}}</p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#FFEBD6;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/sub_cat.png" alt="" class="icon_sty">
                                        @if($service->sub_cat >0)
                                        <p style="font-weight: bold;padding-top: 10px;">{{$service->subCats->$name2}} </p>
                                        @endif
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#FAD5D4;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/004-calendar.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$service->start_date}}</p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#CCEDDC;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/004-calendar.png" alt="">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$service->end_date}}</p>
                                    </div>
                                    <div class="col-lg-2"
                                         style="text-align: center;background-color:#E4DFF8;padding-top: 10px;padding-bottom: 1px;">
                                        <img src="{{url('/')}}/uploads/user_icon.jpeg" alt="" class="icon_sty">
                                        <p style="font-weight: bold;padding-top: 10px;">{{$service->users->name}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 desc">
                                <div>
                                     <span>{{__('site.name')}}:</span><span class="m-5">{{$service->$name2}}</span>
                                    <span class="m-5"> عدد الزيارات : 
                                        <i class="fa fa-eye text-danger"></i> {{$service->visitor}} 
                                     </span>
                               <br><hr></div>
                                @if(app()->getLocale() == 'ar')
                                    <h5 style="font-weight: 600">وصف القسم</h5>
                                    <hr>
                                    <p>{!! $service->ar_description !!}</p>
                                 
                                @else
                                    <h5>Description</h5>
                                    <hr>
                                    <p>{!! $service->en_description !!}</p>
                                

                                @endif
                                
                            
                            <div class="col-lg-12 bid" style="margin-bottom:30px;">
                                <div class="row">  
                                    <div class="col-lg-4" style="background-color: #FFDDCC;padding: 20px;">
                                        <h5>السعر</h5>
                                        <h5 style="color: #FF7229">
                                            {{$service->price}}  {{$service->country->ar_currency}}
                                        </h5>
                                    </div>

                                </div>
                            </div>
                          
                            </div>

            </div>
            <div class="col-lg-12">
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
                            
                            <h5 style="font-weight:600">
                                {{$service->users->name}}
                            </h5>
                        
                            <button class="btn btn-success btn-block"
                                    style="margin-bottom:10px;">
                                <i class="fas fa-phone"></i>  {{$service->users->phones}}
                            </button>
                        </div>
                           <?php  $ads = \App\Notify::where('ads_id', $service->id)->where('type',1)->first(); ?>
                            @if(isset($ads)&&$ads->status !=1)
                                <div class="col-lg-12 bid text-center">
                                    <form action="{{route('user_notify',1)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="ads_id" value="{{$service->id}}">
                                        <i class="fa fa-ban text-danger fa-2x py-2"></i> <input type="submit">
                                    </form>
                                </div>
                            @else
                                <div class="col-lg-12 bid text-center">
                                    <form action="{{route('user_notify',1)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="ads_id" value="{{$service->id}}">
                                        <i class="fa fa-ban text-danger fa-2x py-2"></i> <input type="submit" class="btn btn-primary" value="{{__('site.notify')}}">
                                    </form>
                                </div>
                            @endif
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
