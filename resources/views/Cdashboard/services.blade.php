@extends('Cdashboard.layout.app')
@section('controlPanel')


    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    $name2=$lang=='ar'?'name_ar':'name_en';
    ?>
    @if(app()->getLocale() == 'ar')

        <style>
            .form-group {
                direction: rtl;
                text-align: right !important;
            }
        </style>

    @else
    <style>
            .form-group {
                direction: ltr;
                text-align: left !important;
            }
        </style>
    @endif
    <style>
        label {
            display: block;
        }

        .select2-container--default .select2-selection--single {
            width: 272px;
        }
    </style>
    <div class="col-lg-12">
        @include('dashboard.layout.message')
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">

                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative;display: inline-block;top: 6px;">{{__('site.new_module')}}</h5>
                                <a href="{{route('addServices',app()->getLocale())}}" class="btn btn-light circle">
                                    <i class="fas fa-plus-circle"></i>
                                    {{__('site.add_new')}}
                                </a>
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <label style="display: block">{{__('site.all_serviecs')}}</label>
                                <br>

                                <table class="table table-stroped table-responsive ">
                                    <thead class="bg-light ">
                                    @if(app()->getLocale() == 'ar')
                                        <td>
                                            رقم
                                        </td>
                                        <td>
                                            الدولة - المنطقة
                                        </td>
                                        <td>الاسم بالعربى</td>
                                        <td>
                                            الحاله
                                        </td>
                                        <td>
                                            السعر
                                        </td>
                                        <td>
                                            تاريخ الانتهاء
                                        </td>
                                        <td>العضويه</td>
                                        <td>
                                            العمليات
                                        </td>
                                    @else
                                        <td>
                                            No.
                                        </td>
                                        <td>
                                            City-Region
                                        </td>

                                        <td>
                                            status
                                        </td>
                                        <td>
                                            Price
                                        </td>
                                        <td>
                                            end date
                                        </td>
                                        <td>Membership</td>
                                        <td>
                                            Operations
                                        </td>
                                    @endif
                                    </thead>
                                    <tbody>
                                
                                    @foreach($rows as $key=>$row)
                                        <tr>
                                            <td>
                                                {{$key + 1}}
                                            </td>
                                            <td>
                                                <button class="btn btn-dark btn-xs">
                                                    {{$row->country->ar_name}}
                                                </button>
                                            </td>
                                            <td>{{$row->name_ar}}</td>
                                            <td>@if($row->status==0)
                                                 {{__('site.not_active')}}
                                                 @else {{__('site.active')}}
                                            @endif</td>
                                            <td>
                                                <button class="btn btn-success btn-xs">
                                                    {{$row->price}} 
                                                </button>
                                            </td>

                                            <td>
                                                {{$row->end_date}}
                                            </td>
                                            <td>
                                                @if($row->type==0){{__('site.normal')}}
                                                @elseif($row->type==1){{__('site.silver')}}
                                                @elseif($row->type==2){{__('site.special')}}
                                                @else($row->type==3){{__('site.golden')}}
                                                @endif
                                            </td>
                                            <td>
                                                
                                                <a href="{{route('editServices',[$row->id,app()->getLocale()])}}"
                                                   class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i> تعديل
                                                </a>
                                                <a href="#" class="btn btn-success btn-xs" data-toggle="modal"
                                                   data-target="#exampleModal{{$row->id}}">
                                                    <i class="fas fa-sync"></i> تجديد
                                                </a>

                                                <a onclick="return confirm('Are you sure?')"
                                                   href="{{route('deleteServices',$row->id)}}"
                                                   class="btn btn-danger">
                                                    <i class="fa fa-trash text-white"></i> حذف
                                                </a>
                                                <div class="modal fade" id="exampleModal{{$row->id}}" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel{{$row->id}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h5 class="modal-title" id="exampleModalLabel">{{__('site.renew')}}</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('renewServices')}}" method="post">
                                @csrf
                                <input type="hidden" id="cash" value="" name="cash">
                                <input type="hidden" id="ad" value="{{$row->id}}" name="ad">
                                <div class="form-group col-md-12">
                                    <label>{{__('site.ads_type')}}

                                    </label>
                                    <select name="special" class="SpecificInput change_member" id="special">
                                        <option>{{__('site.select')}}</option>
                                        @foreach(\App\NewServiceMembership::get() as $price)
                                            <option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->$name2}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="submit"  class="SpecificInput btn btn-primary" name="{{__('site.send')}}" >
                                </div>

                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                    data-dismiss="modal">{{__('site.close')}}
                            </button>

                        </div>

                    </div>
                </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- E3lanat create Modal -->
{{--     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if(app()->getLocale() == 'ar')
                        <h5 class="modal-title" id="exampleModalLabel">إنشاء إعلان</h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">Make Advertisment</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body"
                         style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                        <div class="form">

                            <form method="POST" action="{{route('Ads-store')}}" enctype="multipart/form-data">
                                @csrf
                                <nav>
                                    @if(app()->getLocale() == 'ar')
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                               href="#nav-home" role="tab" aria-controls="nav-home"
                                               aria-selected="true">معلومات رئيسية</a>
                                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                               href="#nav-profile" role="tab" aria-controls="nav-profile"
                                               aria-selected="false">خصائص ا السيارة</a>
                                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                               href="#nav-contact" role="tab" aria-controls="nav-contact"
                                               aria-selected="false">صفات السيارة</a>
                                            <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab"
                                               href="#nav-price" role="tab" aria-controls="nav-price"
                                               aria-selected="false">إسعار السيارة</a>
                                        </div>
                                    @else
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                               href="#nav-home" role="tab" aria-controls="nav-home"
                                               aria-selected="true">Main Information</a>
                                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                               href="#nav-profile" role="tab" aria-controls="nav-profile"
                                               aria-selected="false">Car Propreties</a>
                                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                               href="#nav-contact" role="tab" aria-controls="nav-contact"
                                               aria-selected="false">Car Shape</a>
                                            <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab"
                                               href="#nav-price" role="tab" aria-controls="nav-price"
                                               aria-selected="false">Car Price</a>
                                        </div>
                                    @endif
                                </nav>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                         aria-labelledby="nav-home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            الدولة - المنطقة  <small class="text-danger">*</small>
                                                        @else
                                                            Country-Region <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <select class="SpecificInput select2" dir="rtl" name="country_id"
                                                            required>
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}">
                                                                {{$country->ar_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            الاسم بالعربي  <small class="text-danger">*</small>
                                                        @else
                                                            Name In Arabic <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" required name="ar_name" max="191"
                                                           class="SpecificInput">
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            البراند <small class="text-danger">*</small>
                                                        @else
                                                            Brand <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <select class="SpecificInput brandChange select2" name="ar_brand">
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}">
                                                                {{$brand->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            الموديل  <small class="text-danger">*</small>
                                                        @else
                                                            Model <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <select class="SpecificInput modelChange select2" name="ar_model">
                                                        @foreach($models as $model)
                                                            <option value="{{$model->id}}">
                                                                {{$model->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            الاسم  الانجليزية  <small class="text-danger">*</small>
                                                        @else
                                                            Name In English <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" name="en_name" max="191" required
                                                           class="SpecificInput">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                         aria-labelledby="nav-profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            ا سنة الصنع  <small class="text-danger">*</small>
                                                        @else
                                                            Year <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" name="year" max="191" class="SpecificInput">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            اللون  <small class="text-danger">*</small>
                                                        @else
                                                            Color<small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" name="color" max="191" class="SpecificInput">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            بيع / ايجار   <small class="text-danger">*</small>
                                                        @else
                                                            Sell / Rent <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <select class="SpecificInput" name="sell">
                                                        @if(app()->getLocale() == 'ar')
                                                            <option value="1">
                                                                بيع
                                                            </option>
                                                            <option value="0">
                                                                ايجار
                                                            </option>
                                                        @else
                                                            <option value="1">
                                                                Sell
                                                            </option>
                                                            <option value="0">
                                                                Rent
                                                            </option>
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            أقصي سرعة للسيارة  <small class="text-danger">*</small>
                                                        @else
                                                            Max Speed<small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" name="maxSpeed" max="191" class="SpecificInput">
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            ناقل الحركة  <small class="text-danger">*</small>
                                                        @else
                                                            Transmission<small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <select class="SpecificInput" name="transmission">
                                                        @if(app()->getLocale() == 'ar')
                                                            <option value="0">
                                                                عادي
                                                            </option>
                                                            <option value="1">
                                                                اوتوماتيك
                                                            </option>
                                                        @else
                                                            <option value="0">
                                                                Manual
                                                            </option>
                                                            <option value="1">
                                                                Auatomatic
                                                            </option>
                                                        @endif
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            الوقود  <small class="text-danger">*</small>
                                                        @else
                                                            Fuel Type <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" name="fuel" max="191" class="SpecificInput">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            حالة  السيارة <small class="text-danger">*</small>
                                                        @else
                                                            Car Condition <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <select class="SpecificInput" name="used">
                                                        @if(app()->getLocale() == 'ar')
                                                            <option value="0">
                                                                جديدة
                                                            </option>
                                                            <option value="1">
                                                                مستعملة
                                                            </option>
                                                        @else
                                                            <option value="0">
                                                                New
                                                            </option>
                                                            <option value="1">
                                                                Used
                                                            </option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            مطلوب \ معروض<small class="text-danger">*</small>
                                                        @else
                                                            Required / Offered <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <select class="SpecificInput" name="talap">
                                                        @if(app()->getLocale() == 'ar')
                                                            <option value="1">
                                                                مطلوب
                                                            </option>
                                                            <option value="0">
                                                                معروض
                                                            </option>
                                                        @else
                                                            <option value="1">
                                                                Required
                                                            </option>
                                                            <option value="0">
                                                                Offered
                                                            </option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            حعدد الكيلو مترات<small class="text-danger">*</small>
                                                        @else
                                                            KM ? <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" name="kilometers" max="191"
                                                           class="SpecificInput">
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            المحرك <small class="text-danger">*</small>
                                                        @else
                                                            Motor Type <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="text" placeholder="1600" name="engine" max="191"
                                                           class="SpecificInput">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                         aria-labelledby="nav-contact-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            وصف السيارة باعربية  <small class="text-danger">*</small>
                                                        @else
                                                            Car Descript <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <textarea class="SpecificInput" required
                                                              name="ar_description"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            مميزات السيارة بالعربية  <small
                                                                class="text-danger">*</small>
                                                        @else
                                                            Car Features <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <textarea class="SpecificInput" name="ar_features"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            وصف السيارة  بالانجليزية   <small
                                                                class="text-danger">*</small>
                                                        @else
                                                            Car Description In English <small
                                                                class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <textarea class="SpecificInput" required
                                                              name="en_description"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            ومميزات السيارة  بالانجليزية  <small
                                                                class="text-danger">*</small>
                                                        @else
                                                            Car Features In English <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <textarea class="SpecificInput" name="en_features"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            صور السيارة <small class="text-danger">*</small>
                                                        @else
                                                            Car Image <small class="text-danger">*</small>
                                                        @endif
                                                    </label>
                                                    <input type="file" multiple required class="SpecificInput uploader"
                                                           name="images[]" accept="image/*">
                                                    <div class="uploadedimages">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-price" role="tabpanel"
                                         aria-labelledby="nav-price-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <div class="form-group col-md-6">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                السعر<small class="text-danger">*</small>
                                                            @else
                                                                Car Price <small class="text-danger">*</small>
                                                            @endif
                                                        </label>
                                                        <input type="number" required class="SpecificInput" name="cost">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                هل تريد عمل خصم قيمة ؟
                                                            @else
                                                                Do you want to make an offer ?
                                                            @endif
                                                        </label>
                                                        <input type="number" class="SpecificInput"
                                                               name="discount_amount">
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="form-group col-md-6">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                ههل تريد عمل خصم  نسبة ؟
                                                            @else
                                                                Do you want to make an offer in precentage ?
                                                            @endif
                                                        </label>
                                                        <input type="number" class="SpecificInput"
                                                               name="discount_percent">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                تحديد وقت بدأ الخصومات ؟
                                                            @else
                                                                Start Offers In
                                                            @endif
                                                        </label>
                                                        <input type="date" class="SpecificInput"
                                                               name="discount_start_date">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                ت     تحديد وقت   نهاية الخصومات ؟
                                                            @else
                                                                End Offers In
                                                            @endif
                                                        </label>

                                                        <input type="date" class="SpecificInput"
                                                               name="discount_end_date">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label>
                                                            @if(app()->getLocale() == 'ar')
                                                                ت نوع الاعلان
                                                            @else
                                                                Ads. Type
                                                            @endif
                                                        </label>
                                                        <select class="SpecificInput select2" name="special">
                                                            <option value="0">
                                                                عادي
                                                            </option>
                                                            <option value="1">
                                                                مفضل
                                                            </option>
                                                            <option value="2">
                                                                فضي
                                                            </option>
                                                            <option value="3">
                                                                مميز
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="modal-footer">
                                    @if(app()->getLocale() == 'ar')
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق
                                        </button>
                                        <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                                    @else
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <input type="submit" name="submit" class="btn btn-primary" value="save">
                                    @endif
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------- E3lanat Edit Modal !---------->
    @foreach($rows as $key=>$row)
        <div class="modal fade" id="exampleModal{{$row->id}}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModal2/{{$row->id}}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">تعديل بيانات الإعلان</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body"
                             style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                            <div class="form">


                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach


    <script>
        $(document).ready(function () {
            $('.brandChange').change(function () {
                $.ajax({
                    url: "{{url('/')}}/view/childerns/" + $(this).val(),
                    context: document.body
                }).done(function (data) {
                    $('.modelChange').find('option').remove().end();
                    $.each(data, function (i, item) {
                        $('.modelChange').append('<option value="' + item.id + '">' + item.name + '</optin>')
                    });

                });
            });
            //
            $('.change_member , #number_days').change(function () {
                var price = $('.change_member').children(':selected').data('url');
                if (price==null) {
                    alert('من فضلك اختر العضويه');
                    return false;
                }
                var days = $('#number_days').val();
                if (days < 1) {
                    alert('من فضلك ادخل عدد ايام صحيح');
                    return false;
                }
                total = days * price;
                $('#show_price').text("سيتم خصم مبلغ  " + total + "$ من رصيدك ");
                $('#cash').val(price);
            });

        });
    </script> --}}

@endsection


