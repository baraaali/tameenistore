@extends('layouts.app')


@section('content')
<article class="bg-white my-3">
    <section>
        <a class="btn border float-right text-second mt-4 mr-4" href="{{route('all-commercial-ads')}}" role="button"><i class="fas fa-undo-alt"></i> {{__('site.back')}}</a>
        <a id="notify-ad" class="btn border float-left text-second mt-4 ml-4 text-danger" href="#" role="button"><i class="fas fa-info-circle mx-1 "></i> {{__('site.notify')}}</a>
        <div class="container  p-4">
            <div class="p-2">
                <h1 class="text-center">{{$ad->getName()}}</h1>
            </div>
            <div class="p-2">
                <img width="40%" class="d-block m-auto" src="{{asset('uploads/'.$ad->main_image)}}" >
                <div class="p-1 d-flex justify-content-between border-bottom bg-white">
                    <div class="h3">
                        <strong>{{$ad->country->getName()}}</strong>
                    </div>
                    <div class="h3">
                        <img  style="width: 60px" src="{{url('/')}}/uploads/{{$ad->country->image}}" alt="">
                    </div>
                </div>
            </div>
           
            <div class="p-4 text-center">
                {{__('site.visitors')}} ({{$ad->visitors}})
            </div>
            
            <div class="my-3 d-flex justify-content-center">
                <a href="tel:{{$ad->user->phones}}" data-toggle="tooltip" title="الإتصال بصاحب الإعلان"  class="btn border mx-1" href="#" role="button"> <i class="fa fa-phone text-success mx-1" aria-hidden="true"></i> {{__('site.call')}}</a>
                <a  ad_id="{{$ad->id}}" @if(!auth()->user()) data-toggle="tooltip" title="يرجى تسجيل الدخول للإعجاب" @else data-toggle="tooltip" title="إعجاب بالإعلان"  @endif class="btn border mx-1 like-action" role="button"><span class="heart">{!! getHeart('items',$ad->id)!!}</span> {{__('site.like')}} (<span class="count">{{getLikesCount('items',$ad->id)}}</span>)</a>
                <a href="https://wa.me/{{$ad->user->phones}}" data-toggle="tooltip" title="دردشة عن طريق الواتساب"  class="btn border mx-1" href="#" role="button"> <i class="fab fa-whatsapp-square text-success mx-1" aria-hidden="true"></i> {{__('site.whatsApp')}}</a>
            </div>
            <div class="w-100">
                <form class="w-25 d-block m-auto" action="{{route('chat.index',Crypt::encrypt($ad->user->id))}}" method="get">
                    <button type="submit" class="btn btn-success w-100">{{__('site.chat')}}</button>
                </form>
        </div>
        </div>
    </section>
    <section>
        <div class="container">
            <h3 class="text-right"> {{__('site.related commercial ads')}} </h3>
            <div style="direction: ltr" class="owl-carousel items items-single-ad owl-theme mt-4">
                @foreach ($related_ads as $ad)
                <a href="{{route('show-commercial-ad',$ad->id)}}">
                    <div class="item"><img  style="height:300px" src="{{asset('uploads/'.$ad->main_image)}}"></div>  
                </a>
                    @endforeach
            </div>
            
        </div>
    </section>
</article>
<form id="notify-ad-form" action="{{route('user_notify')}}" method="post">
    @csrf
    <input type="hidden" name="ads_id" value="{{$ad->id}}">
</form>
@endsection
@section('js')
    <script>

        $('.like-action').on('click',function(){
            window.setLike($(this),'items')
        })
        $('#notify-ad').on('click',function(){
            $('#notify-ad-form').submit()
        })
    </script>
@endsection