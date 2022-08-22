@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css" integrity="sha512-nSomje7hTV0g6A5X/lEZq8koYb5XZtrWD7GU2+aIJD35CePx89oxSM+S7k3hqNSpHajFbtmrjavZFxSEfl6pQA==" crossorigin="anonymous" />
    <style>
        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
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
        .background_dep {
            background: url({{asset('/bg.jpg')}});
            background-position: center;
            background-size: cover;
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
    Carbon::setLocale(LC_TIME, $lang);;
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
$name=$lang.'_name';
$des=$lang.'_desciption';
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css" integrity="sha512-uMIpMpgk4n6esmgdfJtATLLezuZNRb96YEgJXVeo4diHFOF/gqlgu4Y5fg+56qVYZfZYdiqnAQZlnu4j9501ZQ==" crossorigin="anonymous" />
    @include('dashboard.layout.message')
    <div class="container-fluid">
        <div id="HomePage py-3" >
            <div class="card PageCard">
                <div class="card-body" style="padding:0px;">
                    <h5 class="card-title CT1"><i class="fa fa-car"></i>{{__('site.all_dep')}}</h5>
                    <h6 class="text-muted desc-textpg"><span style="font-weight:bold;">{{__('site.are_u_have_agency')}} </span> {{__('site.u_can_do')}}</h6>
                    <div class="clr"></div>
                    <div class="backgroundSR clearfix2 display-desk">
                        <div class="layerSR">
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-8">
                <div class="container">
                    <div class="row">
                        @if($car->Images)
                            <div class="swiper-container">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-wrapper">
                                    @foreach($car->Images as $image)
                                        <div class="swiper-slide col-lg-12 ads" style="width:100%;height: 400px;background-image: url({{url('/')}}/uploads/{{$image->image}});background-size: cover;background-repeat: no-repeat;border-style: solid;border-color:#eee;border-radius: 5px;border-width: 5px;margin-bottom:10px;">
                                        </div>

                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        @else
                            <a data-fancybox="cats" href="{{url('/')}}/uploads/{{$car->main_image}}"  >
                                <img src="{{url('/')}}/uploads/{{$car->main_image}}" alt="" class="img-thumbnail" style="width:100%;height:400px; margin-bottom: 20px" >
                            </a>
                        @endif
                        <div class="text-center">
                            <h2 class="text-primary">{{$car->$name}}</h2>
                        </div>

                       <p class="text-danger p-4">{{$car->$des}}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="col-lg-12 card bg-light" style="padding: 0px;">
                    <div class="col-lg-12 card-head" style="border-bottom: 1px solid #d3d3d3;">
                        <h5 style="text-align: center;padding: 10px;" class="text-dark">{{__('site.cat_name')}} :
                                <span class="text-danger">{{$car->category->$name}}</span>
                        </h5>
                        <h5 style="text-align: center;padding: 10px;" class="">{{__('site.owner_ads')}} :
                            <span class="text-danger">{{$car->user->name}}</span>
                        </h5>
                        <h5 style="text-align: center;padding: 10px;" class="text-dark">{{__('site.phone')}} :
                            <span class="text-danger">{{$car->user->phones}}</span>
                        </h5>
                        <h5 style="text-align: center;padding: 10px;">{{__('site.price')}} :
                           <span class="text-danger">{{$car->price}}</span>
                        </h5>
                        <h5 style="text-align: center;padding: 10px;">{{__('site.visitors')}} :
                            <span class="text-danger">{{$car->visitors}}</span>
                        </h5>
                        @if($car->dicount_percent>0)
                        <h5 style="text-align: center;padding: 10px;">{{__('site.discount')}} :
                            {{$car->dicount_percent}}
                            <span class="text-primary">{{$car->dicount_percent}}</span>
                        </h5>
                        <h5 style="text-align: center;padding: 10px;">{{__('site.discount_start_date')}} :
                            <span class="text-dark">{{$car->start_date}} </span>
                        </h5><h5 style="text-align: center;padding: 10px;">{{__('site.discount_end_date')}} :
                            <span class="text-secondary">{{$car->end_date}} </span>
                            </h5>
                            @endif
                    </div>
                </div>
                <div class="col-lg-12 card" style="padding: 0px;">
                    <div class="col-lg-12 card-head" style="border-bottom: 1px solid #d3d3d3;">
                        <h5 style="text-align: center;padding: 10px;">
                            @if(app()->getLocale() == 'ar')
                                الموقع علي الخريطة
                            @else
                                Location on Map
                            @endif
                        </h5>
                    </div>
                    <div class="col-lg-12 card-body" style="padding:0px;overflow: hidden;height:300px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d13813.549126081274!2d31.274070149999996!3d30.0544315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sar!2seg!4v1586815987643!5m2!1sar!2seg" frameborder="0" style="border:0;width: 100%;height: 100%;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js" integrity="sha512-VHsNaV1C4XbgKSc2O0rZDmkUOhMKPg/rIi8abX9qTaVDzVJnrDGHFnLnCnuPmZ3cNi1nQJm+fzJtBbZU9yRCww==" crossorigin="anonymous"></script>

    <script>
        var mySwiper = new Swiper ('.swiper-container', {
            // Optional parameters
            slidesPerView: 1,
            spaceBetween: 0,
            autoplay: { delay: 3000,},

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        })
    </script>
    </script>

@endsection

