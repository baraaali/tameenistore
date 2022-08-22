@extends('layouts.app')
<style>
    .PageCard {
        margin-top: 10px;
        background-image: url({{asset('/bg.jpg')}});
    }

    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;}
    * {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        text-decoration: none;
        font-family: Cairo,sans-serif;
        text-rendering: optimizeLegibility;
    }
    .CT1 {
        font-weight: 700;
        font-size: 25px;
        color: #0069d9;
        margin-bottom: 0;
        padding: 20px 20px 0 0;
    }
    .desc-textpg {
        padding: 10px 20px;
        line-height: 30px;
    }
    .clr {
        clear: both;
    }
    .backgroundSR {
        background: url({{asset('/car3.jpg')}});
        background-position: center;
        background-size: cover;
        height: 100px;
        position: relative;
    }
    .RightShowroom {
        float: right;
        width: 700px;
        margin-left: 20px;
    }
    .showroomsCard {
        width: 100%;
        margin: 20px 0 0px 20px;
    }
    .no-gutters {
        margin-left: 0;
        margin-right: 0;
    }
    .showroomsCard .ImgPart {
        width: 30%;
    }
    .showroomsCard .ContentPart {
        width: 70%;
    }
    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }
    .showroomsCard .CT2 {
        font-size: 17px;
        font-weight: 700;
        color: #1c263d;
    }
    .card-title {
        margin-bottom: .75rem;
    }
    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }
    .Tag {
        font-weight: 700;
        margin-left: 15px;
        color: #143789;
        font-size: 13px;
    }
    .fa, .fas {
        font-weight: 900;
    }
    .Tag {
        font-weight: 700;
        margin-left: 15px;
        color: #143789;
        font-size: 13px;
    }
    .LeftShowrom {
        float: left;
        width: 330px;
        margin-top: 20px;
    }
    .card-body img {
        width: auto;
        height: 140px !important;
    }
    img {
        vertical-align: middle;
        border-style: none;
    }
    .layerSR {
        background-color: rgba(30,68,122,.8);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .card-img2 {
        width: 200px !important;
        height: 120px !important;
    }
</style>
<?php
use Carbon\Carbon;
if ($lang == 'ar' || $lang == 'en') {
    App::setlocale($lang);
} else {
    App::setlocale('ar');
}
$name=$lang.'_name';

?>
@section('content')

{{--    {{dd($agents)}}--}}
    <div class="container">
        <div id="HomePage" dir="{{$lang=='ar'?'rtl':'ltr'}}">
            <div class="card PageCard">
                <div class="card-body" style="padding:0px;">
                    <h5 class="card-title CT1"><i class="fa fa-car"></i>{{__('site.car_show')}}</h5>
                    <h6 class="text-muted desc-textpg"><span style="font-weight:bold;">{{__('site.are_u_owner')}} </span> {{__('site.u_can_do')}}</h6>
                    <div class="clr"></div>
                    <div class="backgroundSR clearfix2 display-desk">
                        <div class="layerSR">
                            <form action="{{route('search_agency',$lang)}}" method="post" class="formsrchSR">
                                @csrf
                                <div class="row pt-4">
{{--                                    <div class="colum">--}}
{{--                                        <select class="custom-select mr-sm-2 brandChange" name="brand_id" id="brand">--}}
{{--                                            <option value="" selected="">{{__('site.select_baner')}}</option>--}}
{{--                                            @foreach($brands as $brand)--}}
{{--                                                <option value="{{$brand->id}}" @if($_POST)@if($_POST['brand_id'] == $brand->id) {{ 'selected' }} @endif @endif>--}}
{{--                                                    {{$brand->name}}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="colum">--}}
{{--                                        <select class="custom-select mr-sm-2 modelChange" name="model_id" id="subbrand">--}}
{{--                                            <option value="" selected=""> {{__('site.select_model')}}</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="colum mr-sm-2">--}}
                                    <div class="colum col-sm-4">
                                        <select class="custom-select " name="typecar">
                                            <option value="" selected="">{{__('site.select_status')}}</option>
                                            <option value="1">{{__('site.new')}} </option>
                                            <option value="0">{{__('site.used')}} </option>
                                            <option value="2">{{__('site.both')}}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <button type="submit" name="search" class="btn btn-primary"><i class="fa fa-search"></i> بحث </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="clr"></div>
                    <div class="card-text py-2">
                       <div class="row">

                           <div class="rgt RightShowroom col-sm-8">
                               @foreach($agents as $agent)
                               <div class="postList">
                                   <div class="rgt card showroomsCard">
                                       <div class="row no-gutters">
                                           <div class="ImgPart col-sm-4">
                                               <a data-fancybox="agency" href="{{url('/')}}/uploads/{{$agent->image}}"  >
                                                   <img src="{{url('/')}}/uploads/{{$agent->image}}" class="img-thumbnail" style="height: 300px;width: 100%">
                                               </a>
                                           </div>
                                           <div class="ContentPart col-sm-8">
                                               <div class="card-body">
                                                   <a href="https://www.chakirdev.com/demo/Cars/showroom/4/معرض_السعدى_الرئيسي">
                                                       <h5 class="card-title CT2 text-right">{{$agent->$name}}</h5></a>
                                                   <p class="card-text">{{__('site.brief')}}</p>
                                                   <p class="card-text">
                                                   </p>
{{--                                                   {{dd($agent->country->owner)}}--}}
                                                   <span class="rgt Tag"><i class="fa fa-map-marker-alt">
                                                       </i> {{$agent->country->$name}}</span>
                                                   <span class="rgt Tag"><i class="fa fa-car">
                                                       </i> {{__('site.car_count')}} : {{$agent->cars->count()}} </span>
                                                   <p></p>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               @endforeach
                              <div class="text-center"> {{$agents->links()}}</div>
                           </div>
                           <div class="rgt LeftShowrom col-sm-3">
                               <div class="card">
                                   <div class="card-body">
                                       <h5 class="card-title" style="font-weight:bold;font-size:18px;">{{__('site.have_one')}}</h5>
                                       <p class="card-text">{{__('site.are_u_have_agency')}} </p>
                                   </div>
                                   <a href="{{route('user-register',$lang)}}" class="btn btn-primary" style="border-radius:0px;padding:30px;">
                                       <i class="fa fa-plus" style="font-size:12px;"></i> {{__('site.register_now')}}</a>
                               </div>
                               <div class="clr"></div><br>
                               <a href="#">
                                   <img src="https://via.placeholder.com/330x600?text=220x300+Banner" style="width: 100%;height: 300px !important;">
                               </a>
                               <div class="clr"></div><br>
                           </div>
                       </div>
                    </div>
                    <div class="clr"></div><br>
                </div>
            </div>

        </div>
    </div>


@endsection
@section('js')

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
     });

     function changeCost(id) {
         var amountToAdd = $('.original_price').val();
         $(':checkbox').each(function () {
             if ($(this).is(":checked")) {
                 amountToAdd = parseFloat(amountToAdd) + parseFloat($(this).attr('value'));
             }
         });
         $('.start_price').attr('value', amountToAdd);
         //alert(amountToAdd);
     }


 </script>
    </script>
@endsection
