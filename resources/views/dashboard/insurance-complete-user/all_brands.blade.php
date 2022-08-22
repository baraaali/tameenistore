@extends('dashboard.layout.app')
@section('content')


    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>
    <style>
        .searchbar{
            margin-bottom: auto;
            margin-top: auto;
            height: 60px;
            background-color: #353b48;
            border-radius: 30px;
            padding: 10px;
        }

        .search_input{
            color: white;
            border: 0;
            outline: 0;
            background: none;
            width: 0;
            caret-color:transparent;
            line-height: 40px;
            transition: width 0.4s linear;
        }

        .searchbar:hover > .search_input{
            padding: 0 10px;
            width: 450px;
            caret-color:red;
            transition: width 0.4s linear;
        }

        .searchbar:hover > .search_icon{
            background: white;
            color: #e74c3c;
        }

        .search_icon{
            height: 40px;
            width: 40px;
            float: right;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            color:white;
            text-decoration:none;
        }

        .panel-default>.panel-heading {
            background: #0773fd; /* Old browsers */
            border: 1px solid #f8f9fa !important;
           padding: 5px;}

        .panel-title a{ font-size: 28px; color: #fff !important;}
        .margn-20{
            margin: 20px;
        }
    </style>
    <div class="card" style="padding:15px;">
        <div class="card-heading">
            <div class="d-flex justify-content-center h-100">
                <input type="hidden" name="company_name" id="company_name" value="{{$name}}">
                <form action="{{route('get_all_brands_search')}}" method="get">
                    @csrf
                    <div class="searchbar">
                        <input class="search_input" type="text" name="search" placeholder="Search...">
                        <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label style="font-weight: 600">{{__('site.select_brand')}}  </label>
                    <select name="brand_id" class="col-lg-12 brandChange exhibtors sty_select select2">
                        <option value="0" selected>{{__('site.select_brand')}}</option>
                        @foreach ($allBrands as $id => $brand)
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
                <input onclick="getDocumentModels()" type="button" class="btn btn-primary text-center w-25" value=" {{ __('site.search') }}">
            </div>
            <div class="direction" >
                <label for="auto-pricing">
                    <input id="auto-pricing" type="checkbox" >
                {{__('site.auto pricing')}}</label>
                
            </div>
            <hr>
                <div class="row">
                    <div class="col-sm-6 mb-4">
                        <a href="{{route('all_complete')}}" class="btn btn-danger btn-sm">
                            {{__('site.ins_added')}} ا
                        </a>
                    </div>

                </div>
            <div class="container-fluid">
                <div class="row models">
                @include('dashboard.insurance-complete-user.complete-selected-brands')
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
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
     // get Documents models
     function getDocumentModels(){
                    const brand_id =  $('.brandChange').val() ?  $('.brandChange').val() : 0;
                    const model_id =  $('.modelChange').val() ? $('.modelChange').val() : 0;
                    const name = $('#company_name').val() ? $('#company_name').val() : 0;
                    const passengers = $('.passengersChange').val() ? $('.passengersChange').val() : 0;
                    const shape = $('.shapeChange').val() ? $('.shapeChange').val() : 0;
                    hideElement("alert-success");
                    $(".models").html('');
                    showElement("loader")
                    $.ajax({
                        url: `{{url('/')}}/cp/get_all_brand/order-by-brand/${brand_id}/${model_id}/${name}/${passengers}/${shape}`,
                        context: document.body
                    }).done(function (data) {
                        hideElement("loader")
                        console.log(data);
                        if(!data.count)
                        showElement('alert-success');
                        else
                        $(".models").html(data.view);
                    });
    }
                   
      var setAutoPricingEvent = function(){
        const elements = {};
        elements['firstSlidePrices'] = $('input[name="firstSlidePrice"]');
        elements['OpenFileFirstSlides'] = $('input[name="OpenFileFirstSlide"]');
        elements['OpenFilePerecentFirstSlide'] = $('input[name="OpenFilePerecentFirstSlide"]');
        elements['OpenFileMinimumFirstSlide'] = $('input[name="OpenFileMinimumFirstSlide"]');

        elements['SecondSlidePrice'] = $('input[name="SecondSlidePrice"]');
        elements['OpenFileSecondSlide'] = $('input[name="OpenFileSecondSlide"]');
        elements['OpenFilePerecentSecondSlide'] = $('input[name="OpenFilePerecentSecondSlide"]');
        
        elements['thirdSlidePrice'] = $('input[name="thirdSlidePrice"]');
        elements['OpenFileThirdSlide'] = $('input[name="OpenFileThirdSlide"]');
        elements['OpenFilePerecentThirdSlide'] = $('input[name="OpenFilePerecentThirdSlide"]');

        elements['fourthSlidePrice'] = $('input[name="fourthSlidePrice"]');
        elements['OpenFileFourthSlide'] = $('input[name="OpenFileFourthSlide"]');
        elements['OpenFilePerecentFourthSlide'] = $('input[name="OpenFilePerecentFourthSlide"]');
   
        Object.keys(elements).forEach(key => {
               const $childrens = elements[key]
               $childrens.each((i,$e)=>{
               $($e).on('input',function(){
                
                if($('#auto-pricing').is(':checked')){
                const value = $(this).val();
                $childrens.val(value);
                }   
            }) 
            })
         });
 
    }
    function myFunction(id) {
                var company_id = id;
                var row='statusVal_'+company_id;
                var data = $('.'+row).val();
                var status=data==0?1:0;
                //alert(status);
                console.log(status);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/insurace/docChangeShowStatus',
                    data: {'status': status, 'company_id': company_id},
                    success: function(data){
                        console.log(data.success)
                        console.log(status);
                        var clas='cl_'+company_id;
                        if(status==1){

                            $('.'+clas).html('مفعلة');
                            $('.'+clas).removeClass('btn-danger');
                            $('.'+clas).addClass('btn-success');
                            $('.'+row).attr('value', '0');
                        }
                        else{

                            $('.'+clas).html('معطله');
                            $('.'+clas).removeClass('btn-success');
                            $('.'+clas).addClass('btn-danger');
                            $('.'+row).attr('value', '1');
                        }

                    }
                });
            };
 $(document).ready(function(){
    setAutoPricingEvent()
    brandChange()
 })

</script>
@endsection