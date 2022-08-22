@extends('layouts.app')
<?php  $countries = \App\country::where('status',1)->get();
$lang = app()->getLocale();
$name = $lang == 'ar' ? 'ar_name' : 'en_name';
$countries2 = \App\country::where('status', 1)->get();?>
<input type="hidden"  id="lang" value="{{app()->getLocale()}}">

@section('content')
<div class="page-content sign-in-up">
    <!-- start page-heading.html-->
    <section class="header-section">
        <div class="container border_only_login_page">
            <div class="heading-wrapper">
                <div class="">
                    <ol class="breadcrumb">
                        <li>
                            <a href="https://tameenistore.com">الرئيسية</a>
                        </li>
                        <li class="active">
                            <a href="https://tameenistore.com/login">  تسجيل جديد </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- end page-heading.html-->
    <div class="container">
        <div class="new_big_logo_div">
            <div class="main_logo_styles">
                <a href="https://tameenistore.com">
                    <img src="asset('assets_v2/imgs/logo.png')}}" alt="tameenistore" title="tameenistore" width="200">
                </a>
            </div>
            <div>
                <h1 class="h1_tag_for_seo">أكبر سوق للبيع والشراء في قطر</h1>
            </div>
        </div>

        <div class="div_for_errors">
                            </div>

        <div class="content none_margin_login_page">
            <div class="row">
                <div class="half-section login_section_pad_top login_container_margin_top_bottom">
                    <div class="heading-container sing_in_text">
                        <h3 class="heading login_page_arabic_text_style">تسجيل جديد</h3>
                        <p class="sub-heading">ليس لديك حساب سجل الان</p>
                    </div>

                    <form role="form" class="form form-horizontal registration" id="registerform" action="https://tameenistore.com/register" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                        <input type="hidden" name="_token" value="yQMgiYbVXJvsOur4iOH8Qiy30goth5TaneA5SeXp">

                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">الاسم </label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <input type="text" class="form-control register_inputs user_name_for_aws" name="name" placeholder="الاسم ">
                            </div>
                        </div>
                
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">البريد الالكترونى</label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <input type="text" class="form-control register_inputs user_email_for_aws" name="email" placeholder="البريد الالكترونى الخاص بك">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">الدولة </label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <select class="form-control register_inputs">
                                    @foreach($countries as $country)
                                    <option value="{{$country->id}}">
                                        {{$country->$name}}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">الدولة </label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <select class="form-control select2 register_inputs"   value="{{old('country_id')}}"  name="country_id" id="country">
                                    <option value=""  >{{__('site.choose')}}</option>
                                    @foreach($countries as $country)
                                    <option value="{{$country->id}}">
                                        {{$country->$name}}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">المنطقة </label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <select class="form-control select2 register_inputs" value="{{old('governorate_id')}}"  name="governorate_id"_ id="governorate">
                                    <option value=""  >{{__('site.choose')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">المدينة </label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <select class="form-control select2 register_inputs"value="{{old('city_id')}}"  name="city_id" id="city">
                                    <option value=""  >{{__('site.choose')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">كلمة السر</label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <input type="password" class="form-control register_inputs user_password_for_aws" id="password1" name="password1" placeholder="كلمة السر">
                            </div>
                        </div>

                        <div class="form-group repeate_password">
                            <label class="control-label col-sm-3 col-md-3">اعادة كلمة السر</label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <input type="password" class="form-control register_inputs user_password_for_aws_confirm" name="password2" placeholder="اعادة كلمة السر">
                            </div>
                        </div>

                        <div class="buttons register_buton">
                            <div class="row">
                                <div class="col-sm-offset-3 col-sm-9 col-md-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button class="btn btn-block btn-nav this_register_button" type="submit">
                                                تسجيل
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="half-section login_section_pad_top login_container_margin_top_bottom">
                    <div class="heading-container sing_in_text">
                        <h3 class="heading login_page_arabic_text_style">تسجيل جديد</h3>
                        <p class="sub-heading">ليس لديك حساب سجل الان</p>
                    </div>

                    <form role="form" class="form form-horizontal registration" id="registerform" action="https://tameenistore.com/register" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">الاسم </label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <input type="text" class="form-control register_inputs user_name_for_aws" name="name" placeholder="الاسم ">
                            </div>
                        </div>
                    </form>
                </div>
            
            </div>
        </div>
    </div>
</div>
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