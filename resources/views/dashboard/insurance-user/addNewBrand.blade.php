@extends('dashboard.layout.app')
@section('content')


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
            <form action="{{route('add_brands',$document,$lang)}}" method="post">
                @csrf
                <input type="hidden" id="doc_id" value="{{$document}}">
                <div class="form-group">
                    <div class="text-center">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>
                                        البراند
                                </label>
                                <select class="SpecificInput select2 brandChange">
                                    <option disabled selected>
                                            إختر نوع البراند
                                    </option>
                                    @foreach($brands as $brand)
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
                           
                        </div>
                        <div class="row">
                            <div class="direction p-3" >
                                <label for="auto-pricing">
                                    <input id="auto-pricing" checked type="checkbox" >
                                {{__('site.auto pricing')}}</label>
                                
                            </div>
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
                        <input onclick="getDocumentModels()"  type="button" class="btn btn-primary text-center w-25" value=" {{ __('site.search') }}">
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-success text-center w-25" value=" {{ __('site.save') }}">
                    </div>

                    <div id="inbrandtable" class="table-responsive">
                        <table class="table table-stroped table-responsive table-borderd text-center modelTable">
                            <thead class="bg-light ">
                            <td>
                                #
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    الموديل
                                @else
                                    Model
                                @endif
                            </td>

                            <td>
                                @if(app()->getLocale() == 'ar')
                                    السعر
                                @else
                                    Price
                                @endif
                            </td>

                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الاولي
                                @else
                                    First Insurance Interval
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الثانيه
                                @else
                                    second Insurance Interval
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'ar')
                                    فتره التامين الثالثه
                                @else
                                    third Insurance Interval
                                @endif
                            </td>

                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    {{-- <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="{{__('site.save')}}">
                    </div> --}}
                </div>
            </form>
        </div>


    </div>


    <script>
    function brandChange ()
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
     function getShapes()
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
      
    // get Documents models
    function getDocumentModels(){
            const brand_id =  $('.brandChange').val() ?  $('.brandChange').val() : 0;
            const model_id =  $('.modelChange').val() ? $('.modelChange').val() : 0;
            const passengers = $('.passengersChange').val() ? $('.passengersChange').val() : 0;
            const doc_id = $('#doc_id').val() ? $('#doc_id').val() : 0;
            const shape_id = $('.shapeChange').val() ? $('.shapeChange').val() : 0;
                    hideElement("alert-success");
                    hideElement("alert-danger");
                    $(".modelTable tbody").html('');
                   if(brand_id == 0){
                    showElement("alert-danger")
                   }else{
                    showElement("loader")
                    $.ajax({
                        url: `{{url('/')}}/view/childerns/models/${brand_id}/${doc_id}/${model_id}/${shape_id}/${passengers}`,
                        context: document.body
                    }).done(function (data) {
                        console.log(data);
                        hideElement("loader")
                        if(data.length == 0){
                            showElement("alert-success")
                        }else{
                    $.each(data, function (i, item) {
                        $(".modelTable tbody").append('<tr class="item-box"><td ><input type="checkbox" name="model_id[]" value="' + item.id + ',' + brand_id + '" /></td>' +
                            '<td>' + item.name + '</td>' +
                            '<td><input data-id="'+item.id+'" type="text" name="price[]"></td>' +
                            '<td><input data-id="'+item.id+'" type="text" name="firstinterval[]"></td>' +
                            '<td><input data-id="'+item.id+'" type="text" name="secondinterval[]"></td>' +
                            '<td><input data-id="'+item.id+'" type="text" name="thirdinterval[]"></td>' +
                            '</tr>');

                    });
                        initBoxs()

                        }

                    });
                   }
                   
            } 
  
    function initBoxs(){
            
            const $itemBoxs = $('input[name="model_id[]"]');
            
        $itemBoxs.each((i,$e)=>{
            const $parent = $($e).parent().parent();
            $($e).on('change',function(){
                if($($e).is(':checked'))
                    $parent.find('input').addClass('target_el');
                else
                $parent.find('input').removeClass('target_el');
                
            })
        })
        setAutoPricingEvent('input')
        
    }

    function setAutoPricingEvent(action){
        const elements = {};
        elements['price'] = $('input[name="price[]"]');
        elements['firstinterval'] = $('input[name="firstinterval[]"]');
        elements['secondinterval'] = $('input[name="secondinterval[]"]');
        elements['thirdinterval'] = $('input[name="thirdinterval[]"]');

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
    
    // run auto pricing
    function runAutoPricing (){
        $('#auto-pricing').on('change',function(){
                if($('#auto-pricing').is(':checked') )
                setAutoPricingEvent('input')
                else{
                setAutoPricingEvent('off')
                }
                
             })
    }
    function showElement(idName){
        const $e = $("#"+idName);
        if($e.hasClass("d-none"))
        $e.removeClass("d-none");
    }
    function hideElement(idName){
        const $e = $("#"+idName);
        if(!$e.hasClass("d-none"))
        $e.addClass("d-none");
    }
     $(document).ready(function(){
        brandChange();
        runAutoPricing();
    })
  
    </script>

    <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js"
            referrerpolicy="origin">
    </script>
    <script> tinymce.init({selector: 'textarea'});</script>

@endsection
