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

    <div class="card-body"
         style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">

        <div class="form-body">
            <form method="POST" action="{{route('inDocument-Update')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="insurance_id" value="{{$document->id}}">

                <div class="row">

                    <div class="form-group col-md-4">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                نوع الاستخدام
                            @else
                                type of use
                            @endif
                        </label> <small class="text-danger">
                            عند إختيار نوع الاستخدام سيتم الاخيار علي جميع الموديلات
                        </small>

                        <select class="SpecificInput" name="type_of_use">
{{--                            @if(app()->getLocale() == 'ar')--}}
                                <option value="private" {{$document->type_of_use == 'private' ? 'selected' : ''}}>
                                    {{__('site.private')}}
                                </option>
                                <option value="rent" {{$document->type_of_use == 'rent' ? 'selected' : ''}}>
                                    {{__('site.rent')}}
                                </option>
{{--                            @else--}}

{{--                            @endif--}}

                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                الشعار
                            @else
                                LOGO
                            @endif
                        </label>
                        <input type="file" name="logo" class="SpecificInput">
                        <img src="{{url('/')}}/uploads/{{$document->logo}}" style="width:auto;height:150px"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                اسم شركه التامين بالعربيه
                            @else
                                Insurance Company Name In Arabic
                            @endif
                        </label>
                        <input type="text" name="Insurance_Company_ar" value="{{$document->Insurance_Company_ar}}"
                               class="SpecificInput" max="191">
                    </div>
                    <div class="form-group col-md-4">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                اسم شركه التامين بالانجليزيه
                            @else
                                Insurance Company Name in English
                            @endif
                        </label>
                        <input type="text" name="Insurance_Company_en" value="{{$document->Insurance_Company_en}}"
                               class="SpecificInput" max="191">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                رسوم توصيل الوثيفة
                            @else
                                Delivery Fee
                            @endif
                        </label>
                        <input type="number" name="deliveryFee" value="{{$document->deliveryFee}}" class="SpecificInput"
                               max="191">
                    </div>
                    <div class="col-md-4"></div>
                    <div class="form-group col-md-2">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                الحاله
                            @else
                                Status
                            @endif
                        </label>
                        <select name="status" class="form-group form-control">
                            <option value="0" @if ($document->status==0) selected @endif>{{__('site.not_active')}}</option>
                            <option value="1"  @if ($document->status==1) selected @endif>{{__('site.active')}}</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                شروط الوثيقه بالعربية<small class="text-danger">*</small>

                            @else
                                Terms in Arabic  <small class="text-danger">*</small>
                            @endif
                        </label>

                        <input type="text" required="required" value="{{$document->ar_term}}" name="ar_term"
                               maxlength="191" class="SpecificInput">
                    </div>
                    <div class="form-group col-md-6">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                شروط الوثيقة بالانجليزية  <small class="text-danger">*</small>
                            @else
                                Terms in English  <small class="text-danger">*</small>
                            @endif
                        </label>

                        <input type="text" required="required" value="{{$document->en_term}}" name="en_term"
                               maxlength="191" class="SpecificInput">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                نسبة الخصم % <small class="text-danger">*</small>
                            @else
                                Discount's percentage  <small class="text-danger">*</small>
                            @endif
                        </label>
                        <label>

                        </label>
                        <input type="tel" name="precent" value="{{$document->precent}}" maxlength="191"
                               class="SpecificInput">
                    </div>
                    <div class="form-group col-md-3">
                        <label>
                            @if(app()->getLocale() == 'ar')
                                قيمة الخصم<small class="text-danger">*</small>
                            @else
                                Discount's Value  <small class="text-danger">*</small>
                            @endif
                        </label>

                        <input type="tel" name="discount_q" value="{{$document->discount_q}}" maxlength="191"
                               class="SpecificInput">
                    </div>
                    <div class="form-group col-md-3">

                        <label>
                            @if(app()->getLocale() == 'ar')

                                تاريخ بداية الخصم<small class="text-danger">*</small>
                            @else
                                Discount's Start Date<small class="text-danger">*</small>
                            @endif
                        </label>
                        <input type="date" name="start_disc" value="{{$document->start_disc}}" maxlength="191"
                               class="SpecificInput">
                    </div>
                    <div class="form-group col-md-3">
                        <label>
                            @if(app()->getLocale() == 'ar')

                                تاريخ نهاية الخصم <small class="text-danger">*</small>
                            @else
                                Discount's Start Date<small class="text-danger">*</small>
                            @endif
                        </label>

                        <input type="date" name="end_disc" value="{{$document->end_disc}}" maxlength="191"
                               class="SpecificInput">
                    </div>
                </div>

                <hr>

                <div class="form-group">

                    <div class="text-center">


{{--                        <div class="row">--}}
{{--                            <div class="form-group col-md-2">--}}
{{--                                <label>--}}
{{--                                    @if(app()->getLocale() == 'ar')--}}
{{--                                        البراند--}}
{{--                                    @else--}}
{{--                                        Brand--}}
{{--                                    @endif--}}
{{--                                </label>--}}
{{--                                <?php $brands = \App\brands::get(); ?>--}}
{{--                                <select name="brand_id" class="SpecificInput select2 brandChange">--}}
{{--                                    @foreach($brands as $brand)--}}
{{--                                        <option--}}
{{--                                            value="{{$brand->id}}" {{$brand->id == $document->brand_id ? 'selected' : ''}} >{{$brand->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-2">--}}
{{--                                <label>--}}
{{--                                    @if(app()->getLocale() == 'ar')--}}
{{--                                        الموديل--}}
{{--                                    @else--}}
{{--                                        Brand--}}
{{--                                    @endif--}}
{{--                                </label>--}}
{{--                                <?php $models = \App\models::where('brand_id', $document->brand_id)->get(); ?>--}}
{{--                                <select name="model_id" class="SpecificInput select2 brandChange">--}}
{{--                                    @foreach($models as $model)--}}
{{--                                        <option--}}
{{--                                            value="{{$model->id}}" {{$model->id == $document->model_id ? 'selected' : ''}} >{{$model->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-2">--}}
{{--                                <label>--}}
{{--                                    @if(app()->getLocale() == 'ar')--}}
{{--                                        السعر--}}
{{--                                    @else--}}
{{--                                        Price--}}
{{--                                    @endif--}}
{{--                                </label>--}}
{{--                                <input type="text" name="price" value="{{$document->price}}" class="SpecificInput">--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-2">--}}
{{--                                <label>--}}
{{--                                    @if(app()->getLocale() == 'ar')--}}
{{--                                        الفترة الاولي--}}
{{--                                    @else--}}
{{--                                        First Interval--}}
{{--                                    @endif--}}
{{--                                </label>--}}
{{--                                <input type="text" name="firstinterval" value="{{$document->firstinterval}}"--}}
{{--                                       class="SpecificInput">--}}
{{--                            </div>--}}

{{--                            <div class="form-group col-md-2">--}}
{{--                                <label>--}}
{{--                                    @if(app()->getLocale() == 'ar')--}}
{{--                                        الفترة  الثانية--}}
{{--                                    @else--}}
{{--                                        Second Interval--}}
{{--                                    @endif--}}
{{--                                </label>--}}
{{--                                <input type="text" name="secondinterval" value="{{$document->secondinterval}}"--}}
{{--                                       class="SpecificInput">--}}
{{--                            </div>--}}


{{--                            <div class="form-group col-md-2">--}}
{{--                                <label>--}}
{{--                                    @if(app()->getLocale() == 'ar')--}}
{{--                                        الفترة الثالثة--}}
{{--                                    @else--}}
{{--                                        Third Interval--}}
{{--                                    @endif--}}
{{--                                </label>--}}
{{--                                <input type="text" name="thirdinterval" value="{{$document->thirdinterval}}"--}}
{{--                                       class="SpecificInput">--}}
{{--                            </div>--}}


{{--                        </div>--}}

                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if(app()->getLocale() == 'ar')
                        <input type="submit" name="submit" class="btn btn-primary" value="حفظ">
                    @else
                        <input type="submit" name="submit" class="btn btn-primary" value="Save">
                    @endif
                </div>
            </form>

        </div>


    </div>



@endsection
