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

?>

<div class="container" style="height:100vh;padding-top:200px;">

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center">
            <h1>
                @if(app()->getLocale() == 'ar')
                    عفوا لقد انتهت مدة اشتراكك
                    
                @else
                    Sorry Your Membership is Done
                @endif
            </h1>
            <div class="row">
                <div class="col-md-6 ">
                    <a href="{{url('/')}}/" class="btn btn-primary btn-block" >
                        <i class="fa fa-home"></i>
                        @if(app()->getLocale() == 'ar')
                        
                         العودة للرئيسية
                        @else
                            Back To home
                        
                        @endif
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{url('/')}}/" class="btn btn-primary btn-block" >
                        <i class="fas fa-money-check"></i>
                        @if(app()->getLocale() == 'ar')
                        
                             تجديد الاشتراك
                        @else
                            
                            Renew Your Membership
                        
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection