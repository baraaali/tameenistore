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

<style type="text/css">
    .select2-container {
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    position: relative;
    vertical-align: middle;
    width: 100% !important;
}
</style>
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
    <form class="form" method="post" action="{{route('userdata',app()->getLocale())}}" enctype="multipart/form-data"> 
        @csrf
        <h1 class="forms-header">
            @if(app()->getLocale() == 'ar')
     تسجيل مشتري
            @else
                client Registration
            @endif
        </h1>
        <div class="break-line-sm">
        </div>

        <div class="row">
            <input type="hidden" value="{{$complete_id}}" name="complete_id">
            <div class="col-md-4">
                <div class="form-group mtop-15">
                     <label>
                        @if(app()->getLocale() == 'ar')
                            الاسم
                        @else
                            Name
                        @endif  <small class="text-danger">*</small>
                    </label>
                    <input type="text" name="user_name" class="SpecificInput" required="required">
                </div>
                 <div class="form-group mtop-15">
                     <label>
                        @if(app()->getLocale() == 'ar')
                             كلمة المرور
                        @else
                            Password
                        @endif  <small class="text-danger">*</small>
                    </label>
                    <input type="password" name="password" id="password" class="SpecificInput" required="required">
                </div>
               
            </div>
            
            <div class="col-md-4">
                <div class="form-group mtop-15">
                     <label>
                        @if(app()->getLocale() == 'ar')
                            البريد الالكتروني
                        @else
                            Email
                        @endif  <small class="text-danger">*</small>
                    </label>
                    <input type="email" name="email" class="SpecificInput" required="required">
                </div>
                 <div class="form-group mtop-15">
                     <label>
                         @if(app()->getLocale() == 'ar')
                            إعد كلمة المرور
                        @else
                            Re Passwrod
                        @endif   <small class="text-danger">*</small>
                    </label>
                    <input type="password" name="user_password_confirmed" id="user_password_confirmed" class="SpecificInput" required="required">
                </div>
                

                
                
            </div>
            <div class="col-md-4">
                <div class="form-group mtop-15">
                     <label>
                        @if(app()->getLocale() == 'ar')
                            رقم التليفون
                        @else
                            Phone
                        @endif  <small class="text-danger">*</small>
                    </label>
                    <input type="nummber" name="phones" class="SpecificInput" required="required">
                </div>

                

                
                
            </div>
        </div>
        <hr>

      
        <div class="submit {{app()->getLocale() == 'ar' ? 'text-left' : 'text-right'}}" >
            <input type="submit" name="submit" class="btn btn-primary big-button" value="{{app()->getLocale() == 'ar' ? 'التسجيل ' : 'Register'}}">
        </div>
    </form>
</div>
<script>
    var password = document.getElementById("password")
  , confirm_password = document.getElementById("user_password_confirmed");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
@endsection
