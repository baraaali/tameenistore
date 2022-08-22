@if (!count($services))
<div class="d-block text-center">{{__('site.no ads')}}</div>
@else

<div class="row">
    @foreach ($services as $ad)
       <div class="col-md-3 text-center position-relative">
           @if ($ad->membership->type == 3)
           <div class="badge-golden badge badge-warning p-2 position-absolute">{{__('site.golden')}} </div>
           @elseif($ad->membership->type  == 1)
           <div class="badge-silve badge badge-secondary p-2 position-absolute">{{__('site.silver')}}</div>
           @elseif ($ad->membership->type  == 2)
           <div class="badge-spacial badge badge-success p-2 position-absolute">{{__('site.special')}}</div>
           @endif
           <a href="{{route('services-single',$ad->id)}}" >
               <img style="height:200px" class="img-fluid commercial-ads-img w-100" src="{{asset('uploads/'.$ad->image)}}">
           </a>
            <div class="p-2 bg-white direction border-bottom">
                <span class="badge badge-primary">{{$ad->cats->getName()}} </span>
                <span class="badge badge-primary">{{$ad->subCats->getName()}} </span>
                <span class="badge badge-primary"> {{$ad->MiniSubCats->getName()}} </span>

            </div>
           <div class="p-2 bg-white d-flex justify-content-between">
               <div class="p-1">
                   {{$ad->getName()}} 
               </div>
               <div class="p-1">
                   <i class="fa fa-eye text-success"></i> {{$ad->visitor}}
               </div>
           </div>
           <div class="p-2 bg-white d-flex justify-content-between">
               <div class="p-1 font-weight-bold">
                   {{$ad->price}} {{$ad->country->getCurrency()}}
               </div>
               <div class="p-1">
                   <img  style="width: 50px" src="{{url('/')}}/uploads/{{$ad->country->image}}" alt="">
               </div>
               
           </div>
         
           <div class="d-flex p-1 bg-white border-top justify-content-center">
               <a href="tel:{{$ad->users->phones}}" data-toggle="tooltip" title="الإتصال بصاحب الإعلان"  class="btn border mx-1" href="#" role="button"> <i class="fa fa-phone text-success mx-1" aria-hidden="true"></i> {{__('site.call')}}</a>
               <a  ad_id="{{$ad->id}}" @if(!auth()->user()) data-toggle="tooltip" title="يرجى تسجيل الدخول للإعجاب" @else data-toggle="tooltip" title="إعجاب بالإعلان"  @endif class="btn border mx-1 like-action" role="button"><span class="heart">{!! getHeart('services',$ad->id)!!}</span> {{__('site.like')}} (<span class="count">{{getLikesCount('services',$ad->id)}}</span>)</a>
               <a href="https://wa.me/{{$ad->users->phones}}" data-toggle="tooltip" title="دردشة عن طريق الواتساب"  class="btn border mx-1" href="#" role="button"> <i class="fab fa-whatsapp-square text-success mx-1" aria-hidden="true"></i> {{__('site.whatsApp')}}</a>
           </div>
       </div>
     @endforeach
</div>

<div class="row justify-content-center">
    {{$services->links()}}
 </div>

 @endif