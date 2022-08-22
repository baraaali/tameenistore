@extends('layouts.app')
@section('content')
<?php 

use Carbon\Carbon;

?>
<div class="col-lg-12 cover-adv" style="background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
	@if(app()->getLocale() == 'ar')

        <div class="upper">
        <h2 class="place"style="margin: 0px auto;"> المعارض
            <br>
            <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
         <p style="font-size: 16px">سوف تجد   <span class="type"></span></p>
     </div> 
    @else

    <div class="upper">
        <h2 class="place"style="margin: 0px auto;">EXH<span style="border-bottom: 2px solid #0674FD;">IBI</span>TOR</h2><br>
         <p style="font-size: 16px">Come And find Your <span class="type"></span></p>
     </div>

    @endif
</div>

<?php 
    
    $exhibitors = \App\Exhibition::where('status',1)->orderBy('id','desc')->get();


?>
<div class="col-lg-12">
  <div class="container">
    <div class="row">
        <div class="col-lg-12">
            @foreach($exhibitors as $exhibitor)
    <a href="{{route('exhibitors-details',['id'=>$exhibitor->id])}}" style="text-decoration:none">
    <div class="col-lg-12" style="margin-top:25px;border:1px solid #d3d3d3;border-radius:5px;">
        <div class="row">
            <div class="col-lg-2" style="padding-left:0px;padding-right:0px;">
                <img src="{{url('/')}}/uploads/{{$exhibitor->image}}" style="width:100%;height:100%">
            </div>
            <div class="col-lg-10" style="padding-left:0xp;padding-right:0px;">
        <div class="section-3">
            
            <div class="container-fluid">
               <h4 style="display: inline-block;font-weight: 600;font-size:20px;">
                   @if(app()->getLocale() == 'ar')
                    {{$exhibitor->ar_name}}
                   @else
                    {{$exhibitor->ar_name}}

                   @endif
               </h4>
               <button class="btn btn-light top" style="font-size:12px; font-weight: 600;background-color: white">
                <i class="fa fa-map-marker"></i> 
                @if(app()->getLocale() == 'ar')
                    {{$exhibitor->country->ar_name}}
                @else
                    {{$exhibitor->country->en_name}}
                @endif
               </button>

              

                @if($exhibitor->special == 3)
                <button class="btn btn-warning top" style="font-size:12px; font-weight: 600;">
                <i class="fa fa-star"></i>
                @if(app()->getLocale() == 'ar')
                        ذهبي
                @else
                     GOLD
                @endif
               </button>

                @elseif ($exhibitor->special == 2)
                <button class="btn btn-light top" style="font-size:12px; font-weight: 600;">
                <i class="fa fa-star"></i> 
                @if(app()->getLocale() == 'ar')
                    فضي
                @else
                    Silver
                @endif
               </button>

                @elseif ($exhibitor->special == 1)
                <button class="btn btn-primary top" style="font-size:12px; font-weight: 600;">
                <i class="fa fa-star"></i> 
                @if(app()->getLocale() == 'ar')
                    برونزي
                @else
                    Bronze
                @endif
               </button>

                @endif



               <hr>
               <div class="breakLineForDiv p-r">
                   
               </div>
               
            </div>


                <div class="container-fluid">
                   {!! $exhibitor->ar_description !!}
                </div>
        </div>
        </div>
        </div>
    </div>
    </a>
@endforeach
        </div>
        <!--<div class="col-lg-4">-->
        <!--    <div class="col-lg-12" style="border:1px solid #d3d3d3;border-radius:5px;padding:10px;margin-top: 25px;">-->
        <!--        <h5>هل لديك معرض ترغب في تسجيله؟</h5>-->
        <!--        <hr>-->
        <!--        <p>هل أنت من أصحاب المعارض ؟ يمكنك إضافة معرضك معنا وعرض سياراتك على الموقع</p>-->
        <!--        <button class="btn btn-primary col-lg-12" style="padding: 30px;font-size: 20px;">+سجل معرضك الأن</button>-->
        <!--    </div>-->
            
        <!--    <div class="col-lg-12 banner" style="background-color:grey;border-radius:5px;height:600px;margin-top:20px;">-->
                
        <!--    </div>-->
        <!--</div>-->
    </div>
  </div>    
</div>







<script>
  var mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    slidesPerView: 3,
    spaceBetween: 60,
    loop: true,

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
        // when window width is <= 499px
        499: {
            slidesPerView: 1,
            spaceBetweenSlides: 50
        },
        // when window width is <= 999px
        999: {
            slidesPerView: 3,
            spaceBetweenSlides: 50
        }
    }
  })
  </script>
  <script src="{{url('/')}}/js/type.js"></script>
<script src="{{url('/')}}/js/typed.js"></script>

@if( app()->getLocale() == 'ar')
<script>
var typed = new Typed(".type", {
  strings: ["سيارات مستخدم",
   "سيارات جديدة",
   "سيارات مجددة"],
  typeSpeed: 60,
  backSpeed: 60,
  loop: true,


});

</script>
@else
<script>
var typed = new Typed(".type", {
  strings: ["Used Car",
   "New Car",
   "Recondiational Car"],
  typeSpeed: 60,
  backSpeed: 60,
  loop: true,


});

</script>
@endif
@endsection