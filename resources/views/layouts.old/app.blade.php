<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ app()->getLocale() }}">
    <meta name="google-site-verification" content="o5APHzcTWBUH3fYRGlT3Gy-RJ48wTzWG74fdBetdVzU" />
    <?php $website = \App\Website::where('id',1)->first();
    $website->description= strip_tags(preg_replace('/\s+/', ' ', $website->description));
    ?>
	@if($website)
{{--	@foreach($websites as $website)--}}
    <meta name="description" content="{{$website->description}}">
	<meta name="keywords" content="{{$website->keywords}}">
	<meta name="author" content="{{$website->auth_meta_tags}}">
{{--	@endforeach--}}
	@endif

    <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">

    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
    <title>تاميني ستور</title>
    <link rel="sitemap" href="{{url('/')}}/sitemap.xml" type="application/xml" />
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <!-- Fonts -->
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fancybox/dist/jquery.fancybox.min.css') }}">
    <script src="{{ asset('assets/fancybox/dist/jquery.fancybox.min.js') }}"></script>

     <script data-ad-client="ca-pub-4716419363021657" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>


    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/ar.css">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    @else
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/slider.css">
    @endif
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body{
            font-family: 'Cairo', sans-serif !important;
        }
        .badge-custom{
            height: 40px !important;
            width: 75px !important;
            line-height: 30px !important;
        }
        .nav-link{
            white-space:nowrap !important;
        }
        .navbar-nav li a{
            color: #000 ;
        }
        .badge-warning {
            background-color: #ffc107 !important;
        }
.href-c{
    color: black !important;
}
        .com_logo {
            position:relative;
            padding-top:20px;
            display:inline-block;
        }
        .com_logo img{
            height: 250px;
            width: 100%;
        }
        .notify-badge{
            position: absolute;
            /*right:-20px;*/
            top:16px;
            background:red;
            text-align: center;
            border-radius: 30px 30px 30px 30px;
            color:white;
            padding:5px 10px;
            font-size:20px;
        }
        .preloader {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 9999999999;
    background: #002e5b;
    top: 0;
    left: 0;
}

.loader {
    position: absolute;
    top: 43%;
    left: 0;
    right: 0;
    transform: translateY(-43%);
    text-align: center;
    margin: 0 auto;
    width: 50px;
    height: 50px;
}
.search_result_box{
    padding: 25px !important; margin-top:25px;background-color: #F3F3F3;
    border-radius: 19px;
    border: 2px solid;
}
.box {
    width: 100%;
    height: 100%;
    background: #fff;
    animation: animate .5s linear infinite;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 3px;
}
.shadow {
    width: 100%;
    height: 5px;
    background: #000;
    opacity: 0.1;
    position: absolute;
    top: 59px;
    left: 0;
    border-radius: 50%;
    animation: shadow .5s linear infinite;
    }


@keyframes loader {
    0% {
        left: -100px
    }
    100% {
        left: 110%;
    }
}

@keyframes animate {
    17% {
        border-bottom-right-radius: 3px;
    }
    25% {
        transform: translateY(9px) rotate(22.5deg);
    }
    50% {
        transform: translateY(18px) scale(1,.9) rotate(45deg);
        border-bottom-right-radius: 40px;
    }
    75% {
        transform: translateY(9px) rotate(67.5deg);
    }
    100% {
        transform: translateY(0) rotate(90deg);
    }
}

@keyframes shadow {
    50% {
        transform: scale(1.2,1);
    }
}
.nav-link {
    font-size: 13px;
    font-weight: bold;
}
.navbar{
    margin-bottom: 0px !important;
}
.noty_rent_type{
    position: absolute;
    background: #2f56d2;
    text-align: center;
    border-radius: 10px;
    color: white;
    margin-right: -50px;
    padding: 3px;
    margin-top: 19px;

}
    </style>
@if(app()->getLocale()=='en')
<style>
    .noty_rent_type{
        margin-left: -85px !important;
        margin-right: 0px !important;
    }
</style>
    @endif
<style>
    .notif-box
    {
    right: -60px;
    width: 300px;
    left: 0;
    margin: auto;
    }
    .notif-box li{
        color: #000;
    }
    .notif-box li:hover{
        color: #000;
        text-decoration: underline;
    }
    .whats{
        position: fixed;
        left: 0px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-right: 15px;
        border: solid;
        border-color: transparent;
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
        color: white;
        z-index: 999;
    }
    .badge-golden{
        background-color:#FFD700 !important;
    }
    .badge-silver{
        background-color:#C0C0C0 !important;
    }
    .badge-spacial{
        background-color:#a91acc !important;
    }
    .badge-normal{
        background-color:#0366d6 !important;
    }
    .mtop-20{
        margin-top: 20px !important;
    }
</style>
    @yield('css')
</head>
<body>



    <div class="preloader">
        <div class="loader">
        <div class="shadow"></div>
        <div class="box"></div>
        </div>
    </div>
    <div id="app">
        <div class="right-add-ad" style="display:none;">
            <a href="{{url('/')}}/cp/ads/{{app()->getLocale()}}">

                @if(app()->getLocale() == 'ar')
                 <i class="fa fa-plus"></i>
                     إعلان جديد
                @else
                <i class="fa fa-plus"></i>
                    Add Ad

                @endif
            </p>
        </div>
        <div class="left-bottom">
            <i class="fa fa-angle-up"></i>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm bckgroundColor first-nave" >
            <div class="container">
              @if (!is_null(Auth::user()))
                   <ul class="navbar-nav">
                    <li class="position-relative">
                        <a id="navbarDropdown" class="nav-link-2 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if(app()->getLocale() == 'ar')
                            <span class="badge badge-warning rounded">{{ $notifications_count}}</span> 
                                <i class="fa fa-bell">
                                </i>
                                الإشعارات
                            @else
                            <i class="fa fa-bell"> 
                            </i>
                            <span style="font-weight: 600">Notifications</span>
                            <span class="badge badge-warning">{{ $notifications_count}}</span> 

                            @endif
                            <div class="dropdown-menu notif-box" aria-labelledby="navbarDropdown">
                                <ul dir="rtl" class="list-group p-0">
                                    @if (isset($notifications))
                                       @for ($i = 0; $i < $notifications->count(); $i++)
                                         @if ($i < 3)
                                         <li
                                         @if ($notifications[$i]->viewed  == 0)
                                        style="background-color: #f7f7f7"  
                                        @endif
                                        class="list-group-item  
                                         @if(app()->getLocale() == 'ar')
                                             text-right
                                         @endif
                                         ">
                                         <a href="{{route('notifications-view',app()->getLocale().'/'.$notifications[$i]->id )}}">                                 
                                              {{__($notifications[$i]->subject)}}
                                         </a>
                                        </li>
                                         @endif
                                           
                                       @endfor
                                    @endif
                                </ul>
                                @if (isset($notifications) && $notifications->count() > 3)
                                <a href="{{route('notifications-view',app()->getLocale())}}" class="my-1 d-block text-center">كل الإشعارات</a>
                                @endif
                            </div>
                        </a>
                       </li>
                </ul>
              @endif
                <ul class="navbar-nav" style="flex-direction: row !important; z-index: 999">
                    @if(getCountry()>0)
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('forget-country')}}" style="margin-top: -6px;">

                                <span style="font-weight: 600;"> {{__('site.default')}}</span>
                            </a>
                        </li>
                    @endif
                         <li class="nav-item dropdown">
                             <?php



                                        $url = url()->current();
                                        $cutts = explode('/', $url);
                                        $new_url = 'l';

                                        if(in_array('en', $cutts))
                                        {
                                            $new_url = str_replace('/en', '/ar', $url);
                                        }
                                        else if (in_array('ar',$cutts)){
                                            $new_url = str_replace('/ar', '/en', $url);
                                        }

                                    ?>
                                <a id="navbarDropdown" class="nav-link-2 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(app()->getLocale() == 'ar')
                                        <i class="fa fa-globe"></i>
                                    اللغة
                                    @else
                                    <i class="fa fa-globe"></i>
                                    <span style="font-weight: 600">Language</span>
                                    @endif
                                </a>
                               

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">


                                    <a href="{{ strlen($new_url) > 1 ? $new_url : $url . '\en' }}" class="dropdown-item">
                                        {{ __('English') }}
                                    </a>

                                     <a href="{{strlen($new_url) > 1 ? $new_url : $url . '\ar' }}" class="dropdown-item">
                                        {{ __('العربية') }}
                                    </a>



                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link-2 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                       <i class="fa fa-map-marker-alt"></i>{{__('site.country')}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" style="height: 300px;overflow-y: scroll;text-align: start;width: 300px;overflow-x: hidden;" aria-labelledby="navbarDropdown">
                                   <?php $countries = \App\country::where('status',1)->get(); ?>

                                   @foreach($countries as $key=>$country)

                                    <a  class="dropdown-item" href="{{url('/')}}/country/{{$country->en_name}}">
                                            {{-- <img src="{{$country->image}}" style="width:25px;height:20px;" /> --}}
                                           @if(app()->getLocale() == 'ar')
                                            {{$country->ar_name}}
                                            @else
                                            {{$country->en_name}}
                                            @endif

                                    </a>
                                    @endforeach
                                </div>
                            </li>


                             @guest

                             @else
                                <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link-2 dropdown-toggle" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    @if(app()->getLocale() == 'ar')

                                       <i class="fa fa-sign-out-alt"></i>
                                    تسجيل  الخروج

                                    @else
                                     <i class="fa fa-sign-out-alt"></i>
                                    <span style="font-weight: 600">Sign out</span>




                                    @endif

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </a>


                            </li>


                                 <li class="nav-item">
                                <a style="color:white" class="nav-link-2">
                                    @if(app()->getLocale() == 'ar')
                                         مرحبا {{auth()->user()->name}}
                                    @else
                                         Welcome {{auth()->user()->name}}
                                    @endif
                                </a>


                            </li>
                             @endguest
                    </ul>
            </div>
        </nav>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="padding: 0px !important;" >
                   <img src="{{url('/')}}/uploads/footer_logo.png" style="width: auth;
                   height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle href-c" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(app()->getLocale() == 'ar')
                                    {{ __('تأمين السيارات') }}
                                @else
                                    Insurance
                                @endif
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('CompShow',app()->getLocale())}}">
                                    @if(app()->getLocale() == 'ar')
                                        {{ __('تأمين شامل ') }}
                                    @else
                                        Comprehensive
                                    @endif
                                </a>
                                <a class="dropdown-item" href="{{route('dcShow',app()->getLocale())}}">
                                    @if(app()->getLocale() == 'ar')
                                        {{ __('تأمين ضد الغير') }}
                                    @else
                                        Tpl Insurance
                                    @endif
                                </a>
                            </div>
                        </li>

                             <li class="nav-item">
                                <a class="nav-link" href="{{route('mcenters',app()->getLocale())}}">
                                @if(app()->getLocale() == 'ar')
                               مراكز الصيانة
                                @else
                                Maintenance Centers
                                @endif
                                </a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('sales',app()->getLocale())}}">
                                @if(app()->getLocale() == 'ar')
                                {{ __('سيارات للبيع') }}
                                @else
                                 Cars For Sales
                                @endif
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="{{route('rent',app()->getLocale())}}">
                                @if(app()->getLocale() == 'ar')
                                {{ __('وكالات الايجار') }}
                                @else
                                        Rental agencies
                                @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('selling-agent',app()->getLocale())}}">
                               @if(app()->getLocale() == 'ar')
                                {{ __('وكالات بيع السيارات') }}
                                @else
                                Selling Agents
                                @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('leasing-agent',app()->getLocale())}}">
                               @if(app()->getLocale() == 'ar')
                                {{ __('سيارات الايجار') }}
                                @else
                                        Rental cars

                                @endif
                                </a>
                            </li>

                            <!-- <li class="nav-item">-->
                            <!--    <a class="nav-link" href="{{route('maintaince-centers',app()->getLocale())}}"> -->
                            <!--   @if(app()->getLocale() == 'ar')-->
                            <!--    {{ __('مراكز الصيانة') }}-->
                            <!--    @else-->
                            <!--    Maintenance centers-->
                            <!--    @endif-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('ads',app()->getLocale())}}" >
                               @if(app()->getLocale() == 'ar')
                                {{ __('الإعلانات') }}
                                @else
                                Car Ads
                                @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('new_services',app()->getLocale())}}" >
                               {{__('site.new_module')}}
                                </a>
                            </li>
                        <li class="nav-item">

{{--                            <a class="nav-link" href="{{route('view-exhibitors',app()->getLocale())}}">--}}
                            <a class="nav-link" href="{{route('allDepartments',app()->getLocale())}}">
                                @if(app()->getLocale() == 'ar')
                                    {{ __(' كل الاقسام') }}
                                @else
                                    All Departments
                                @endif
                            </a>
                        </li>
{{--                    @auth--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{url('/')}}/memberships/join/{{app()->getLocale()}}">--}}
{{--                               @if(app()->getLocale() == 'ar')--}}
{{--                                {{ __('العضويات') }}--}}
{{--                                @else--}}
{{--                                Memberships--}}
{{--                               @endif--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endauth--}}
                                <li class="nav-item dropdown">





                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(app()->getLocale() == 'ar')



                                    الاقسام
                                    @else

                                    <span style="font-weight: 600">
                                        Departments
                                    </span>




                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <?php
                                        $deps = \App\Categories::where('status',1)->get();
                                        $name = app()->getLocale().'_name';

                                    ?>

                                    @foreach($deps as $dep)
                                    <?php  $url = str_replace(' ','_',$dep->en_name); ?>
                                    <a href="{{url('/')}}/show/{{$dep->id}}/{{app()->getLocale()}}" class="dropdown-item href-c">
                                        {{ $dep->$name }}
                                    </a>
                                    @endforeach

                                </div>
                            </li>
                               <li class="nav-item">
                                <a class="nav-link" href="{{route('about-us',app()->getLocale())}}">
                               @if(app()->getLocale() == 'ar')
                                {{ __('من نحن') }}
                                @else
                                About Us
                               @endif
                                </a>
                            </li>
                             @guest

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-login')}}">
                               @if(app()->getLocale() == 'ar')
                                {{ __('تسجيل دخول') }}
                                @else
                                Login
                                @endif
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user-register')}}">
                               @if(app()->getLocale() == 'ar')
                                {{ __('تسجيل جديد') }}
                                @else
                                Register
                                @endif
                                </a>
                            </li>

                        @else
                          @if(Auth::user()->guard == 0)

                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}/cp/index/{{app()->getLocale()}}">
                               @if(app()->getLocale() == 'ar')
                                {{ __('لوحة التحكم') }}
                                @else
                                My Control Panel
                                @endif
                                </a>
                            </li>
                        @else 
                        @if(Auth::user()->guard == 1)
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('dashboard')}}">
                           @if(app()->getLocale() == 'ar')
                            {{ __('لوحة التحكم') }}
                            @else
                            My Control Panel
                            @endif
                            </a>
                        </li>
                        @endif
                        @endif



                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>



        <footer>


            <div class="container">
                <div class="row">
                    <div class="wow animate__fadeIn col-md-4" data-wow-duration="4s">
                        <img src="{{url('/')}}/uploads/footer_logo.png" style="height: 100px">
                        <br />
                        <p class="third-detail" style="margin-top: 20px;">
                            @if(app()->getLocale() == 'ar')
                                بيع سيارات جديدة
                                <br>
بيع سيارات مستعملة <br>
ايجار سيارات جديدة <br>
ايجار سيارات مستعملة <br>
عضويات ذهبيه <br>
عضويات فضيه <br>
عضويات مميزة <br>
عضويات عادية <br>
بيع وشراء السيارات الجديدة والمستعملة <br>
خدمات السيارات  <br>
ارقام مميزة <br>
                             @else
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.


                       @endif

                         </p>
                    </div>

                    <div class="wow animate__fadeIn col-md-4" data-wow-duration="4s" >
                        <p class="card-title" style="margin:0px">
                            @if(app()->getLocale() == 'ar' )
                                تواصل معنا
                            @else
                                Contact Us
                            @endif
                        </p>
                        <hr>

                    </div>

                    <div class="wow animate__fadeIn col-md-4" data-wow-duration="4s">
                        <p class="card-title" style="margin:0px">
                           @if(app()->getLocale() == 'ar')
                            <div id="WAButton"></div>     أخر الاخبار
                           @else
                            Latest News
                           @endif
                        </p>
                        <hr>
                        <input type="email" name="email" class="SpecificInput" placeholder="email - البريد الالكتروني">
                        <br>
                        <button class="btn btn-dark" style="float:left">
                                @if(app()->getLocale() == 'ar')
                                     تسجيل
                                @else

                                    Save

                                @endif
                        </button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="card-title">
                    @if(app()->getLocale() == 'ar')

                         جميع الحقوق محفوظة إلي تأميني ستور <?php  echo date('Y')?>
                    @else

                        All Copy Rights Reseverd for tameeni store <?php date('Y') ?>

                    @endif
                </p>

                <br>
                <div class="col-lg-12" style="margin-top:-18px;padding-bottom:20px;">
                <li class="nav-item" style="display:inline-block;">
                             <a  style="color:black;font-size:14px;font-weight:600"href="{{url('/')}}/view/usage/{{app()->getLocale()}}">
                                 @if(app()->getLocale() =='en')
                                    Public usage
                                 @else

                                   شروط الاستخدام العامة
                                 @endif
                             </a>
                         </li>
                          |
                         <li class="nav-item" style="display:inline-block">
                             <a style="color:black;font-size:14px;font-weight:600" href="{{url('/')}}/view/termsandcondition/{{app()->getLocale()}}">
                                 @if(app()->getLocale() =='en')
                                    Conditions and Terms
                                 @else

                                    الشروط و سياسة الاستخدام
                                 @endif
                             </a>
                         </li>
                         </div>

                 <span id="siteseal" style="margin-top:15px;"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=pjoT0LKNFNCDuZfPv442GjfxLZqtFEGFg72rMRAe9C77Frec7gzXGG3WJ0c3"></script></span>
                @if($website->whats==1)
                <div class="text-left ml-2 whats" style="bottom: 1px;top: 1p;background-color: transparent"><a href="https://api.whatsapp.com/send?phone={{$website->phone}}">
                        <i class="fa fa-whatsapp img-thumbnail" aria-hidden="true" style="font-size:48px;color:#ffffff;background-color: #01e675" ></i>
                    </a>
                </div>
                    @endif
            </div>
        </footer>
    </div>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5fe5ffd5a8a254155ab64ca7/1eqd6umfm';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2();
    });

    $(".searchable").keyup(function () {
       alert('uploading files');
});

    </script>
    @if(app()->getLocale() == 'en')

        <script type="text/javascript">
            function showAlert()
    {
        alert('Under Construction Now');
    }

        </script>

    @else

               <script type="text/javascript">
            function showAlert()
    {
        alert('تحت الانشاء الان');
    }
        </script>



    @endif

    <script type="text/javascript">
    var csrf =  $('meta[name="csrf-token"]').attr('content');
    var lang =  $('meta[name="lang"]').attr('content');

    $(document).ready(function(){
        $(".preloader").fadeOut('10000');
    });
</script>

    @yield('js')
</body>
</html>
