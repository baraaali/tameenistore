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
        .remove {
            position: absolute;
            top: 100px;
            font-weight: bold;
            right: -5px;
            background: red;
            width: 15px;
            height: 6px;
        }
    </style>
    <?php  $countries = \App\country::where('status',1)->get();
    $lang = app()->getLocale();
    $name = $lang == 'ar' ? 'ar_name' : 'en_name';
    $countries2 = \App\country::where('status', 1)->get();?>
    <input type="hidden"  id="lang" value="{{app()->getLocale()}}">
    <div class="container">
       @include('dashboard.layout.message')

        <form class="form" method="POST" action="{{route('user-store',app()->getLocale())}}"
              enctype="multipart/form-data">
            @csrf
            <h1 class="forms-header">
                @if(app()->getLocale() == 'ar')
                    تسجيل المستخدمين
                @else
                    User Registration
                @endif
            </h1>
            <div class="break-line-sm">
            </div>
        

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mtop-15">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                الاسم
                            @else
                                Name
                            @endif <small class="text-danger">*</small>
                        </label>
                        <input type="text" name="user_name" value="{{old('user_name')}}" class="SpecificInput" required="required">
                    </div>
                    <div class="form-group mtop-15">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                البريد الالكتروني
                            @else
                                Email
                            @endif <small class="text-danger">*</small>
                        </label>
                        <input type="email" name="email"   value="{{old('user_name')}}" class="SpecificInput" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mtop-15">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                كلمة المرور
                            @else
                                Password
                            @endif <small class="text-danger">*</small>
                        </label>
                        <input type="password" name="password" class="SpecificInput" required="required">
                    </div>
                    <div class="form-group mtop-15">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                إعد كلمة المرور
                            @else
                                Re Passwrod
                            @endif <small class="text-danger">*</small>
                        </label>
                        <input type="password" name="user_password_confirmed" class="SpecificInput" required="required">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="country">{{__('site.country')}}</label>
                        <select class="form-control select2"    value="{{old('country_id')}}"  name="country_id" id="country">
                          <option value=""  >{{__('site.choose')}}</option>
                          @foreach($countries as $country)
                          <option value="{{$country->id}}">
                              {{$country->$name}}
                          </option>
                      @endforeach
                        </select>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="governorate">{{__('site.governorate')}}</label>
                        <select class="form-control select2" value="{{old('governorate_id')}}"  name="governorate_id"_ id="governorate">
                          <option value=""  >{{__('site.choose')}}</option>
                        </select>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city">{{__('site.city')}}</label>
                        <select class="form-control select2"value="{{old('city_id')}}"  name="city_id" id="city">
                          <option value="" >{{__('site.choose')}}</option>
                        </select>
                      </div>
                </div>
            </div>
           
            <hr>
            <h1 class="forms-header">
                @if(app()->getLocale() == 'ar')
                    معلومات الحساب
                @else
                    Account Information
                @endif
            </h1>
            <div class="break-line-sm">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mtop-15">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                نوع الحساب
                            @else
                                Account Type
                            @endif <small class="text-danger">*</small>
                        </label>
                        <select class="SpecificInput type"  value="{{old('user_type')}}" name="user_type" required="required">
                            <option selected disabled>
                                @if(app()->getLocale() == 'ar')
                                    إختر نوع الحساب
                                @else
                                    Select Account type
                                @endif
                            </option>

                            <option value="0">
                                @if(app()->getLocale() == 'ar')
                                    {{--                                بائع / شاري--}}
                                    مستخدم
                                @else
                                    Seller / byuer
                                @endif
                            </option>
{{--                            <option value="1">--}}
{{--                                @if(app()->getLocale() == 'ar')--}}
{{--                                    معرض--}}
{{--                                @else--}}
{{--                                    Exhibitor--}}
{{--                                @endif--}}
{{--                            </option>--}}
                            <option value="2">
                                @if(app()->getLocale() == 'ar')
                                    معارض السيارات (بيع -شراء)
                                @else
                                    selling agency
                                @endif
                            </option>
                            <option value="3">
                                @if(app()->getLocale() == 'ar')
                                    وكالة  تأجير
                                @else
                                    Leasing agencies
                                @endif
                            </option>
                            <option value="4">
                                @if(app()->getLocale() == 'ar')
                                    شركه تامين بالعموله _ مكتب تامين بالعموله
                                @else
                                    Insurance Company
                                @endif
                            </option>
                            <option value="5">
                                @if(app()->getLocale() == 'ar')
                                   مركز صيانة
                                @else
                                maintenance center
                                @endif
                            </option>
{{--                            <option value="6">{{__('site.life_insurance')}}</option>--}}

                        </select>
                    </div>

                </div>

            </div>
            <div class="third" style="display: none;">
                <hr>
                <h1 class="forms-header">
                    @if(app()->getLocale() == 'ar')
                        معلومات حول منشاتك
                    @else
                        Information About Your Facility
                    @endif
                </h1>
                <div class="break-line-sm">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    إختر الدولة
                                @else
                                    Country
                                @endif <small class="text-danger">*</small>

                            </label>

                            <select name="country_thrd" class="select2 SpecificInput">


                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">
                                        @if(app()->getLocale() == 'ar')

                                            {{$country->ar_name}}

                                        @else
                                            {{$country->en_name}}
                                        @endif
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    إسم المنشأة  بالعربية
                                @else
                                    Name of your facility in ARABIC
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="ar_facility_name" class="SpecificInput" >

                        </div>

                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    إسم المنشأة   الانجليزية
                                @else
                                    Name of your facility in English
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="en_facility_name" class="SpecificInput" >

                        </div>


                    </div>

                </div>
            </div>
            <div class="fourth" style="display: none;">
                <hr>
                <h1 class="forms-header">
                    @if(app()->getLocale() == 'ar')
                        معلومات حول منشاتك
                    @else
                        Information About Your Facility
                    @endif
                </h1>
                <div class="break-line-sm">
                </div>
                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group mtop-15">
                                <label>
                                    @if(app()->getLocale() == 'ar')
                                        إختر الدولة
                                    @else
                                        Country
                                    @endif <small class="text-danger">*</small>

                                </label>

                                <select name="country_forth" class="select2 SpecificInput">


                                    @foreach($countries2 as $coun)
                                        <option value="{{$coun->id}}">
                                            @if(app()->getLocale() == 'ar')

                                                {{$coun->ar_name}}

                                            @else
                                                {{$coun->en_name}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    إسم المنشأة  بالعربية
                                @else
                                    Name of your facility in ARABIC
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="ar_name" class="SpecificInput" >

                        </div>

                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    إسم المنشأة   الانجليزية
                                @else
                                    Name of your facility in English
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="en_name" class="SpecificInput" >

                        </div>

                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    عنوان المنشأة  بالعربية
                                @else
                                    Name of Company In Arabic
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="ar_address" class="SpecificInput" >

                        </div>

                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    عنوان المنشأة  بالانجليزية
                                @else
                                    Company Address In English
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="en_address" class="SpecificInput" >

                        </div>
                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    التيليفون
                                @else
                                    Phones
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="tel" name="phones" class="SpecificInput" >

                        </div>

                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    الموقع الالكتروني
                                @else
                                    Website
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="email" name="website" class="SpecificInput" >

                        </div>


                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    موقعنا
                                @else
                                    Google Map
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="website" class="SpecificInput">

                        </div>
                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    أيام العمل
                                @else
                                    Days On
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="days_on" class="SpecificInput">

                        </div>
                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    الموقع الالكتروني
                                @else
                                    Website
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="email" name="website" class="SpecificInput" >

                        </div>
                        <div class="form-group mtop-15">
                            <label>
                                @if(app()->getLocale() == 'ar')
                                    أوقات العمل
                                @else
                                    Times On
                                @endif <small class="text-danger">*</small>

                            </label>

                            <input type="text" name="times_on" class="SpecificInput">

                        </div>


                    </div>

                </div>
            </div>
            <div class="six" style="display: none;">
                <hr>
                <h1 class="forms-header">{{__('site.some_details_u_company')}} </h1>
                <div class="break-line-sm">
                </div>
                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group mtop-15">
                            <label>{{__('site.select_country')}}</label>

                            <select name="country_six" class="select2 SpecificInput">
                                @foreach($countries2 as $coun)
                                    <option value="{{$coun->id}}">{{$coun->ar_name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group mtop-15">
                            <label>{{__('company_name_ar')}} <small class="text-danger">*</small></label>
                            <input type="text" name="ar_com_name" class="SpecificInput" >
                        </div>

                        <div class="form-group mtop-15">
                            <label>{{__('company_name_en')}}<small class="text-danger">*</small></label>
                            <input type="text" name="en_com_name" class="SpecificInput" >
                        </div>

                        <div class="form-group mtop-15">
                            <label>{{__('site.address-en')}} <small class="text-danger">*</small></label>
                            <input type="text" name="en_address" class="SpecificInput" >
                        </div>

                        <div class="form-group mtop-15">
                            <label>{{__('site.address-ar')}} <small class="text-danger">*</small></label>
                            <input type="text" name="ar_address" class="SpecificInput" >
                        </div>
                        <div class="form-group mtop-15">
                            <label>{{__('site.phone')}} <small class="text-danger">*</small></label>
                            <input type="tel" name="phone" class="SpecificInput" >
                        </div>

                        <div class="form-group mtop-15">
                            <label>{{__('site.email')}} <small class="text-danger">*</small></label>
                            <input type="email" name="gmail" class="SpecificInput" >
                        </div>

                        <div class="form-group mtop-15">
                            <label>{{__('site.logo')}} <small class="text-danger">*</small></label>
                            <input type="file" name="logo" class="SpecificInput">
                        </div>
                    </div>

                </div>
            </div>
            <div id="maintenance_center"  style="display: none">
                @include('forms.maintenance_center')
            </div>
            <div class="submit {{app()->getLocale() == 'ar' ? 'text-left' : 'text-right'}}">
                <input type="submit" name="submit" class="btn btn-primary big-button"
                       value="{{app()->getLocale() == 'ar' ? 'التسجيل ' : 'Register'}}">
            </div>
        </form>
    </div>
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
                // $('.third').remove();
                // $('.fourth').remove();
            }
            if ($(this).val() == '6') {
                $('.six').slideDown();
                // $('.third').remove();
                // $('.fourth').remove();
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
