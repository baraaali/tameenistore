@extends('dashboard.layout.app')
@section('content')


    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>
    {{-- <div class="card" id="copy_div" style="padding:15px;display: none"> --}}

    </div>
    <div class="card" style="padding:15px;">
        <div class="card-heading">
            <form action="{{route('add_brand_to_doc')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id" value="{{$document->id}}">
                    <input id="vehicle_id" name="vehicle_id" type="hidden" value="{{$document->vehicle_id}}">
                    <input type="hidden" name="company_name" id="company_name" value="{{$document->Insurance_Company_ar}}">
                    <div class="text-center">
                        <div class="row">
                            <div class="form-group col-md-3">
                                    <label style="font-weight: 600">{{__('site.select_brand')}}  </label>
                                    <select name="brand_id" class="col-lg-12 brandChange exhibtors sty_select select2">
                                        <option value="0" selected>{{__('site.select_brand')}}</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                
                            </div>
                            <div class="form-group col-md-3">
                                    <label style="font-weight: 600">{{__('site.select_model')}}  </label>
                                    <select name="model_id" class="col-lg-12 modelChange exhibtors sty_select select2">
                                        <option value="0" selected>{{__('site.select_model')}}</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                    <label style="font-weight: 600">{{__('site.select_shape')}}  </label>
                                    <select name="car_shape_id" class="col-lg-12 shapeChange select2">
                                        <option value="0" selected>{{__('site.select_shape')}}</option>
                                    </select>
                            </div>
                          <div class="form-group col-md-3">
                            <label for="passengers">{{__('site.passengers number')}} </label>
                            <select name="passengers" class="col-lg-12 passengersChange select2">
                                <option value="0">{{__('site.select')}}</option>
                                @for ($i = 1 ; $i <= 100 ; $i++)
                                <option value="{{$i}}" >{{$i}}</option>
                                @endfor
                            </select>
                          </div>
                          

                            
<input type="hidden" name="nameOfDoc" value="@isset($document){{$document->id}}@endisset">
                      

                        </div>
                        <div class="direction" >
                            <label for="auto-pricing">
                                <input id="auto-pricing" checked type="checkbox" >
                            {{__('site.auto pricing')}}</label>
                            
                        </div>

                    </div>
                    <div id="loader" class="text-center justify-content-center my-4 d-none">
                        <div class="spinner-border text-info"></div>
                    </div>
                    <div id="alert-danger" class="alert alert-danger d-none" role="alert">
                        <strong>{{__('site.brand is required')}}</strong>
                    </div>
                    <div id="alert-success" class="alert alert-success d-none" role="alert">
                        <strong>{{__('site.no data')}}</strong>
                    </div>
                  
                    <div class="text-center">
                        <input id="search-for-models" type="button" class="btn btn-primary text-center w-25" value=" {{ __('site.search') }}">
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-success text-center w-25" value=" {{ __('site.save') }}">
                    </div>
                    <div class="container-fluid models">

                    </div>

                </div>
               
            </form>
        

        </div>
    </div>
 
    
@endsection

@section('js')
    <script>
        var brandChange  = function()
    {
        $('.brandChange').change(function () {
            getShapes()
           $.ajax({
               url: "{{url('/')}}/view/childerns/" + $(this).val(),
               context: document.body
           }).done(function (data) {
               $('.modelChange').find('option').remove().end();
                var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
               $.each(data, function (i, item) {
                html+= '<option value="' + item.id + '">' + item.name + '</optin>'
               });
                $('.modelChange').append(html)
               $('.modelChange').trigger('change')
           });
       });
    }
    var getShapes = function()
     {
         var brand_id = $('.brandChange').val()
         var vehicle_id = $('#vehicle_id').val()
         $.ajax({
               url: "{{url('/')}}/view/get-careshapes/" + vehicle_id + '/' + brand_id,
               context: document.body
           }).done(function (data) {
               $('.shapeChange').find('option').remove().end();
                var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
               $.each(data, function (i, item) {
                html+='<option value="' + item.id + '">' + item.ar_name+' ' + item.en_name+  '</optin>'
               });
                $('.shapeChange').append(html)
             $('.shapeChange').trigger('change')
           });
         
     }

    var search = function(){
        $('#search-for-models').on('click',function(){
           getDocumentModels()
        })
    }
    var showElement = function(idName){
        const $e = $("#"+idName);
        if($e.hasClass("d-none"))
        $e.removeClass("d-none");
    }
    var hideElement = function(idName){
        const $e = $("#"+idName);
        if(!$e.hasClass("d-none"))
        $e.addClass("d-none");
    }
    var setAutoPricingEvent = function(){
        const elements = {};
        elements['firstSlidePrices'] = $('input[name="firstSlidePrice[]"]');
        elements['OpenFileFirstSlides'] = $('input[name="OpenFileFirstSlide[]"]');
        elements['OpenFilePerecentFirstSlide'] = $('input[name="OpenFilePerecentFirstSlide[]"]');
        elements['OpenFileFirstSlideMin'] = $('input[name="OpenFileFirstSlideMin[]"]');

        elements['SecondSlidePrice'] = $('input[name="SecondSlidePrice[]"]');
        elements['OpenFileSecondSlide'] = $('input[name="OpenFileSecondSlide[]"]');
        elements['OpenFilePerecentSecondSlide'] = $('input[name="OpenFilePerecentSecondSlide[]"]');
        
        elements['thirdSlidePrice'] = $('input[name="thirdSlidePrice[]"]');
        elements['OpenFileThirdSlide'] = $('input[name="OpenFileThirdSlide[]"]');
        elements['OpenFilePerecentThirdSlide'] = $('input[name="OpenFilePerecentThirdSlide[]"]');

        elements['fourthSlidePrice'] = $('input[name="fourthSlidePrice[]"]');
        elements['OpenFileFourthSlide'] = $('input[name="OpenFileFourthSlide[]"]');
        elements['OpenFilePerecentFourthSlide'] = $('input[name="OpenFilePerecentFourthSlide[]"]');
   
       const $itemBoxs = $('.item-box');
        $itemBoxs.each((i,$e)=>{
            const $parent = $($e).parent().parent();
            $($e).on('change',function(){
                if($($e).is(':checked'))
                    $parent.find('input').addClass('target_el');
                else
                $parent.find('input').removeClass('target_el');
                
            })
        }) 
 
        const runActions = function(action){
            Object.keys(elements).forEach(key => {
            const $childrens = elements[key]
               $childrens.each((i,$e)=>{
                    if(action == 'input'){
                        $($e).on('input',function(){
                            const value = $(this).val();
                            const data_id = $(this).attr('data-id');
                            $childrens.each((i2,$e2)=>{
                               if($($e2).hasClass("target_el") && data_id != $($e2).attr('data-id'))
                                $($e2).val(Number(value).toFixed(3));
                            })
                }) 
                }else{
                    $($e).off('input')
                    $($e).unbind('input')
                }
            })
         });
        }
        runActions('input');

         $('#auto-pricing').on('change',function(){
            if($('#auto-pricing').is(':checked') )
                runActions('input')
            else{
                runActions('off')
            }
            
         })
 
    }
    $(document).ready(function(){
        brandChange();
       // setAutoPricingEvent();
        search()
    })

    // get Documents models
             function getDocumentModels(){
                    const brand_id =  $('.brandChange').val() ?  $('.brandChange').val() : 0;
                    const model_id =  $('.modelChange').val() ? $('.modelChange').val() : 0;
                    const passengers = $('.passengersChange').val() ? $('.passengersChange').val() : 0;
                    const comp_name = $('#company_name').val() ? $('#company_name').val() : 0;
                    const shape = $('.shapeChange').val() ? $('.shapeChange').val() : 0;
                    hideElement("alert-success");
                    hideElement("alert-danger");
                    $(".models").html('');
                    
                   if(brand_id == 0){
                    showElement("alert-danger")
                   }else{
                    showElement("loader")
                    $.ajax({
                        url: `{{url('/')}}/view/models/${brand_id}/${comp_name}/${model_id}/${shape}/${passengers}`,
                        context: document.body
                    }).done(function (data) {
                        console.log(data);
                        hideElement("loader")
                        if(data.length == 0){
                            showElement("alert-success")
                        }else{
                        $.each(data, function (i, item) {
                            $(".models").append(
                                '<div  class="card p-0 mb-2 shadow-sm">' +
                                '<div class="card-heading">' +
                                '<div class="bg-light p-3">'+
                                '<input class="item-box" id="item_'+item.id+'" type="checkbox" name="model_id[]"  value="' + item.id + '" > ' +'<span style="font-size:18px;font-weight:bold">'+item.name+'</span>' +
                                '</div>'+
                                '<div class="past_' + item.id + '">' +
                             
                                '<div class="row border p-3 m-0">' +
                                    '<div class="col-md-3">' +
                                '<label>' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة الاولي' +
                                '@else' +
                                'Start Price First Slide' +
                                '@endif' +
                                '</label>' +
                                '<input data-id="'+item.id+'" type="number" step=".0001" name="firstSlidePrice[]" class="SpecificInput" >' +
                               
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </label>' +
                                '<input data-id="'+item.id+'" class="SpecificInput" type="number" step=".0001" name="OpenFileFirstSlide[]">' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </label>' +
                                '<input data-id="'+item.id+'"type="number" step=".0001" name="OpenFilePerecentFirstSlide[]" class="SpecificInput">' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<label> @if(app()->getLocale() == "ar") الحد الادني @else  Minimum Price  @endif </label>' +
                                '<input data-id="'+item.id+'"type="number" step=".0001" name="OpenFileFirstSlideMin[]" class="SpecificInput" placeholder="@if(app()->getLocale() == "ar" ) الحد الادني @else Minimum Price @endif">' +
                                '</div>' +
                                '</div>' +

                                '<div class="row border p-3 m-0">' +
                                '<div class="col-md-4">' +
                                '<label>' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة الثانية' +
                                '@else' +
                                'Start Price Second Slide' +
                                '@endif' +
                                '</label>' +
                                '<input data-id="'+item.id+'"type="number" step=".0001" name="SecondSlidePrice[]" class="SpecificInput" >' +
    
                                '</div>' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </label>' +
                                '<input data-id="'+item.id+'"class="SpecificInput" step=".0001" type="number" name="OpenFileSecondSlide[]">' +
                                '</div>' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </label>' +
                                '<input data-id="'+item.id+'"type="number" step=".0001"  name="OpenFilePerecentSecondSlide[]" class="SpecificInput">' +
                                '</div>' +

                                '</div>' +
                                '<div class="row border p-3 m-0">'+
                                '<div class="col-md-4">' +
                                '<label>' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة  الثالثة' +
                                '@else' +
                                'Start Price third Slide' +
                                '@endif' +
                                '</label>' +
                                '<input data-id="'+item.id+'"type="number" step=".0001" name="thirdSlidePrice[]" class="SpecificInput" >' +
                                 '</div>' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </label>' +
                                '<input data-id="'+item.id+'"class="SpecificInput" step=".0001" type="number" name="OpenFileThirdSlide[]">' +
                                '</div>' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </label>' +
                                '<input data-id="'+item.id+'"type="number" step=".0001" name="OpenFilePerecentThirdSlide[]" class="SpecificInput">' +
                                '</div>' +
                                '</div>' +
                                '<div class="row border p-3 m-0">' +
                                '<div class="col-md-4">'+
                                    '<label>' +
                                '@if(app()->getLocale() == "ar")' +
                                'سعر الشريحة  الرابعة' +
                                '@else' +
                                'Start Price fourth Slide' +
                                '@endif' +
                                '</label>' +
                                '<input data-id="'+item.id+'"type="number" name="fourthSlidePrice[]" class="SpecificInput" >' +
                                
                                '</div>'+
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") فتح ملف  @else Open File  @endif </label>' +
                                '<input data-id="'+item.id+'"class="SpecificInput" step=".0001" type="number" name="OpenFileFourthSlide[]">' +
                                '</div>' +
                                '<div class="col-md-4">' +
                                '<label> @if(app()->getLocale() == "ar") النسبة @else  Perecent  @endif </label>' +
                                '<input data-id="'+item.id+'"type="number" step=".0001" name="OpenFilePerecentFourthSlide[]" class="SpecificInput">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                            
                                '<br>' +
                                '</div>'
                            );

                        });
                        setAutoPricingEvent()

                        }

                    });
                   }
                   
            }
 
            function addmoreAddons() {


                $('.addons').append(
                    '<div class="row deleting">' +
                    '<div class="col-md-3 form-group">' +
                    '<label>' +
                    '@if(app()->getLocale() == "ar")' +
                    'إسم الشرط' +
                    '@else' +
                    'Term name' +
                    '@endif' +
                    '</label>' +
                    '<input type="text" class="SpecificInput" name="AddonNameAR[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label>' +
                    '@if(app()->getLocale() == "ar")' +
                    'إسم الشرط باللغة الانجليزية' +
                    '@else' +
                    'Term name In English' +
                    '@endif' +


                    '</label>' +
                    '<input type="text" class="SpecificInput" name="AddonNameEn[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label>' +
                    '@if(app()->getLocale() == "ar")' +
                    'حد أدني للسنين' +
                    '@else' +
                    'Minimum Years' +
                    '@endif' +
                    '</label>' +
                    '<input type="text" class="SpecificInput" name="AddonMaxYear[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label>' +
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
                    '<label>' +
                    '@if(app()->getLocale() == "ar")' +
                    'إسم الاضافة بالعربية' +
                    '@else' +
                    'Arabic Feature Name' +
                    '@endif' +
                    '</label>' +
                    '<input class="SpecificInput" type="text" name="FeatureNameAr[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label>' +
                    '@if(app()->getLocale() == "ar")' +
                    ' إسم الاضافة بالانجليزية' +
                    '@else' +
                    'English Feature Name' +
                    '@endif' +
                    '</label>' +
                    '<input class="SpecificInput" type="text" name="FeatureNameEn[]">' +
                    '</div>' +
                    '<div class="col-md-3 form-group">' +
                    '<label>' +
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
                    '<label>' +
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
    </script>
@endsection
