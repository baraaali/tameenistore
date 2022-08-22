<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="{{asset('css/chat.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

</head>
<?php
use Carbon\Carbon;use Illuminate\Support\Facades\DB;
$website = \App\Website::where('id',1)->first();
$website->description= strip_tags(preg_replace('/\s+/', ' ', $website->description));
$user_id=auth()->user()->id;
$msgs = DB::select('select * from messages where from_user='.$user_id.' and to_user='.$receiver->id.' or from_user='.$receiver->id.' and to_user='.$user_id);
?>
<body>
<div class="container-fluid" style="direction: rtl">
    <div class="row">
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
                        @if($website->shameel==1||$website->other==1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle href-c" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(app()->getLocale() == 'ar')
                                        {{ __('تأمين السيارات') }}
                                    @else
                                        Insurance
                                    @endif
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if($website->shameel==1)
                                        <a class="dropdown-item" href="{{route('CompShow',app()->getLocale())}}">
                                            @if(app()->getLocale() == 'ar')
                                                {{ __('تأمين شامل ') }}
                                            @else
                                                Comprehensive
                                            @endif
                                        </a>
                                    @endif
                                    @if($website->other==1)
                                        <a class="dropdown-item" href="{{route('dcShow',app()->getLocale())}}">
                                            @if(app()->getLocale() == 'ar')
                                                {{ __('تأمين ضد الغير') }}
                                            @else
                                                Tpl Insurance
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endif
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

    </div>
</div>
<hr>
<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        <li class="clearfix active">
                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                            <div class="about">
                                <div class="name">{{$receiver->name}}</div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0">{{$receiver->name}}</h6>
                                </div>
                            </div>
                            <div class="col-lg-6 hidden-sm text-right">
                            </div>
                        </div>
                    </div>
                    <div class="chat-history" id="chat-history">
                        <ul class="m-b-0">

                            @foreach ($msgs  as $msg)
                                @if($msg->from_user==$receiver->id)
                                <li class="clearfix">
                                    <div class="message-data text-right">
                                        <span class="message-data-time">{{Carbon::parse($msg->created_at)->toFormattedDateString()}}</span>
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                    </div>
                                    <div class="message other-message float-right"> {{$msg->body}} </div>
                                </li>
                                @else
                                <li class="clearfix">
                                    <div class="message-data">
                                   <span class="text-danger">{{__('site.you')}}</span>
                                    </div>
                                    <div class="message my-message">{{$msg->body}}</div>
                                    <div class="message-data-time">{{Carbon::parse($msg->created_at)->toFormattedDateString()}}</div>
                                </li>
                                @endif
                            @endforeach

                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <form action="{{route('chat.send')}}" method="post" style="width: 100%">
                                @csrf
                                @method('post')
                                <input type="hidden" name="user" value="{{$receiver->id}}">
                               <div class="input-group-prepend text-right">
                                   <button class="input-group-text" type="submit"><i class="fa fa-send"></i></button>
                                   <input type="text" name="msg" id="sen_msg"   required class="form-control" placeholder=" ...اكتب رسالتك هنا ">
                               </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        document.getElementById('sen_msg').focus();
    });
    var objDiv = document.getElementById("chat-history");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>
</body>
</html>