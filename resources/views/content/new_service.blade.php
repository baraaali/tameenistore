@extends('layouts.app')
@section('content')
    <?php

    use Carbon\Carbon;
    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    $name = $lang.'_name';
       $name2 ='name_'.$lang;
    ?>
    <style>
        .sty_search {
            margin-top: 10px !important;
            padding: 5px;
            border-radius: 10px;
            width: 140px;
        }

        .pt-4, .py-4 {
            padding-top: 0rem !important;
        }

        .sty_select {
            border: 1px solid #d3d3d3;
            border-radius: 5px;
        }
        .sty_select2{
            border: 0px solid #d3d3d3;
            border-radius: 5px;
        }
    </style>
    <div class="col-lg-12 cover-adv"
         style="height:200px;background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
        @if(app()->getLocale() == 'ar')

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                    {{__('site.new_module')}}
                    <br>
                    <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>

        @else

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                    Cars For Sale
                    <br>
                    <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>
        @endif
    </div>
    <div class="container">
        <div class="col-lg-12">
            <div class="row">

                <div class="col-lg-12" style="padding-top: 30px;">
                    <div class="col-lg-12">
                        <form action="{{route('search_services',$lang)}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label style="font-weight: 600">{{__('site.cats')}}</label>
                                    <select name="cat_id" id="category_id" class="col-lg-12  sty_select">
                                        <option selected value="0">{{(__('site.select_cat'))}}</option>
                                       @foreach($cats as $cat)
                                       <option value="{{$cat->id}}">{{$cat->$name2}}</option>
                                       @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4" id="sub_cat_div" style="display: none">
                                    <label style="font-weight: 600">{{__('site.sub_cat')}}</label>
                                     <select name="sub_cat" id="sub_cat_id" class="col-lg-12  sty_select ">
                                        <option selected value="0" >{{(__('site.select_subCat'))}}</option>
{{--                                       @foreach($sub_cats as $sub)--}}
{{--                                       <option value="{{$sub->id}}">{{$sub->$name2}}</option>--}}
{{--                                       @endforeach--}}
                                    </select>
                                </div>
                                <div class="col-md-4" id="mini_sub_cat_div" style="display: none">
                                    <label style="font-weight: 600">{{__('site.mini_sub_cat')}}  </label>
                                     <select name="mini_sub_cat" id="mini_sub_cat_id" class="col-lg-12 sty_select">
{{--                                        <option selected value="0">{{(__('site.select_mini_sub_cat'))}}</option>--}}
{{--                                       @foreach($mini_subcat as $mini)--}}
{{--                                       <option value="{{$mini->id}}">{{$mini->$name2}}</option>--}}
{{--                                       @endforeach--}}
                                    </select>
                                </div>

                                <div class="col">
                                    <br>
                                    <input type="submit" class="btn btn-warning btn-sm sty_search"
                                           value="{{__('site.search')}}">
                                </div>
                            </div>
                        </form>
                    </div>

                    <hr>

                    <div class="col-lg-12">
                        <div class="row ads">
                            @foreach($services as $service)
                               {{--  <?php
                                $rel=$service->memberships;
                                $day = date('Y-m-d');
                                ?> --}}
                                <div class="col-md-4">
                                    <a href=""
                                       style="text-decoration: none;">
                                        <div class="card">

                                            <a data-fancybox="cars" href="{{url('/')}}/uploads/{{$service->image}}">
                                                <img src="{{url('/')}}/uploads/{{$service->image}}"
                                                     class="card-image" alt="{{$service->$name}}" style="width: 100%">
                                            </a>
                                            <div class="cost-holder">
                                                <big class='text-danger'>{{$service->price}}</big> <small>{{$service->country->ar_currency}}</small>
                                            </div>

                                                <div class="badge-holder">
                                                    @if($service->type == 3)
                                                        <span class="badge-golden badge-warning">
                                                {{__('site.golden')}}
                                                    @elseif($service->type == 2)
                                                                <span class="badge-spacial badge-warning">
                                                {{__('site.special')}}
                                                            @elseif($service->type == 1)
                                                                <span class="badge-silver badge-warning">
                                                  {{__('site.silver')}}
                                                                            @else <span class="badge-normal badge-warning">
                                                          {{__('site.normel')}}
                                                                                @endif
			                            </span>
                                                </div>
                                            <p class="card-hint-line">
			                            <span class="hint-line">
			                                <i class="fa fa-map-marker-alt"></i>
			                               @if(app()->getLocale() == 'ar')
                                                {{$service->country->ar_name}}
                                            @else
                                                {{$service->country->en_name}}
                                            @endif
			                            </span>
                                            </p>
                                                 <p class="card-title">
                                                <a href="{{ route('ServiceDetails',[$service->id,app()->getLocale()]) }}" class="text-danger">
                                                    @if(app()->getLocale() == 'ar')
                                                        {{$service->name_ar}}
                                                    @else
                                                        {{$service->name_en}}
                                                    @endif
                                                </a>
                                            </p>
                                            <p class="second-title">
                                        <span class="second-detail">
                                            <i class="fa fa-eye"></i> {{$service->visitor}}

                                        <span class="second-detail margin-right">
                                            <i class="far fa-clock"></i>  {{Carbon::parse($service->start_date)->toFormattedDateString()}}
                                        </span>

                                        </span> <hr style="margin-bottom: .5rem">

                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            {{$services->links()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

























    <script>
        $(document).ready(function () {
            $(".show").click(function () {
                $(".hidden").slideToggle();
            });
            $(".show1").click(function () {
                $(".hidden1").slideToggle();
            });
        });

    </script>


    <script>
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;

        slider.oninput = function () {
            output.innerHTML = this.value;
        }
    </script>

    <script>

            // $.ajax({
            //         url: "{{url('/')}}/view/get-careshapes/" + $(this).val(),
            //         context: document.body
            //     }).done(function (data) {
            //         $('.shapeChange').find('option').remove().end();
            //         $.each(data, function (i, item) {
            //             $('.shapeChange').append('<option value="' + item.id + '">' + item.name + '</optin>')
            //         });

            //     });

            var getShapes = function()
          {
              var brand_id = $('.brandChange').val()
              var vehicle_id = $('.vehicleChange').val()
              $.ajax({
                    url: "{{url('/')}}/view/get-careshapes/" + vehicle_id + '/' + brand_id,
                    context: document.body
                }).done(function (data) {
                    $('.shapeChange').find('option').remove().end();
                    $.each(data, function (i, item) {
                        $('.shapeChange').append('<option value="' + item.id + '">' + item.ar_name+' ' + item.en_name+  '</optin>')
                    });
                });

          }
        $(document).ready(function () {
            $('.brandChange').change(function () {
                getShapes()
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

             $('.vehicleChange').change(function () {
                getShapes()
                $.ajax({
                    url: "{{url('/')}}/view/get-brands/" + $(this).val(),
                    context: document.body
                }).done(function (data) {
                    $('.brandChange').find('option').remove().end();
                    $.each(data, function (i, item) {
                        $('.brandChange').append('<option value="' + item.id + '">' + item.name + '</optin>')
                    });
                    $('.brandChange').trigger('change')


                });
            });
        });

            $('#category_id').on('change',function(){
                var sub = $(this).val();
                $('#sub_cat_div').css("display", "block");
                $('#sub_cat_div').addClass('sty_select2');

                if(sub){
                    $.ajax({
                        type:"GET",
                        url:"{{route('get-sub-cat-list')}}?sub_id="+sub,
                        success:function(res){
                            console.log(res);
                            if(res){
                                $("#sub_cat_id").empty();
                                $("#mini_sub_cat").empty();
                                $('#mini_sub_cat_div select').val(0);
                                $('#mini_sub_cat_div').css("display", "none");
                                $("#sub_cat_id").append('<option value="0" >'+"تصنيف رئيسى "+'</option>');
                                $.each(res,function(key,value){
                                    $("#sub_cat_id").append('<option value="'+key+'">'+value+'</option>');
                                });

                            }else{
                                $("#sub_cat_id").empty();
                            }
                        }
                    });
                }else{
                    $("#sub_cat_id").empty();
                }

            });

            $('#sub_cat_id').on('change',function(){

                var sub_id = $(this).val();
                if(sub_id>0){

                    $.ajax({
                        type:"GET",
                        url:"{{url('get-mini-sub-cat-list')}}?sub_id="+sub_id,
                        success:function(res){
                            if(res){
                                $('#mini_sub_cat_div').css("display", "block");
                                $('#mini_sub_cat_div').addClass('sty_select2');
                                $("#mini_sub_cat_id").empty();
                                $("#mini_sub_cat_id").append('<option value="0" >'+"تصنيف رئيسى "+'</option>');
                                $.each(res,function(key,value){
                                    $("#mini_sub_cat_id").append('<option value="'+key+'">'+value+'</option>');
                                });

                            }else{
                                $('#mini_sub_cat_div').css("display", "none");
                                $("#mini_sub_cat_id").empty();
                            }
                        }
                    });
                }else{
                    $('#mini_sub_cat_div').css("display", "none");
                    $("#mini_sub_cat_id").empty();
                }

            });

    </script>




@endsection
