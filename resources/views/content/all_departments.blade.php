@extends('layouts.app')
@section('content')
    <style>
        body{
            overflow-x:hidden;
        }
        .py-4{
            padding-top:0px !important;
        }

    </style>

    <?php
    use App\items;use Carbon\Carbon;

    $date=$day = date('Y-m-d');
    $category_id = isset($category_id)? $category_id  : null;
    if (session()->has('country')){
        $country=Session::get('country');
        $country_id=\App\country::where('en_name',$country)->first()->id;
        $golden = getItems(3,$country_id,$category_id);
        $special = getItems(2,$country_id,$category_id);
        $silver =getItems(1,$country_id,$category_id);
        $normal = getItems(0,$country_id,$category_id);

    }
    else{
        $golden = getItems(3,null,$category_id);
        $special = getItems(2,null,$category_id);
        $silver =  getItems(1,null,$category_id);
        $normal =  getItems(0,null,$category_id);
//dd($silver);
    }
    $day = date('Y-m-d');
    $items=items::where(['status'=>1]);
    if (getCountry() !=0) $items=$items->where('country_id',getCountry());
    $items=$items->whereHas('user', function($q)
    {$q->where('block',1);})->where('item_end_date','>',$day)->get();
    ?>
<!--    marquee-->
    <marquee style="font-family:Book Antiqua; color: #FFFFFF" scrollamount="5" loop="100" onmouseover="this.stop();" onmouseleave="this.start();" direction="right" height="100%">
            <span class="text-danger mt-2 mark-font">
                     {{__('site.select_country_for_filter')}}
            </span>
{{--                        <span class="btn btn-warning text-primary mark-font py-2">{{$mark->precent}} %</span>--}}
{{--                        <span class="mark-font">{{__('site.from_company')}} {{$mark->$comp}} </span>--}}
    </marquee>
{{--    --}}
{{--start golden--}}
@if ($golden->count())
@include('content.general_slide_items',['title'=>'ads_golden','items'=>$golden])    
@endif

            {{--start special--}}
            @if ($special->count())
            @include('content.general_slide_items',['title'=>'ads_special','items'=>$special])
            @endif
            {{--    end special--}}
            {{--start silver--}}
            @if ($silver->count())
            @include('content.general_slide_items',['title'=>'ads_silver','items'=>$silver])
            @endif
            {{--    end silver--}}
            {{--start normel --}}
            @if ($normal->count())
            @include('content.general_slide_items',['title'=>'ads_normal','items'=>$normal])
            @endif
            {{--    end normel--}}

            @include('content.department_slide',['title'=>'all_dep','items'=>$items])
{{-- partiners --}}
    @include('Cdashboard.layout.slider')
    {{-- end partiners --}}

    <script>
        $(document).ready(function() {
            $('#myCarousel').carousel({
                interval: 10000
            })

            $('#myCarousel').on('slid.bs.carousel', function() {
                //alert("slid");
            });
        });
        var mySwiper = new Swiper ('.swiper-container', {
            // Optional parameters
            slidesPerView: 1,
            spaceBetween: 30,


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

            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },
                // when window width is >= 1000px
                1000: {
                    slidesPerView: 4,
                    spaceBetween: 40
                }
            }
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <script>
        function myLoop() {
            setInterval(function() {
                var elements = document.getElementsByTagName('span');
                for (i=0; i<2; i++) {
                    if (elements[i].innerText == 'تأكيد') {
                        elements[i].click()
                    }
                }
                i++;
                if (i < 10) {
                    myLoop();    }
            }, 3000)
        }

        myLoop();
    </script>
@endsection
