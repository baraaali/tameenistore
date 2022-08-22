@extends('layouts.app')
@section('content')
<?php

    if($lang == 'ar' || $lang == 'en')
        {
            App::setlocale($lang);
        }
        else
        {
            App::setlocale('ar');
        }

        $type=auth()->user()->type;

?>
<style>
    .pt-4, .py-4 {
     padding-top: 0px !important;
    }
</style>

@if (Request::segment(6)!='admin')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">
              @if(app()->getLocale() == 'ar')

                لوحة تحكم البائع

              @else

                Seller Center

              @endif
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item ">
                <a class="nav-link" href="{{url('/')}}/cp/index/{{app()->getLocale()}}">

                    @if(app()->getLocale() == 'ar')
                        معلومات الرئيسية
                    @else

                        Main Information

                    @endif

                </a>
              </li>
              @if ($type == 5 || true)
              <li class="nav-item ">
                <a class="nav-link" href="{{url('/')}}/cp/mcenter-services/{{app()->getLocale()}}">
                  {{__('site.maintenance services')}}
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="{{url('/')}}/cp/mcenter-additional-services/{{app()->getLocale()}}">
                  {{__('site.additional maintenance services')}}

                </a>
              </li>
              @endif
              @if ($type == 0 || $type == 5 || true)
              <li class="nav-item ">
                <a class="nav-link" href="{{url('/')}}/cp/mcenter-requests/{{app()->getLocale()}}">
                  {{__('site.maintenance requests')}}
                </a>
              </li>
              @endif
                @if($type!=6 || true)
                    @if($type !=4 || true)
                  <li class="nav-item ">
                    <a class="nav-link" href="{{url('/')}}/cp/ads/{{app()->getLocale()}}">

                        @if(app()->getLocale() == 'ar')
                            إعلانات السيارات
                        @else
                            Car Ads
                        @endif
                    </a>
                  </li>

                  <li class="nav-item ">
                    <a class="nav-link" href="{{url('/')}}/cp/servies/{{app()->getLocale()}}">{{__('site.new_module')}}</a>
                  </li>

                  <li class="nav-item ">
                    <a class="nav-link" href="{{url('/')}}/cp/accessories/{{app()->getLocale()}}">

                        @if(app()->getLocale() == 'ar')

                            إعلانات  الاقسام الفرعية

                        @else

                            Departments Ads

                        @endif

                    </a>
                  </li>
                    @endif

                    @if($type==4 || true)
                  <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           @if(app()->getLocale() == 'ar')

                            تأمين السيارت
                            @else
                               Insurances

                            @endif

                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{url('/')}}/insurance/requests/{{app()->getLocale()}}">
                                @if(app()->getLocale() == 'ar')

                                    طلبات التأمينات

                                @else

                                    Insurance Requests

                                @endif
                            </a>
                            <a class="dropdown-item" href="{{url('/')}}/complete/requests/{{app()->getLocale()}}">
                                @if(app()->getLocale() == 'ar')

                                    طلبات التامين الشامل

                                @else

                                    Complete Requests

                                @endif
                            </a>
                            @if(auth()->user()->type==4)
                            <a class="dropdown-item" href="{{url('/')}}/Cdashboard/insurance/{{app()->getLocale()}}">
                            @if(app()->getLocale() == 'ar')

                                تأمينات ضد الغير المضافة

                            @else

                               Added Against Other Insurnace

                            @endif
                          </a>
                          <a class="dropdown-item" href="{{url('/')}}/Cdashboard/complete/insurance/{{app()->getLocale()}}">
                            @if(app()->getLocale() == 'ar')

                                التأمينات الشاملة المضافة

                            @else

                               Added Complete Insurance

                            @endif
                          </a>
                            @endif

                        </div>
                      </li>
                    @endif

                  <li class="nav-item">
                        <a class="nav-link" href="{{route('show_balance',$lang)}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        </a>
                    </li>
                  <li class="nav-item ">
                    <a class="nav-link" href="{{route('show_balance',app()->getLocale())}}">{{__('site.balance')}}</a>
                  </li>
                  <li class="nav-item ">
                    <a class="nav-link" href="{{route('promotion',app()->getLocale())}}">{{__('site.promotion')}}</a>
                  </li>
                @else
                    <li class="nav-item mt-1 ml-1 mr-1">
                        <a href="{{route('edit_travel_com',$lang)}}" >
                            {{__('site.edit_company')}}
                        </a>
                    </li>
                @endif

            </ul>
          </div>
</nav>
@endif
    <div class="container-fluid">

        @yield('controlPanel')
    </div>


@endsection
