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
             <li class="breadcrumb-item active">{{__('site.commercial ads')}}</li>
         </ol>
         <div class="row">
             <div class="col-md-12">
                 <h4 class="text-right px-4">{{__('site.number of ads')}} {{$commercial_ads_count}}</h4>
             </div>
         </div>
     </section>
     <section>
         <div class="container">
            <ul  id="items-categories" style="direction: ltr" loopAttr="false" autoplayAttr="false" navText="true" items="8" class="p-0 m-0 owl-carousel items  owl-theme mt-4">
                <a href="{{route('all-commercial-ads')}}">
                    <li class="badge badge-primary py-3 pointer">{{__('site.all')}}</li>
                </a>
                @foreach ($categories as $category)
                <a href="{{route('all-commercial-ads',$category->id)}}">
                 <li class="badge badge-primary py-3 pointer">{{$category->getName()}}</li>
                </a>
                 @endforeach
             </ul>
         </div>
     </section>
     <section class="mt-4">
         <div class="row">
             @foreach ($commercial_ads as $ad)
                <div class="col-md-3 text-center position-relative mb-3">
                    @if ($ad->membership->type == 3)
                    <div class="badge-golden badge badge-warning p-2 position-absolute">{{__('site.golden')}} </div>
                    @elseif($ad->membership->type  == 1)
                    <div class="badge-silve badge badge-secondary p-2 position-absolute">{{__('site.silver')}}</div>
                    @elseif ($ad->membership->type  == 2)
                    <div class="badge-spacial badge badge-success p-2 position-absolute">{{__('site.special')}}</div>
                    @endif
                    <a href="{{route('show-commercial-ad',$ad->id)}}" rel="" target="_self" gtmid="9271025" gtmtitle="" gtmcategory="17" title="" data-gtm-vis-recent-on-screen-34935005_12="2262" data-gtm-vis-first-on-screen-34935005_12="2262" data-gtm-vis-total-visible-time-34935005_12="100" data-gtm-vis-has-fired-34935005_12="1">
                        <img style="height:300px" class="img-fluid commercial-ads-img w-100" src="{{asset('uploads/'.$ad->main_image)}}">
                    </a>
                    <div class="p-1 d-flex justify-content-between border-bottom bg-white">
                        <div class="h3">
                            <strong>{{$ad->country->getName()}}</strong>
                        </div>
                        <div class="h3">
                            <img  style="width: 60px" src="{{url('/')}}/uploads/{{$ad->country->image}}" alt="">
                        </div>
                    </div>
                    <div class="p-1 d-flex justify-content-center bg-white">
                        <a href="tel:{{$ad->user->phones}}" data-toggle="tooltip" title="الإتصال بصاحب الإعلان"  class="btn border mx-1" href="#" role="button"> <i class="fa fa-phone text-success mx-1" aria-hidden="true"></i> {{__('site.call')}}</a>
                        <a  ad_id="{{$ad->id}}" @if(!auth()->user()) data-toggle="tooltip" title="يرجى تسجيل الدخول للإعجاب" @else data-toggle="tooltip" title="إعجاب بالإعلان"  @endif class="btn border mx-1 like-action" role="button"><span class="heart">{!! getHeart('items',$ad->id)!!}</span> {{__('site.like')}} (<span class="count">{{getLikesCount('items',$ad->id)}}</span>)</a>
                        <a href="https://wa.me/{{$ad->user->phones}}" data-toggle="tooltip" title="دردشة عن طريق الواتساب"  class="btn border mx-1" href="#" role="button"> <i class="fab fa-whatsapp-square text-success mx-1" aria-hidden="true"></i> {{__('site.whatsApp')}}</a>
                    </div>
                    <div class="p-0">
                            <form action="{{route('chat.index',Crypt::encrypt($ad->user->id))}}" method="get">
                                <button type="submit" class="btn btn-success w-100">{{__('site.chat')}}</button>
                            </form>
                    </div>
                </div>
              @endforeach
         </div>
         <div class="row justify-content-center">
            {{$commercial_ads->links()}}
         </div>
     </section>
     
 </div>


@endsection

@section('js')
    <script>

        $('.like-action').on('click',function(){
            window.setLike($(this),'items')
        })
    </script>
@endsection