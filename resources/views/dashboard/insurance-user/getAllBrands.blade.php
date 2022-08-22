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
       <div class="btn btn-secondary">
           <a href="{{route('dashboard-insurance',$lang)}}" class="text-warning">{{__('site.go_back')}}</a></div>
           <div class="row">
            <div class="form-group col-md-3">
                <label style="font-weight: 600">{{__('site.select_brand')}}  </label>
                <select name="brand_id" class="col-lg-12 brandChange exhibtors sty_select select2">
                    <option value="0" selected>{{__('site.select_brand')}}</option>
                    @foreach ($brands as $id => $brand)
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
        <div id="loader" class="text-center justify-content-center my-4 d-none">
            <div class="spinner-border text-info"></div>
        </div>
        <div id="alert-success" class="alert alert-success d-none" role="alert">
            <strong>{{__('site.no data')}}</strong>
        </div>
        <div class="text-center">
            <input type="hidden" id="doc_id" value="{{$doc_id}}">
            <input onclick="getDocumentModels()" type="button" class="btn btn-primary text-center w-25" value=" {{ __('site.search') }}">
        </div>

           <div class="form-body">
            <div class="text-center text-warning">{{__('site.all_brands')}}</div>
            <div class="models">
                @include('dashboard.insurance-user.single-selected-brands')
            </div>
        </div>


    </div>


    <script>
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
           function brandChange()
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
    
     function getDocumentModels()
     {
                    const brand_id =  $('.brandChange').val() ?  $('.brandChange').val() : 0;
                    const model_id =  $('.modelChange').val() ? $('.modelChange').val() : 0;
                    const passengers = $('.passengersChange').val() ? $('.passengersChange').val() : 0;
                    const shape_id = $('.shapeChange').val() ? $('.shapeChange').val() : 0;
                    const doc_id = $('#doc_id').val();
                    hideElement("alert-success");
                    $(".models").html('');
                    showElement("loader")
                $.ajax({
                    url: `{{url('/')}}/view/childerns/models/search/${brand_id}/${doc_id}/${model_id}/${shape_id}/${passengers}`,
                    context: document.body
                }).done(function (data) {
                    hideElement("loader");
                    if(!data.count)
                    showElement("alert-success");
                    else
                    $(".models").html(data.view);
                });
     }
        $(document).ready(function () {
            brandChange();
        });
    </script>
@endsection
