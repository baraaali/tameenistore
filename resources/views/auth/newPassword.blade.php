@extends('layouts.app')

@section('content')
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
    <form class="form" method="POST" action="{{route('user-change-password',app()->getLocale())}}" enctype="multipart/form-data"> 
        @csrf
        <h1 class="forms-header">
            @if(app()->getLocale() == 'ar')
               إضافة كلمة مرور جديدة
            @else
              Add New Password
            @endif
        </h1>
        <div class="break-line-sm">
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group mtop-15">
                     <label>
                         <input type="hidden" value="{{$id}}" name="id" />
                        @if(app()->getLocale() == 'ar')
                             كلمة المرور
                        @else
                            Password
                        @endif  <small class="text-danger">*</small>
                    </label>
                    <input type="password" name="password" class="SpecificInput" required="required">
                </div>
                <div class="form-group mtop-15">
                     <label>
                         @if(app()->getLocale() == 'ar')
                            إعد كلمة المرور
                        @else
                            Re Passwrod
                        @endif   <small class="text-danger">*</small>
                    </label>
                    <input type="password" name="user_password_confirmed" class="SpecificInput" required="required">
                </div>
            </div>
        </div>
        <hr>

       
        <div class="submit {{app()->getLocale() == 'ar' ? 'text-left' : 'text-right'}}" >
            <input type="submit" name="submit" class="btn btn-primary big-button" value="{{app()->getLocale() == 'ar' ? 'التسجيل ' : 'Register'}}">
        </div>
    </form>
</div>
@endsection
