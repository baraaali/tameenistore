@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/css/show_one_agency.css">

<?php
if ($lang == 'ar' || $lang == 'en') {
    App::setlocale($lang);
} else {
    App::setlocale('ar');
}
$name = $lang . '_name';
?>
@section('content')
    <section class="section1 clearfix">
        <div class="container">
            <div class="grid clearfix row">
                <div class="col2 first col-sm-6">
                    <img src="https://www.chakirdev.com/demo/Cars/uploads/sr4.jpg" alt="" style="width: 30%">
                    <h3 class="text-primary">معرض السعدى الرئيسي</h3>
                    <p>نبدة عن المعرض و مركات السيارات المتوفرة فيه نبدة عن المعرض و مركات السيارات المتوفرة فيه
                        نبدة عن المعرض و مركات السيارات المتوفرة فيه</p>
                </div>
                <div class="col2 last col-sm-6">
                    <div class="grid clearfix">
                        <div class="col3 first">
                            <h1><i class="fa fa-car text-danger"></i></h1>
                            <span class="text-primary"> عدد السيارات : 4</span>
                        </div>
                        <div class="col3"><h1><i class="fas fa-map-marker-alt text-danger"></i></h1>
                            <span class="text-primary">السعودية - الرياض </span></div>
                        <div class="col3 last">
                            <h1>
                                <i class="fas fa-mobile-alt text-danger"></i>
                            </h1>
                            <span>
                                    <a href="tel:0601051695" class="btn btn-success btn-sm">
                                       0601051695 <i class="fas fa-phone-volume text-danger"></i>
                                    </a></span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="card-text py-2">
            <div class="row">
                <div class="rgt RightShowroom col-sm-8">
                    @foreach($cars as $car)
                        <div class="postList">
                            <div class="rgt card showroomsCard">
                                <div class="row no-gutters">
                                    <div class="ImgPart col-sm-4">
                                        <a data-fancybox="{{$car->id}}" href="{{url('/')}}/uploads/{{$car->main_image}}"  >
                                            <img src="{{url('/')}}/uploads/{{$car->main_image}}" class="img-thumbnail" style="height: 300px;width: 100%">
                                        </a>
                                    </div>
                                    <div class="ContentPart col-sm-8">
                                        <div class="card-body">
                                            <a href="">
                                                <h5 class="card-title CT2 text-right">{{$car->$name}}</h5></a>
                                            <p class="card-text">{{__('site.brief')}}</p>
                                            <p class="card-text">
                                            </p>
                                            {{--                                                   {{dd($agent->country->owner)}}--}}
                                            <span class="rgt Tag"><i class="fa fa-map-marker-alt">
                                                       </i> {{$car->country->$name}}</span>
                                            <span class="rgt Tag"><i class="fa fa-car">
                                                       </i> {{__('site.car_count')}} : {{$car->count()}} </span>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center"> {{$cars->links()}}</div>
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
    ////agency
