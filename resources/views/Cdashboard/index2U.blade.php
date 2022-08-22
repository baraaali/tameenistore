@extends('Cdashboard.layout.app')
@section('controlPanel')


    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

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
    @include('dashboard.layout.message')
    <div class="col-lg-12">

        <div class="row">

            <div class="col-lg-12">
                @if(app()->getLocale() == 'ar')
                    <h5 class="modal-title" id="exampleModalLabel">تعديل إعلان : {{$Ads->ar_name}}</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Edit Advertisment : {{$Ads->en_name}}</h5>
                @endif
                <div class="card-body"
                     style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                    <div class="form">
                        <form method="POST" action="{{route('Ads-update')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$Ads->id}}">
                            <nav>
                                @if(app()->getLocale() == 'ar')
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                           href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false">معلومات
                                            رئيسية</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                           href="#nav-profile" role="tab" aria-controls="nav-profile"
                                           aria-selected="false">خصائص ا السيارة</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                           href="#nav-contact" role="tab" aria-controls="nav-contact"
                                           aria-selected="false">صفات السيارة</a>
                                        <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab"
                                           href="#nav-price" role="tab" aria-controls="nav-price" aria-selected="false">إسعار
                                            السيارة</a>
                                    </div>
                                @else
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                           href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false">Main
                                            Information</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                           href="#nav-profile" role="tab" aria-controls="nav-profile"
                                           aria-selected="false">Car Propreties</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                           href="#nav-contact" role="tab" aria-controls="nav-contact"
                                           aria-selected="false">Car Shape</a>
                                        <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab"
                                           href="#nav-price" role="tab" aria-controls="nav-price" aria-selected="false">Car
                                            Price</a>
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
                                                        <option
                                                            value="{{$country->id}}" {{$Ads->country_id == $country->id ? 'selected' : '' }}>
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
                                                       value="{{$Ads->ar_name}}" class="SpecificInput">
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
                                                        <option
                                                            value="{{$brand->id}}" {{$Ads->ar_brand == $brand->id ? 'selected' : '' }}>
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
                                                        <option
                                                            value="{{$model->id}}" {{$Ads->ar_model == $model->id ? 'selected' : '' }}>
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
                                                <input type="text" name="en_name" max="191" value="{{$Ads->en_name}}"
                                                       required class="SpecificInput">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('site.main_image')}}</label>
                                                <img src="{{asset('uploads/'.$Ads->main_image)}}" alt="" class="img-thumbnail"
                                                style="height: 100px;width: 100px">
                                                <input type="file" name="main_image"  class="SpecificInput">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        صور السيارة <small class="text-danger">*</small>
                                                    @else
                                                        Car Image <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                <input type="file" multiple class="SpecificInput uploader"
                                                       name="images[]" accept="image/*">
                                                <div class="uploadedimages">
                                                    @if($Ads->Images)
                                                        <div class="old_images">
                                                            @foreach($Ads->Images as $image)
                                                                <img
                                                                    style="display: inline-block;width: auto;height: 50px;margin: 5px"
                                                                    src="{{url('/')}}/uploads/{{$image->image}}"/>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
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
                                                        سنة الصنع
                                                    @else
                                                        Year
                                                    @endif
                                                </label>
                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="year" value="{{$Ads->year}}" max="191"
                                                       class="SpecificInput">
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        اللون
                                                    @else
                                                        Color
                                                    @endif
                                                </label>
                                                <input type="text" name="color" max="191" value="{{$Ads->color}}"
                                                       class="SpecificInput">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('site.rent_sell')}}*</label>
                                                <select class="SpecificInput" name="sell">
                                                    @if(auth()->user()->type!=3)
                                                        <option value="1">{{__('site.sell')}}</option>
                                                    @else
                                                        <option value="0">{{__('site.rent')}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            @if(auth()->user()->type==3)
                                            <div class="form-group">
                                                <?php  $arr=['daily','weekly','monthly','rent_for_have'];?>
                                                <label>{{__('site.rent_type')}}</label>
                                                <select class="SpecificInput" name="rent_type">

                                                        @for($i=0;$i<count($arr);$i++)
                                                            <option value="{{$i+1}}"
                                                            @isset($Ads) @if($Ads->rent_type ==$i+1 ) {{ 'selected' }} @endif @endisset >{{__('site.'.$arr[$i])}}</option>
                                                        @endfor

                                                </select>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        أقصي سرعة للسيارة
                                                    @else
                                                        Max Speed
                                                    @endif
                                                </label>
                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="maxSpeed" value="{{$Ads->max}}" max="191"
                                                       class="SpecificInput">
                                            </div>

                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        ناقل الحركة
                                                    @else
                                                        Transmission
                                                    @endif
                                                </label>
                                                <select class="SpecificInput" name="transmission">
                                                    @if(app()->getLocale() == 'ar')
                                                        <option value="0" {{$Ads->transmission == 0 ? 'selected' : ''}}>
                                                            عادي
                                                        </option>
                                                        <option value="1" {{$Ads->transmission == 1 ? 'selected' : ''}}>
                                                            اوتوماتيك
                                                        </option>
                                                    @else
                                                        <option value="0" {{$Ads->transmission == 0 ? 'selected' : ''}}>
                                                            Manual
                                                        </option>
                                                        <option value="1" {{$Ads->transmission == 1 ? 'selected' : ''}}>
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
                                                        الوقود
                                                    @else
                                                        Fuel Type
                                                    @endif
                                                </label>
                                                <input type="text" value="{{$Ads->fuel}}" name="fuel" max="191"
                                                       class="SpecificInput">
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
                                                    <option value="0" {{$Ads->used == 0 ? 'selected' : ''}}>
                                                        {{__('site.new')}}
                                                    </option>
                                                    <option value="1" {{$Ads->used == 1 ? 'selected' : ''}}>{{__('site.used')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        مطلوب \ معروض
                                                    @else
                                                        Required / Offered
                                                    @endif
                                                </label>
                                                <select class="SpecificInput" name="talap">
                                                    @if(app()->getLocale() == 'ar')
                                                        <option value="1" {{$Ads->talap == 1 ? 'selected' : ''}}>
                                                            مطلوب
                                                        </option>
                                                        <option value="0" {{$Ads->talap == 0 ? 'selected' : ''}}>
                                                            معروض
                                                        </option>
                                                    @else
                                                        <option value="1" {{$Ads->talap == 1 ? 'selected' : ''}}>
                                                            Required
                                                        </option>
                                                        <option value="0" {{$Ads->talap == 0 ? 'selected' : ''}}>
                                                            Offered
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        كيلو متر
                                                    @else
                                                        KM ?
                                                    @endif
                                                </label>

                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{$Ads->kilo_meters}}" name="kilometers"
                                                       max="191" class="SpecificInput">
                                            </div>

                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        المحرك
                                                    @else
                                                        Motor Type
                                                    @endif
                                                </label>
                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{$Ads->engine}}" placeholder="1600"
                                                       name="engine" max="191" class="SpecificInput">
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
                                                          name="ar_description">{!!$Ads->ar_description!!}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        مميزات السيارة بالعربية
                                                    @else
                                                    @endif
                                                </label>
                                                <textarea class="SpecificInput"
                                                          name="ar_features">{!!$Ads->ar_features!!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        وصف السيارة  بالانجليزية
                                                    @else
                                                        Car Description In English
                                                    @endif
                                                </label>
                                                <textarea class="SpecificInput" required
                                                          name="en_description">{!!$Ads->en_description!!}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        ومميزات السيارة  بالانجليزية
                                                    @else
                                                        Car Features In English
                                                    @endif
                                                </label>
                                                <textarea class="SpecificInput"
                                                          name="en_features">{!!$Ads->en_features!!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

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
                                                    <input type="text" value="{{$Ads->Price->cost}}" required
                                                           class="SpecificInput" name="cost">
                                                </div>


                                                <div class="form-group col-md-6">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            هل تريد عمل خصم قيمة ؟
                                                        @else
                                                            Do you want to make an offer ?
                                                        @endif
                                                    </label>
                                                    <input type="text" value="{{$Ads->Price->discount_amount}}"
                                                           class="SpecificInput" name="discount_amount">
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
                                                    <input type="text" value="{{$Ads->Price->discount_percent}}"
                                                           class="SpecificInput" name="discount_percent">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                            تحديد وقت بدأ الخصومات ؟
                                                        @else
                                                            Start Offers In
                                                        @endif
                                                    </label>
                                                    <input type="date" value="{{$Ads->Price->discount_start_date}}"
                                                           class="SpecificInput" name="discount_start_date">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>
                                                        @if(app()->getLocale() == 'ar')
                                                                 تحديد وقت   نهاية الخصومات ؟
                                                        @else
                                                            End Offers In
                                                        @endif
                                                    </label>

                                                    <input type="date" value="{{$Ads->Price->discount_end_date}}"
                                                           class="SpecificInput" name="discount_end_date">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="modal-footer">
                                @if(app()->getLocale() == 'ar')
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                                    <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                                @else
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" name="submit" class="btn btn-primary" value="save">
                                @endif
                            </div>
                        </form>
                    </div>

                </div>


            </div>
        </div>
    </div>

@endsection
