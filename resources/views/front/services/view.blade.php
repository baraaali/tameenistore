@extends('layouts.app')

@section('content')

<div class="container direction">
    <div class="p-3">
        <div class="col-md-12">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="w-100">
                        <div class="p-3 bg-white">
                        <div class="fotorama" data-width="1000"   data-maxheight="300" data-minwidth="1000"  data-nav="thumbs">
                            <img class="w-100" src="{{url('/')}}/uploads/{{$ad->image}}">
                            @if (isset($ad->images) && !empty($ad->images))
                            @foreach ($ad->images as $e)
                            <img    class="w-100"  src="{{url('/')}}/uploads/{{$e->file}}">
                            @endforeach
                            @endif
                        </div>
                       
                    </div>
                      
                    </div>
                    <div class="p-2 bg-white direction border-bottom">
                        <span class="badge badge-primary">{{$ad->cats->getName()}} </span>
                        <span class="badge badge-primary">{{$ad->subCats->getName()}} </span>
                        <span class="badge badge-primary"> {{$ad->MiniSubCats->getName()}} </span>
        
                    </div>
                   <div class="p-2 bg-white d-flex justify-content-between">
                       <div class="p-1 h3">
                           {{$ad->getName()}} 
                       </div>
                       <div class="p-1">
                           <i class="fa fa-eye text-success"></i> {{$ad->visitor}}
                       </div>
                   </div>

                    <div class="w-100">
                     <div class="p-3 bg-white mt-2">
                         <div class="d-flex justify-content-between">
                             <strong class="h1">
                                  <span class="text-dark"> {{$ad->price}}
                                    @if ($ad->country)
                                    {{$ad->country->getCurrency()}}
                                    @endif
                                </span>
                             </strong>
                             <div class="p-1">
                                <img  style="width: 50px" src="{{url('/')}}/uploads/{{$ad->country->image}}" alt="">
                            </div>

                         </div>
                     </div>
                     <div class="p-3 bg-white d-flex justify-content-center">

                        <a href="tel:{{$ad->users->phones}}" data-toggle="tooltip" title="الإتصال بصاحب الإعلان"  class="btn border mx-1" href="#" role="button"> <i class="fa fa-phone text-success mx-1" aria-hidden="true"></i> {{__('site.call')}}</a>
                        <a  ad_id="{{$ad->id}}" @if(!auth()->user()) data-toggle="tooltip" title="يرجى تسجيل الدخول للإعجاب" @else data-toggle="tooltip" title="إعجاب بالإعلان"  @endif class="btn border mx-1 like-action" role="button"><span class="heart">{!! getHeart('services',$ad->id)!!}</span> {{__('site.like')}} (<span class="count">{{getLikesCount('services',$ad->id)}}</span>)</a>
                        <a href="https://wa.me/{{$ad->users->phones}}" data-toggle="tooltip" title="دردشة عن طريق الواتساب"  class="btn border mx-1" href="#" role="button"> <i class="fab fa-whatsapp-square text-success mx-1" aria-hidden="true"></i> {{__('site.whatsApp')}}</a>

                    </div>
  
                      <div class="mt-3 bg-white p-3">
                        <h5 class="font-weight-bold">الوصف</h5> 
                        <p>   {!!$ad->getDescription()!!}</p>
                        <div class="d-flex justify-content-end">
                            <a id="notify-ad" class="btn border text-second  text-danger" href="#" role="button"><i class="fas fa-info-circle mx-1 "></i> {{__('site.notify')}}</a>
                            <form id="notify-ad-form" action="{{route('user_notify')}}" method="post">
                                @csrf
                                <input type="hidden" name="ads_id" value="{{$ad->id}}">
                            </form>
                        </div>
                     </div>
                 
                    </div>
                   
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
         $('.like-action').on('click',function(){
            window.setLike($(this),'services')
        })
        $('#notify-ad').on('click',function(){
            $('#notify-ad-form').submit()
        })
    </script>

@endsection