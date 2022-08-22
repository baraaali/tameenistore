@extends('layouts.app')

@section('content')
<?php  $countries = \App\country::where('status',1)->get();?>
<input type="hidden"  id="lang" value="{{app()->getLocale()}}">

<div class="container">
    <ol class="breadcrumb bg-white">
        <li>
            <a class="text-dark px-3" href="https://tameenistore.com">{{__('site.home')}}</a>
        </li>
        >
        <li class="active">
            <a  class="text-dark px-3"  href="https://tameenistore.com/login">{{__('site.login')}}</a>
        </li>
    </ol>
</div>
<section>
    <div class="container">
        <div class="wrapper my-3 bg-white">
                <a href="#">
                    <img class="d-block m-auto" src="{{ asset('assets_web/images/logo.png') }}" width="230" height="130" class="d-inline-block p-2 align-top" alt="">
                </a>
        <div>
        <div class="text-center text-secondary">
                    <h3 class="heading login_page_arabic_text_style">{{__('site.register')}}</h3>
                    <p class="sub-heading">{{__('site.enjoy the service now')}}</p>
        </div>

        <div class="content p-4">
            <div class="row">
                <div class="col-md-12 m-auto text-center m-0">
                    <form role="form" class="form form-horizontal registration" id="registerform" action="{{route('user-store')}}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-12">الاسم </label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <input type="text" value="{{old('name')}}" class="form-control register_inputs user_name_for_aws" name="name" placeholder="الاسم ">
                                    </div>
                                </div>
                        
                                <div class="form-group">
                                    <label class="control-label col-md-12">البريد الالكترونى</label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <input type="text" value="{{old('email')}}"  class="form-control register_inputs user_email_for_aws" name="email" placeholder="البريد الالكترونى الخاص بك">
                                        <p class="form-text direction text-muted">المرجوا إدخال بريد إلكتروني صحيح       </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">رقم الهاتف</label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <input type="text" value="{{old('phones')}}"  class="form-control register_inputs " name="phones" placeholder="رقم الهاتف">
                                        <p class="form-text direction text-muted">المرجوا إدخال رقم هاتف صحيح مع رمز الدولة </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">الدولة </label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <select class="form-control select2 register_inputs"   value="{{old('country_id')}}"  name="country_id" id="country">
                                            <option value=""   >{{__('site.choose')}}</option>
                                            @foreach($countries as $country)
                                            <option  value="{{$country->id}}">
                                                {{$country->getName()}}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-12">المنطقة </label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <select class="form-control select2 register_inputs" value="{{old('governorate_id')}}"  name="governorate_id"_ id="governorate">
                                            <option value=""  >{{__('site.choose')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">المدينة </label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <select class="form-control select2 register_inputs" value="{{old('city_id')}}"  name="city_id" id="city">
                                            <option value=""  >{{__('site.choose')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">نوع الحساب</label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                    <select required class="form-control register_inputs"   value="{{old('user_type')}}"  name="user_type" id="user_type">
                                        <option value=""  >{{__('site.choose')}}</option>
                                        <option value="0" >مستخدم</option>
                                        <option value="2" >  معارض السيارات (بيع -شراء)</option>
                                        <option value="3" > وكالة  تأجير</option>
                                        <option value="4" > شركه تامين بالعموله _ مكتب تامين بالعموله  </option>
                                        <option value="5" >    مركز صيانة </option>
                                    </select>
                                    </div>
                                    </div>
        
                                <div class="form-group">
                                    <label class="control-label col-md-12">كلمة السر</label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <input type="password" class="form-control register_inputs user_password_for_aws" id="password1" name="password" placeholder="كلمة السر">
                                    </div>
                                </div>
        
                                <div class="form-group repeate_password">
                                    <label class="control-label col-md-12">اعادة كلمة السر</label>
                                    <div class="col-md-12 get_parent_label_error_js">
                                        <input type="password" class="form-control register_inputs user_password_for_aws_confirm" name="password_confirmation" placeholder="اعادة كلمة السر">
                                    </div>
                                </div>
                                <div class="w-100">
                                    <button class="btn btn-primary w-100" type="submit">
                                        تسجيل
                                    </button>
                        </div>
        
                            </div>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
       
    </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
    $('.type').change(function () {
         // show maintenance center
        $('#maintenance_center').hide();
        $('.third').hide();
        $('.fourth').hide();
        $('.zero').hide();
        $('.six').hide();
         if($(this).val() == '5')
         {
           $('#maintenance_center').slideDown()
     
         }
        if ($(this).val() != '0' && $(this).val() != '4'  && $(this).val() != '5') {
            $('.third').slideDown();

        }
        if ($(this).val() == '4') {
            $('.fourth').slideDown();
        }
        if ($(this).val() == '0') {
            $('.zero').slideDown();
        }
        if ($(this).val() == '6') {
            $('.six').slideDown();
        }
    });
    var csrf =  $('meta[name="csrf-token"]').attr('content');
    var lang = $('#lang').val()
    var getGovernorates = function()
    {
        $('#country').on('change',function(){
            var id= $(this).val()
            if(id)
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('user-get-governorates')}}",
                type:'post',
                data:{id:id},
                success : function(governorates){
                    var html  = ''
                    governorates.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e[lang+'_name']+'</option>'
                    });
                    $('#governorate').html(html)
                    $('#governorate').trigger('change')
                }
            })
        })
    } 
   var getCities = function()
    {
        $('#governorate').on('change',function(){
            var id= $(this).val()
            if(id)
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('user-cities-get')}}",
                type:'post',
                data:{id:id},
                success : function(cities){
                    var html  = ''
                    cities.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e[lang+'_name']+'</option>'
                    });
                    $('#city').html(html)
                    $('#city').trigger('change')
                }
            })
        })
    }
    $(document).ready(function(){
    getGovernorates()
    getCities()
    })
</script>
@endsection