@extends('layouts.app')
@section('content')
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
		$name='name_'.$lang;
		if ($status== -1) $sub=\App\MemberInsurance::where('type','0')->where('free','0')->first();
        elseif ($status== -2) $sub=\App\MemberInsurance::where('type','1')->where('free','0')->first();
		elseif ($status==1||$status==2) $sub=\App\MemberInsurance::where('type','0')->where('free','1')->first();
         else $sub=\App\MemberInsurance::where('type','1')->where('free','1')->first();
?>
<!--{{dd($sub)}}-->
<div class="section-2 col-lg-12">
    <div class="container text-center">
        <h1 class="wow animate__fadeInDown" data-wow-duration="1s">{{__('site.memberships')}}</h1>
        <hr class="breakLine">

    </div>
@include('dashboard.layout.message')

    <div class="container">
        <div class="row d-flex justify-content-center">
                <div class="col-md-4 ">
                    <div class="card"  style="height:320px">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{$sub->$name}}
                            </h5>
                            <hr>
                            @if(app()->getLocale() == 'ar')
                            <p class="card-text">
                            ستمنحك هذه العضويه فترة <span class="text-white btn btn-primary">{{$sub->duration}} </span>يوما
                                 يمكنك خلالها اضافه اعلانات التأمين
                            </p>


                                <div class="badge badge-success" style="position:absolute;left:0px;padding-right:10px;padding-left:10px;top:5px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;">
                                <span>
                                    {{$sub->price==0?'مجانى':$sub->price}} $
                                </span>
                                </div>

                            @else
                                <p class="card-text">
                                    This membership will give you a period <span class="text-white btn btn-primary">{{$sub->duration}} </span>
                                     days You can add insurance ads
                                </p>
                                <div class="badge badge-success" style="position:absolute;left:0px;padding-right:10px;padding-right:10px;top:5px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;">
                                <span>
                                {{$sub->price==0?'free':$sub->price}} $
                                </span>
                                </div>
                            @endif
                            <form action="{{route('selectMembership')}}">
                                <input type="hidden" name="membership" value="{{$sub->id}}">
                                <input type="hidden" name="type" value="{{$type}}">
                                <input type="submit" class="btn btn-warning" style="margin-bottom: -120px;width: 100%" @if ($status !='-1')onclick="return confirm('سيتم خصم قيمه هذه العضويه من رصيدك .. هل انت موافق ؟')" @endif>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
