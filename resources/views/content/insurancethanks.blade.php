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
?>



<div class="container">
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif



 <div class="container">


        <div class="section-3" style="padding: 25px !important; margin-top:25px;background-color: #F3F3F3">

 @if(app()->getLocale() == 'ar')
           <div class="jumbotron text-md-center ">
              <h1 class="display-3"> تم ارسال الطلب بنجاح  !</h1>

              <hr>

              <p class="lead">
                <a class="btn btn-primary btn-sm" href="{{url('/')}}" role="button">العودة للصفحة الرئيسية</a>
              </p>
            </div>
     @else
      <div class="jumbotron text-md-center">
              <h1 class="display-3">Stored Save ! Thank you</h1>

              <hr>

              <p class="lead">
                <a class="btn btn-primary btn-sm" href="{{url('/')}}" role="button">Continue to homepage</a>
              </p>
            </div>
     @endif






        </div>


</div>
 <hr>





</div>



@endsection
