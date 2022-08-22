@extends('layouts.app')


@section('content')
<div class="container">
  <!-- start  banner-->
  <div style="direction: ltr" class="owl-carousel banners owl-theme">
    @foreach ($banners as $banner)
    <div class="item"><img src="{{asset('uploads/'.$banner->file)}}"></div>
    @endforeach
</div>         
<!-- end banner -->
 <div class="container">
     <section>
         <ol class="breadcrumb bg-light">
             <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('site.home')}}</a></li>
             <li class="breadcrumb-item"></li>
             <li class="breadcrumb-item active">{{__('site.sales agencies')}}</li>
         </ol>
     </section>

     <section class="mt-4">
         @include('front.sales-agencies.items')
     
     </section>
     
 </div>


@endsection

@section('js')
    <script>

        $('.like-action').on('click',function(){
            window.setLike($(this),'sales_agencie')
        })
    </script>
@endsection