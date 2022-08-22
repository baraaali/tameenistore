@extends( 'Cdashboard.layout.app' )
@section('controlPanel' )


    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>
@include('dashboard.layout.message')
    <div class="card" id="copy_div" style="padding:15px;display: none">
{{--        <div class="card-heading">--}}
{{--            <input type="checkbox" name="model_id[]" onclick="copy()" id="copy" >--}}
{{--              <span>{{__('site.copy')}}</span>--}}
{{--            <hr>--}}
{{--            <div class="row copy_row">--}}
{{--                <div class="col-md-3">--}}
{{--                    <label class="d-block">--}}
{{--                        @if(app()->getLocale() == "ar")--}}
{{--                        سعر الشريحة الاولي--}}
{{--                        @else--}}
{{--                        Start Price First Slide--}}
{{--                        @endif--}}
{{--                        </label>--}}
{{--                    <input type="number" step=".0001" name="firstSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-4">--}}
{{--                            <label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>--}}
{{--                                <input class="SpecificInput" type="number" step=".0001" name="OpenFileFirstSlide[]">--}}
{{--                                </div>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>--}}
{{--                                <input type="number" step=".0001" name="OpenFilePerecentFirstSlide[]" class="SpecificInput">--}}
{{--                                '</div>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <label> @if(app()->getLocale() == "ar") الحد الادني @else  Minimum Price  @endif </lable>--}}
{{--                                <input type="number" step=".0001" name="OpenFileFirstSlideMin[]" class="SpecificInput" placeholder="@if(app()->getLocale() == "ar" ) الحد الادني @else Minimum Price @endif">--}}
{{--                                </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <label class="d-block">--}}
{{--                        @if(app()->getLocale() == "ar")--}}
{{--                        سعر الشريحة الثانية--}}
{{--                        '@else'--}}
{{--                        Start Price Second Slide--}}
{{--                        @endif--}}
{{--                      </label>--}}
{{--                    <input type="number" step=".0001" name="SecondSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>--}}
{{--                                <input class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide[]">--}}
{{--                                </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>--}}
{{--                                <input type="number" step=".0001"  name="OpenFilePerecentSecondSlide[]" class="SpecificInput">--}}
{{--                                </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <label class="d-block">--}}
{{--                        @if(app()->getLocale() == "ar")--}}
{{--                            سعر الشريحة الثالثة--}}
{{--                            '@else'--}}
{{--                        Start Price Third Slide--}}
{{--                        @endif--}}
{{--                    </label>--}}
{{--                    <input type="number" step=".0001" name="SecondSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>--}}
{{--                                <input class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide[]">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>--}}
{{--                                <input type="number" step=".0001"  name="OpenFilePerecentSecondSlide[]" class="SpecificInput">--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <label class="d-block">--}}
{{--                        @if(app()->getLocale() == "ar")--}}
{{--                            سعر الشريحة الرابعه--}}
{{--                            @else--}}
{{--                        Start Price Forth Slide--}}
{{--                        @endif--}}
{{--                    </label>--}}
{{--                    <input type="number" step=".0001" name="SecondSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>--}}
{{--                                <input class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide[]">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>--}}
{{--                                <input type="number" step=".0001"  name="OpenFilePerecentSecondSlide[]" class="SpecificInput">--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                </div>--}}
{{--            <br>--}}
{{--            <hr>--}}

{{--            </div>--}}
    </div>
    <div class="card" style="padding:15px;">
        <div class="card-heading">
            <form action="{{route('add_brand_to_doc')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id" value="{{$document->id}}">
                    <input type="hidden" name="company_name" id="company_name" value="{{$document->Insurance_Company_ar}}">
                    <div class="text-center">
                        <div class="row te">
                            <div class="col-md-4"></div>
                            <div class="form-group col-md-4 text-center">
{{--                                <label >--}}
{{--                                    {{ __('site.brand') }}--}}
{{--                                </label>--}}
                                <?php $brands = \App\brands::get(); ?>
                                <select class="SpecificInput select2 brandChange btn btn-secondary" name="brand_id">

                                    <option selected disabled>
                                        @if(app()->getLocale() == 'ar')

                                            إختر نوع البراند

                                        @else

                                            Choose brand name

                                        @endif
                                    </option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="nameOfDoc" value="@isset($document){{$document->id}}@endisset">
                            </div>
                            <div class="col-md-8">

                            </div>

                        </div>

                    </div>
                    <div class="container-fluid models">

                    </div>

                </div>
                <div class="text-center">
                    <input type="submit" name="submit" class="btn btn-primary text-center" value=" {{ __('site.save') }}">
                </div>
            </form>

        </div>
    </div>
        <script>
            $(document).ready(function () {
                $('.brandChange').change(function () {
                    id = $(this).val();
                    comp_name = $('#company_name').val();
                    //alert(comp_name);
                    $.ajax({
                        url: "{{url('/')}}/view/models/" + $(this).val()+'/'+comp_name,
                        context: document.body
                    }).done(function (data) {
                        //<input type="hidden" name="brand_id[]" value="'+id+'">
                        $("#copy_div").css("display", "block");
                        $.each(data, function (i, item) {
                            $(".models").append(
                                '<div class="card" style="padding:15px;">' +
                                '<div class="card-heading">' +
                                '<input type="checkbox" name="model_id[]" onclick="copy('+item.id+')" value="' + item.id + '" > ' + item.name +
                                '<hr>' +
                                '<div class="row past_' + item.id + '">' +
                                '<div class="col-md-3">' +
                                '<label class="d-block">' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة الاولي' +
                                '@else' +
                                'Start Price First Slide' +
                                '@endif' +
                                '</label>' +
                                '<input type="number" step=".0001" name="firstSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">' +
                                '<div class="row">' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>' +
                                '<input class="SpecificInput" type="number" step=".0001" name="OpenFileFirstSlide[]">' +
                                '</div>' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>' +
                                '<input type="number" step=".0001" name="OpenFilePerecentFirstSlide[]" class="SpecificInput">' +
                                '</div>' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") الحد الادني @else  Minimum Price  @endif </lable>' +
                                '<input type="number" step=".0001" name="OpenFileFirstSlideMin[]" class="SpecificInput" placeholder="@if(app()->getLocale() == "ar" ) الحد الادني @else Minimum Price @endif">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<label class="d-block">' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة الثانية' +
                                '@else' +
                                'Start Price Second Slide' +
                                '@endif' +
                                '</label>' +
                                '<input type="number" step=".0001" name="SecondSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">' +
                                '<div class="row">' +
                                '<div class="col-md-6">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>' +
                                '<input class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide[]">' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>' +
                                '<input type="number" step=".0001"  name="OpenFilePerecentSecondSlide[]" class="SpecificInput">' +
                                '</div>' +

                                '</div>' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<label class="d-block">' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة  الثالثة' +
                                '@else' +
                                'Start Price third Slide' +
                                '@endif' +
                                '</label>' +
                                '<input type="number" step=".0001" name="thirdSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">' +
                                '<div class="row">' +
                                '<div class="col-md-6">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>' +
                                '<input class="SpecificInput" step=".0001" type="number" name="OpenFileThirdSlide[]">' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>' +
                                '<input type="number" step=".0001" name="OpenFilePerecentThirdSlide[]" class="SpecificInput">' +
                                '</div>' +

                                '</div>' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<label class="d-block">' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة  الرابعة' +
                                '@else' +
                                'Start Price fourth Slide' +
                                '@endif' +
                                '</label>' +
                                '<input type="number" name="fourthSlidePrice[]" class="SpecificInput" style="margin-bottom:15px;">' +
                                '<div class="row">' +
                                '<div class="col-md-6">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </lable>' +
                                '<input class="SpecificInput" step=".0001" type="number" name="OpenFileFourthSlide[]">' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </lable>' +
                                '<input type="number" step=".0001" name="OpenFilePerecentFourthSlide[]" class="SpecificInput">' +
                                '</div>' +

                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<br>' +
                                '<hr>' +

                                '</div>'
                            );

                        });

                    });
                });
            });

            function addmoreAddons() {


                $('.addons').append(
                    '<div class="row deleting">' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    'إسم الشرط' +
                    '@else' +
                    'Term name' +
                    '@endif' +
                    '</label>' +
                    '<input type="text" class="SpecificInput" name="AddonNameAR[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    'إسم الشرط باللغة الانجليزية' +
                    '@else' +
                    'Term name In English' +
                    '@endif' +


                    '</label>' +
                    '<input type="text" class="SpecificInput" name="AddonNameEn[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    'حد أدني للسنين' +
                    '@else' +
                    'Minimum Years' +
                    '@endif' +
                    '</label>' +
                    '<input type="text" class="SpecificInput" name="AddonMaxYear[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    'حد أقصي للمجهول' +
                    '@else' +
                    'An unknown maximum' +
                    '@endif' +
                    '<button type="button" class="btn btn-danger deleteTerm" onclick="DeleteAddosn(this)" style="float:{{app()->getLocale() == "ar" ? "left" : "right"}}" > <i class="fa fa-trash text-white"></i></button>' +
                    '</label>' +
                    '<input type="text" class="SpecificInput" name="AddonUnkownMaxmum[]">' +
                    '</div>' +
                    '</div>'
                );
            }


            function addmoreFeatures() {
                $('.features').append(
                    '<div class="row deletingFeature">' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    'إسم الاضافة بالعربية' +
                    '@else' +
                    'Arabic Feature Name' +
                    '@endif' +
                    '</label>' +
                    '<input class="SpecificInput" type="text" name="FeatureNameAr[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    ' إسم الاضافة بالانجليزية' +
                    '@else' +
                    'English Feature Name' +
                    '@endif' +
                    '</label>' +
                    '<input class="SpecificInput" type="text" name="FeatureNameEn[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    ' سعر الاضافة  ' +
                    '@else' +
                    'Feature Cost' +
                    '@endif' +
                    '<button type="button" class="btn btn-danger deleteTerm" onclick="DeleteFeature(this)" style="float:{{app()->getLocale() == "ar" ? "left" : "right"}}" > <i class="fa fa-trash text-white"></i></button>' +
                    '</label>' +
                    '<input class="SpecificInput" type="number" step=".0001" name="FeatureCost[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label class="d-block">' +
                    '@if(app()->getLocale() == "ar")' +
                    'ملاحظات' +
                    '@else' +
                    'Notices' +
                    '@endif' +
                    '</label>' +
                    '<input  class="SpecificInput" type="text" name="FeatureNotices[]">' +
                    '</div>' +
                    '</div>'
                );
            }

            function DeleteAddosn(button) {
                $(button).closest('.deleting').remove();
            }

            function DeleteFeature(button) {
                $(button).closest('.deletingFeature').remove();
            }

            // function copy(id){
            // //    var content = $('.copy_row').html();
            // //     $(".past_"+id).innerHTML(content);
            // // }
        </script>
@endsection
