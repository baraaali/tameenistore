@extends('layouts.app')
@section('content')
<?php
$website = \App\Website::first();
$name=app()->getLocale();
$des='description_'.$name;
?>

<div class="col-lg-12 cover-adv" style="background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
@include('dashboard.layout.message')
        <div class="upper">
        <h2 class="place"style="margin: 0px auto;">
           {{__('site.about_us')}}  </h2>
            <br>
            <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            <div class="col-lg-8" style="margin: 0px auto;padding-bottom: 30px">
            <p style="text-align:center;font-size:15px;">
            {!! $website->$des !!}
            </p>
            </div>

        </div>
</div>

<div class="col-lg-12">
    <h2 style="text-align:center;padding:20px;">
        @if(app()->getLocale() == 'ar')
        تواصل معنا
        @else
        Contact Us
        @endif
    </h2>
    <div class="container">
          <div class="row">
        <div class="col-lg-6">
            <p>
              @if(app()->getLocale() == 'ar')
              البريد الالكتروني الاول
              @else
              First Email Address
              @endif
            </p>
            <small style="color:#8b8b8b;font-weight:bold">
                {{$website->email_1}}
                <hr>
            </small>

            <p>
              @if(app()->getLocale() == 'ar')
              البريد الالكتروني الثاني
              @else
              Second Email Address
              @endif
            </p>
            <small style="color:#8b8b8b;font-weight:bold">
                {{$website->email_2}}
                <hr>
            </small>


        </div>
           <div class="col-lg-6">
            <p>
              @if(app()->getLocale() == 'ar')
                رقم التيليفون الاول
              @else
              First Mobile No.
              @endif
            </p>
            <small style="color:#8b8b8b;font-weight:bold">
                {{$website->phone_1}}
                <hr>
            </small>

            <p>
              @if(app()->getLocale() == 'ar')
              رقم التيليفون الثاني
              @else
              Second Mobile No.
              @endif
            </p>
            <small style="color:#8b8b8b;font-weight:bold">
                {{$website->phone_2}}
                <hr>
            </small>


        </div>
    </div>
    </div>

</div>

<div class="container contact-form">

    <form method="post" action="{{route('contact_with_us')}}">
        @csrf
        <h3></h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="txtName" class="form-control" placeholder="{{__('site.name')}} *" required />
                </div>
                <div class="form-group">
                    <input type="email" name="txtEmail" class="form-control" placeholder="{{__('site.email')}} *" required/>
                </div>
                <div class="form-group">
                    <input type="text" name="txtPhone" class="form-control" placeholder="{{__('site.phone')}}*" required/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnSubmit" class="btn btn-primary text-white text-center" value="{{__('site.send')}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <textarea name="txtMsg" class="form-control" placeholder="{{__('site.message')}} *" style="width: 100%; height: 150px;"></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
