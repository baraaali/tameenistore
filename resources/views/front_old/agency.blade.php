@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/css/custom.css">
<style>
    .nav-link{
        white-space:nowrap !important;
    }
    .navbar-nav li a{
       color: #fff ;
    }
    .mt-40{
        margin-top: 40px;
    }
    .full_img_width {
        width: 100% !important;
        height: 150px !important;
    }

    .PageCard {
        margin-top: 10px;
        background-image: url({{asset('/bg.jpg')}});
    }

    .border_slid {
        border: 1px solid #e0dada;
    }

    .mt-20 {
        margin-top: 20px !important;
    }
</style>
<?php
if ($lang == 'ar' || $lang == 'en') {
    App::setlocale($lang);
} else {
    App::setlocale('ar');
}
$name = $lang . '_name';
$address = $lang . '_address';
$day = date('Y-m-d');
?>
@section('content')
    @include('dashboard.layout.message')
    <div id="HomePage">
        <div class="clr"></div>
        <br>
        <div>
            <section class="section1 clearfix container mb-2 border_slid r PageCard">
                <div>
                    <div class="grid clearfix">
                        <div class="col2 first">
                            <a data-fancybox="agency" href="{{url('/')}}/uploads/{{$agant->image}}">
                                <img src="{{url('/')}}/uploads/{{$agant->image}}" class="img-thumbnail">
                            </a>
                            <h3>{{$agant->$name}}</h3>
                            <p>{{__('site.brief_tall')}} </p>
                        </div>
                        <div class="col2 last">
                            <div class="grid clearfix">
                                <div class="col3 first">
                                    <h1><i class="fa fa-car"></i></h1>
                                    <span> {{__('site.car_count')}} : {{$agant->cars->count()}} </span>
                                </div>
                                <div class="col3"><h1><i class="fas fa-map-marker-alt"></i></h1>
                                    <span>{{$agant->country->$name}} </span></div>
                                <div class="col3 last"><h1><i class="fas fa-mobile-alt"></i></h1>
                                    <span><a href="tel:{{$agant->phones}}" class="btn btn-success btn-sm">
                                         {{$agant->phones}}<i class="fas fa-phone-volume"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="text-center">
            <h5 class="card-title CT1"><i class="fa fa-car"></i> {{__('site.car_available')}} </h5>
        </div>
        <div class="card PageCard container mt-20">
            <div class="card-body row" style="padding:0px;">
                <div class="clr"></div>
                <div class="rgt card-text showRight col-md-8 ">
                    @foreach($cars as $car)
                    <div class="card CarCard col-sm-12">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                @if($car->Price->discount_percent>0 && $car->Price->discount_end_date>$day)
                                    <span class="notify-badge">{{$car->Price->discount_percent}}%</span>
                                @endif
                                <a data-fancybox="" href="{{url('/')}}/uploads/{{$car->main_image}}">
                                    <img src="{{url('/')}}/uploads/{{$car->main_image}}"
                                         class="img-responsive full_img_width" alt="{{$car->$name}}">
                                </a>
                                    @if($car->rent_type >0)
                                        <span class="noty_rent_type">
                                            @if($car->rent_type==1) {{__('site.daily')}}
                                            @elseif($car->rent_type==2){{__('site.weekly')}}
                                            @elseif($car->rent_type==3){{__('site.monthly')}}
                                            @else {{__('site.rent_for_have')}}
                                            @endif
                                        </span>
                                    @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title CC2">
                                        <a href="{{route('view-ad',[$car->id,$lang])}}">{{$car->$name}}</a>
                                    </h5>
                                    <div class="card-text">
{{--                                        <div class="rgt ico-car">--}}
{{--                                            <img--}}
{{--                                                src="https://www.chakirdev.com/demo/Cars/brands/Mercedes-Benz-logo.png">--}}
{{--                                        </div>--}}
                                        <div class="rgt ico-car kmclass text-secondary">{{$car->max}}
                                            <i class="fas fa-tachometer-alt"></i>
                                        </div>
                                        <div class="rgt ico-car mt-1"><i class="fas fa-dumbbell text-warning"></i>
                                            {{$car->transmission==0?__('site.normal'):__("site.automatic")}}</div>
                                        <div class="rgt ico-car "><i class="fas fa-calendar-alt text-primary"></i> {{$car->year}}</div>
                                        <div class="rgt ico-car "><i class="fas fa-eye text-danger"></i> {{$car->visitors}}</div>
                                    </div>
                                    <div class="clr"></div>
                                    <small class="text-muted">{{Carbon\Carbon::parse($car->end_ad_date)->toFormattedDateString()}}</small>
                                    <div class="card-text">
                                        <span class="rgt Prix">{{$car->Price->cost}} {{$car->country->ar_currency}} </span>
                                        <span class="lft">
                                           @if($car->rent_type==0)
                                            <button id="phone22" type="button" class="btn btn-success btn-sm Phone" data-text-swap="0600000000"
                                             data-text-original="06xx xxxxxx">{{$car->phones !=null?$car->phones:'06xx xxxxxx'}}</button>
                                             @else
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#exampleModal">
                                                    {{__('site.booking')}}
                                                </button>
                                            @endif
                                        </span>
                                        <script type="text/javascript">
                                            $("#phone22").on("click", function () {
                                                var el = $(this);
                                                el.text() == el.data("text-swap") ? el.text(el.data("text-original")) : el.text(el.data("text-swap"));
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="lft card-text showLeft col-md-4 mt-40 border_slid">
                    <div>
                        <div class="card-body">
                            <h5 class="card-title CC3"><i class="fas fa-warehouse"></i> {{__('site.about_agency')}} </h5>
                            <div class="clr"></div>
                            <div class="card-text ico-SRinfo">
                                <div class="SRINFO"><i class="fas fa-car-side"></i> {{__('site.car_status')}} :
                                    <span class="btn btn-danger btn-sm">
                                        {{$agant->car_type==0?__('site.used'):__('site.new')}}</span>
                                </div>
                                <div class="SRINFO"><i class="fas fa-map"></i>
                                    {{$agant->$address}}
                                </div>
                                <div class="SRINFO"><a href="#" class="btn btn-info btn-sm"> {{$agant->phones}} <i
                                            class="fas fa-phone-volume" style="color:white;"></i></a></div>

                            </div>
                            <div class="clr"></div>
                            <br><br>
                            <h5 class="card-title CC3"><i class="fas fa-hashtag"></i>{{__('site.social_links')}}</h5>
                            <div class="clr"></div>
                            <div>
                                <div class="SRINFO">
                                        {{$agant->website}}</a></div>
                                <div class="SRINFO"><a href="{{$agant->fb_page}}"
                                                       class="btn btn-light btn-sm" target="_blank"><i
                                            class="fab fa-facebook" style="color:#0b70ea;"></i> {{__('site.page_link')}} </a></div>
                                <div class="SRINFO"><a href="{{$agant->twitter_page}}"
                                                       class="btn btn-light btn-sm" target="_blank"><i
                                            class="fab fa-twitter" style="color:#4fdbf7;"></i>  {{__('site.page_link')}} </a></div>
                                <div class="SRINFO"><a href="{{$agant->instagram}}"
                                                       class="btn btn-light btn-sm" target="_blank"><i
                                            class="fab fa-instagram" style="color:#E73E53;"></i>  {{__('site.page_link')}} </a></div>
                            </div>
                            <div class="clr"></div>
                            <br><br>
                            <h5 class="card-title CC3"><i class="fas fa-hashtag"></i> {{__('site.on_map')}}</h5>
                            <div class="clr"></div>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14948548.954898184!2d36.05427085182272!3d23.834663897796574!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi%20Arabia!5e0!3m2!1sen!2sma!4v1578447115480!5m2!1sen!2sma"
                                width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="clr"></div>
        <br>
    </div>

    <!-- Modal -->
@include('layouts.model')



@endsection
@section('js')

@endsection
