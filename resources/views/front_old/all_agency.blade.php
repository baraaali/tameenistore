@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/css/bootstrap.min.css">

<style>
    .PageCard {
        margin-top: 10px;
        background-image: url({{asset('/bg.jpg')}});
    }
    .backgroundSR {
        background: url({{asset('/car3.jpg')}});
        background-position: center;
        background-size: cover;
        height: 100px;
        position: relative;
    }
    .layerSR {
     background-color: rgba(30,68,122,.8);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
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
                                    <div class="colum col-sm-4">
                                        <select class="custom-select " name="typecar">
                                            <option value="" selected="">{{__('site.select_status')}}</option>
                                            <option value="1">{{__('site.new')}} </option>
                                            <option value="0">{{__('site.used')}} </option>
                                            <option value="2">{{__('site.both')}}</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="type" value="{{$type}}">
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
                                                        <img src="{{url('/')}}/uploads/{{$agent->image}}" class="img-thumbnail" style="height: 143px !important;width: 100%">
                                                    </a>
                                                </div>
                                                <div class="ContentPart col-sm-8">
                                                    <div class="card-body">
                                                        <a href="{{route('agency_show',[$agent->id,$lang])}}">
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
