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
    </style>
    <div class="col-lg-12 cover-adv"
         style="height:200px;background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
        @if(app()->getLocale() == 'ar')

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                    {{__('site.car_ads')}}
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
                        <form action="{{route('search_ads',$lang)}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label style="font-weight: 600">{{__('site.cars_type')}}</label>
                                    <select name="car_type" class="col-lg-12 cond-ajax sty_select select2">
                                        <option selected >{{(__('site.select_car'))}}</option>
                                        <option value="2">{{__('site.new')}}  </option>
                                        <option value="1">{{__('site.used')}}  </option>
                                        <option value="2">{{__('site.both')}} </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label style="font-weight: 600">{{__('site.ad_type')}}</label>
                                    <select name="car_type" class="col-lg-12 select2">
                                        <option selected >{{(__('site.ad_type'))}}</option>
                                        <option value="1">{{__('site.needed')}}  </option>
                                        <option value="0">{{__('site.offred')}}  </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-1">
                                    <label style="font-weight: 600">{{__('site.shows')}}  </label>
                                    <select name="agent_id" class="col-lg-12 exhibtors sty_select select2">
                                        <option value="0" selected>{{__('site.all')}}</option>
                                        @foreach(App\Agents::where('agent_type','!=',2)->where('status',1)->get() as $agent)
                                            <option value="{{$agent->id}}" @if(isset($_POST['agent_id'] )) @if($_POST['agent_id'] == $agent->id) {{ 'selected' }} @endif @endif>{{$agent->$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 mt-1">
                                    <label style="font-weight: 600">{{__('site.select_vehicle')}}  </label>
                                    <select name="vehicle_id" class="col-lg-12 vehicleChange select2">
                                        <option value="0" selected>{{__('site.select_vehicle')}}</option>
                                        @foreach(App\Vehicle::where('status','1')->get() as $vehicle)
                                            <option value="{{$vehicle->id}}">{{$vehicle->getName()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mt-1">
                                    <label style="font-weight: 600">{{__('site.select_brand')}}  </label>
                                    <select name="brand_id" class="col-lg-12 brandChange exhibtors sty_select select2">
                                        <option value="0" selected>{{__('site.select_brand')}}</option>
                                        {{-- @foreach(App\brands::where('status',1)->get() as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                </div>
                                <div class="row">

                                <div class="col-md-3 mt-1">
                                    <label style="font-weight: 600">{{__('site.select_model')}}  </label>
                                    <select name="model_id" class="col-lg-12 modelChange exhibtors sty_select select2">
                                       <option value="0" selected>{{__('site.select_model')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mt-1">
                                    <label style="font-weight: 600">{{__('site.select_shape')}}  </label>
                                    <select name="care_shape_id" class="col-lg-12 shapeChange select2">
                                        <option value="0" selected>{{__('site.select_shape')}}</option>
                                        {{-- @foreach($shapes as $shape)
                                            <option value="{{$shape['id']}}">{{$shape['name']}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-3 mt-1">
                                    <label style="font-weight: 600">{{__('site.year')}}  </label>
                                    <select name="year" class="col-lg-12 sty_select select2">
                                        <option value="0">{{__('site.select_year')}}</option>
                                        <?php
                                        for ($i = -1; $i <= 35; ++$i) {
                                            $time = strtotime(sprintf('-%d years', $i));
                                            $value = date('Y', $time);
                                            $label = date('Y ', $time);
                                            printf('<option value="%s"  >%s</option>', $value, $label);
                                        }
                                        ?>
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
                            <!--				--><?php //$cars = \App\Cars::where(['status'=>1,'sell'=>1])->orderBy('id','desc')->paginate() ; ?>
                            @foreach($cars as $car)
                                <?php
                                $rel=$car->memberships;
                                $day = date('Y-m-d');
                                ?>
                                <div class="col-md-4">
                                    <a href="{{URL::route('view-ad', [$car->id,app()->getLocale()] )}}"
                                       style="text-decoration: none;">
                                        <div class="card">
                                            @if($car->Price->discount_percent>0 && $car->Price->discount_end_date>$day)
                                                <span class="notify-badge">{{$car->Price->discount_percent}}%</span>
                                            @endif
                                            <a data-fancybox="cars" href="{{url('/')}}/uploads/{{$car->main_image}}">
                                                <img src="{{url('/')}}/uploads/{{$car->main_image}}"
                                                     class="card-image" alt="{{$car->$name}}" style="width: 100%">
                                            </a>
                                            {{--			                        <img src="{{url('/')}}/uploads/{{$car->Images ? $car->Images[0]->image : ''}}" class="card-image">--}}
                                            <div class="cost-holder">
                                                {{$car->Price->cost}} {{$car->Price->currency}}
                                            </div>

                                                <div class="badge-holder">
                                                    @if($rel->type == 3)
                                                        <span class="badge-golden badge-warning">
                                                {{__('site.golden')}}
                                                            @elseif($rel->type == 2)
                                                                <span class="badge-spacial badge-warning">
                                                {{__('site.special')}}
                                                                    @elseif($rel->type == 1)
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
                                                {{$car->country->ar_name}}
                                            @else
                                                {{$car->country->en_name}}
                                            @endif
			                            </span>
                                            </p>
                                            <p class="card-title">
                                                <a href="{{route('view-ad',[$car->id,$lang])}}">
                                                    @if(app()->getLocale() == 'ar')
                                                        {{$car->ar_name}}
                                                    @else
                                                        {{$car->en_name}}
                                                    @endif
                                                </a>
                                            </p>
                                            <p class="second-title">
			                            <span class="second-detail">
			                                <i class="fa fa-eye"></i> {{$car->visitors}}
			                            </span>
                                                <span class="second-detail margin-right">
			                                <i class="far fa-clock"></i>  {{Carbon::parse($car->end_ad_date)->toFormattedDateString()}}
			                            </span>
                                            </p>
                                            <div class="third-title">
                                                <div class="row">
                                                    <div class="col-4 text-center p-all third-detail-holder">
                                                        <div class="background-grey">
                                                            <i class="fa fa-tachometer-alt SecondColor"
                                                               style="display: block"></i>
                                                            <span class="third-detail SecondColor">{{$car->max}}
                                                                @if(app()->getLocale() == 'ar')

                                                                    كم\س
                                                                @else

                                                                    km\h

                                                                @endif
			                                        </span>
                                                        </div>

                                                    </div>
                                                    <div class="col-4 text-center p-all third-detail-holder">
                                                        <div class="background-grey">
                                                            <i class="fa fa-road SecondColor"
                                                               style="display: block"></i>
                                                            <span class="third-detail SecondColor">{{$car->kilo_meters}}
                                                                @if(app()->getLocale() == 'ar')

                                                                    كم
                                                                @else

                                                                    km

                                                                @endif</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-4 text-center p-all third-detail-holder">
                                                        <div class="background-grey">
                                                            <i class="fa fa-calendar-alt SecondColor"
                                                               style="display: block"></i>
                                                            <span class="third-detail SecondColor">{{$car->year}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <hr style="margin-bottom: .5rem">

                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            {{$cars->links()}}

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
    </script>




@endsection
