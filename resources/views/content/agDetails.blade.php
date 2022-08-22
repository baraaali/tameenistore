@extends('layouts.app')
@section('content')
<style>
    h5{
        font-weight:bold;
    }
</style>
<?php 

use Carbon\Carbon;
if($lang == 'ar' || $lang == 'en')
		{
			App::setlocale($lang);
		}
		else
		{
			App::setlocale('ar');
		}
?>
  <div class="col-lg-12">
      <div class="container">
        <div class="row">
            <div class="col-lg-12 header-2">
            <div class="row">
                <div class="col-lg-6">
                 <div class="row">
                      <div class="col-lg-4">
                         <img src="{{url('/')}}/uploads/{{$agent->image}}" style="width:100%;height:100%">
                     </div>
                     <div class="col-lg-8">
                         <h5>
                              @if(app()->getLocale() == 'ar')
                                {{$agent->ar_name}}
                              @else
                                {{$agent->en_name}}
                              @endif
                         </h5>
                        
                     </div>
                    
                 </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        @if(app()->getLocale() == 'ar')
                        <div class="col-lg-4" style="text-align:center;border-right:1px solid #d3d3d3">
                            <i class="fas fa-map-marker-alt" style="font-size: 60px;color: #0674FD;"></i>
                            <p style="margin-top: 20px;font-weight: bold;">Egypt-Cairo</p>
                        </div>
                        <div class="col-lg-4" style="text-align:center;border-right:1px solid #d3d3d3">
                            <i class="fas fa-id-badge"style="font-size: 60px;color: #0674FD;"></i>
                            @if($agent->phones)
                            <p style="margin-top: 20px;font-weight: bold;">{{$agent->phones}}</p>
                            @else
                            <p style="margin-top: 20px;font-weight: bold;">لا يوجد</p>
                            @endif
                        </div>
                        <div class="col-lg-4" style="text-align:center;border-right:1px solid #d3d3d3">
                            <i class="fas fa-building" style="font-size: 60px;color: #0674FD;"></i>
                            <p style="margin-top: 20px;font-weight: bold;">عدد الفروع : 12</p>
                        </div>
                        @else
                        <div class="col-lg-4" style="text-align:center;border-left:1px solid #d3d3d3">
                            <i class="fas fa-map-marker-alt" style="font-size: 60px;color: #0674FD;"></i>
                            <p style="margin-top: 20px;font-weight: bold;">Egypt-Cairo</p>
                        </div>
                        <div class="col-lg-4" style="text-align:center;border-left:1px solid #d3d3d3">
                            <i class="fas fa-id-badge"style="font-size: 60px;color: #0674FD;"></i>
                            <p style="margin-top: 20px;font-weight: bold;">{{$agent->phones}}</p>
                        </div>
                        <div class="col-lg-4" style="text-align:center;border-left:1px solid #d3d3d3">
                            <i class="fas fa-building" style="font-size: 60px;color: #0674FD;"></i>
                            <p style="margin-top: 20px;font-weight: bold;">No.Of Branch : 12</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>  
        
        
        <div class="col-lg-12 branch-content" style="margin-top:20px;border-radius:5px;border:1px solid #d3d3d3;padding:20px;">
            @if(app()->getLocale() == 'ar')
            <h5 style="padding:10px;"> <i class="fas fa-car" style="font-size: 25px;color: #0674FD;"></i> السيارات المتوفرة</h5>
            @else
            <h5 style="padding:10px;"> <i class="fas fa-car" style="font-size: 25px;color: #0674FD;"></i> Available Cars</h5>
            @endif
        <div class="row">
        <div class="col-lg-8">
             <div class="row">
              @if($featureedCars2)
                @foreach($featureedCars2 as $feature)
                    <div class="col-md-6" style="margin-top:20px;">
                    <a href="{{URL::route('view-ad', [$feature->id,app()->getLocale()] )}}" style="text-decoration: none;">
                    <div class="card"> 
                        <img src="{{url('/')}}/uploads/{{$feature->Images ? $feature->Images[0]->image : ''}}" class="card-image">
                        <div class="cost-holder">
                            {{$feature->Price->cost}} {{$feature->Price->currency}}
                        </div>
                         @if($feature->special == 3)
                        <div class="badge-holder">
                            <span class="badge badge-warning">
                                مميز
                            </span>
                        </div>
                        @elseif ($feature->special == 2)
                        <div class="badge-holder">
                            <span class="badge badge-success">
                                مميز
                            </span>
                        </div>
                        @esleif ($feature->special == 1)
                            <div class="badge-holder">
                                <span class="badge badge-success">
                                    مميز
                                </span>
                            </div>
                        @endif
                        <p class="card-hint-line">
                            <span class="hint-line">
                                <i class="fa fa-map-marker-alt"></i>
                               @if(app()->getLocale() == 'ar')
                                {{$feature->country->ar_name}}
                               @else
                                {{$feature->country->en_name}}
                               @endif
                            </span>
                        </p>
                        <p class="card-title">
                            @if(app()->getLocale() == 'ar')
                                {{$feature->ar_name}}
                            @else
                                {{$feature->en_name}}
                            @endif
                        </p>
                        <p class="second-title">
                            <span class="second-detail">
                                <i class="fa fa-eye"></i> {{$feature->visitors}} 
                            </span>
                            <span class="second-detail margin-right">
                                <i class="far fa-clock"></i>  {{Carbon::parse($feature->created_at)->toFormattedDateString()}}
                            </span>
                        </p>
                        <div class="third-title">
                            <div class="row">
                                <div class="col-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-tachometer-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">{{$feature->max}}
                                            @if(app()->getLocale() == 'ar')

                                                كم\س
                                            @else

                                            km\h

                                            @endif
                                        </span>
                                    </div>
                                    
                                </div>
                                <div class="col-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-road SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">{{$feature->kilo_meters}}
                                          @if(app()->getLocale() == 'ar')

                                                كم
                                            @else

                                            km

                                            @endif</span>
                                    </div>
                                    
                                </div>
                                <div class="col-4 text-center p-all third-detail-holder">
                                    <div class="background-grey">
                                        <i class="fa fa-calendar-alt SecondColor" style="display: block"></i>
                                        <span class="third-detail SecondColor">{{$feature->year}}</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <hr style="margin-bottom: .5rem">
                        <div class="fourth-title">
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-user" ></i>
                                    <span class="third-detail" style="padding-top:0px;">
                                        {{$feature->OwnerInformation->User->name}}
                                    </span>
                                </div>
                                 
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
              @else
              <div class="col-lg-12">
              <h1>There is no Cars</h1>
              </div>
              @endif
            </div>
        </div>
        </div>
        @if(app()->getLocale() == 'ar')
        <div class="col-lg-4" style="border-right:1px solid #d3d3d3;padding:10px;text-align:center">
            <h5 style="padding:10px;"><i class="fas fa-clock"></i> اوقات العمل</h5>
            <p>{{$agent->days_on}}</p>
            <p>{{$agent->times_on}}</p>
            <hr>
            <h5 style="padding:10px;"># روابط التواصل</h5>
            <a href="{{$agent->email}}"class="btn btn-primary" style="text-align:center;margin-top:10px;display:block">{{$agent->email}}</a>
            <a href="{{$agent->fb_page}}"class="btn btn-light" style="text-align:center;margin-top:5px;display:block"><i class="fab fa-facebook-square"></i> رابط فيسبوك </a>
            <a href="{{$agent->twitter_page}}" class="btn btn-light" style="text-align:center;margin-top:5px;display:block"><i class="fab fa-twitter-square"></i> رابط تويتر</a>
            <a href="{{$agent->instagram}}" class="btn btn-light" style="text-align:center;margin-top:5px;display:block"><i class="fab fa-instagram"></i> رابط انستجرام</a>
            <hr>
            <h5 style="padding:10px;"># الموقع علي الخريطة</h5>
            {!! $agent->google_map !!}
            
            
        </div>
        @else
        <div class="col-lg-4" style="border-left:1px solid #d3d3d3;padding:10px;text-align:center">
            <h5 style="padding:10px;"><i class="fas fa-clock"></i>Time Of Work</h5>
            <p>{{$agent->days_on}}</p>
            <p>{{$agent->times_on}}</p>
            <hr>
            <h5 style="padding:10px;"># Social Media</h5>
            <a href="{{$agent->email}}"class="btn btn-primary" style="text-align:center;margin-top:10px;display:block">{{$agent->email}}</a>
            <a href="{{$agent->fb_page}}"class="btn btn-light" style="text-align:center;margin-top:5px;display:block"><i class="fab fa-facebook-square"></i> Facebook Link</a>
            <a href="{{$agent->twitter_page}}" class="btn btn-light" style="text-align:center;margin-top:5px;display:block"><i class="fab fa-twitter-square"></i> Twitter Link</a>
            <a href="{{$agent->instagram}}" class="btn btn-light" style="text-align:center;margin-top:5px;display:block"><i class="fab fa-instagram"></i> Instagram Link</a>
            <hr>
            <h5 style="padding:10px;"># Location on Map</h5>
            {!! $agent->google_map !!}
            
            
        </div>
        @endif
        </div>
        </div>
      </div>
  </div>



@endsection