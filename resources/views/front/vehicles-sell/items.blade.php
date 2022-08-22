
@if (!$cars->count())
<br>
<label class="d-block  text-center">
    {{__('site.no cars')}}
</label>
<br>
@endif
<div class="row">
    @foreach ($cars as $car)
 <?php
$rel=$car->memberships;
$day = date('Y-m-d');
?>
<div class="col-md-4 mb-4">
    <a  class="text-decoration-none" href="{{URL::route('vehicles-sell-view', [$car->id,app()->getLocale()] )}}">

        <div class="card">
            @if($rel->type == 3)
        <div class="badge badge-golden p-2 position-absolute">
            {{__('site.golden')}}
        </div>
        @elseif($rel->type == 2)
        <div class="badge badge-spacial p-2 position-absolute">
            {{__('site.special')}}
        </div>
        @elseif($rel->type == 1)
        <div class="badge badge-silver p-2 position-absolute">
            {{__('site.silver')}}
        </div>
        @endif
     

            {{-- @if($car->Price->discount_percent>0&& $car->Price->discount_end_date>$day)
                <span class="notify-badge">{{$car->Price->discount_percent}}%</span>
            @endif --}}
                <img style="height:300px" src="{{url('/')}}/uploads/{{$car->main_image}}"
                     class="card-image w-100" alt="{{$car->getName()}}" style="width: 100%">
            <div class="col-md-12">
            
            @if ($car->talap == 1 )
            <span class="badge badge-success text-white"> مطلوب</span>
            @else 
            <span class="badge badge-info text-white"> معروض</span>
            @endif
                @if ($car->used == "1" )
                <span class="badge badge-success  text-white mx-1 p-1">جديد</span>
                @else
                <span class="badge badge-secondary text-white mx-1 p-1">مستعمل</span>
             @endif
            @if (isset($car->agents) )
            <span class="badge badge-info text-white">وكالة</span>
            @else 
            <span class="badge badge-info text-white"> بائع</span>
        @endif
            </div>
              <div class="d-flex p-2 justify-content-between border-bottom">
                <div class="w-100">
                    <h4 class="card-title text-dark">
                        @if ($car->brand)
                        <img  style="width: 60px" src="{{url('/')}}/uploads/{{$car->brand->image}}" alt="">
                        @endif
                        <span>{{$car->getName()}}</span>
                    </h4>
                </div>
            </div>
        </a>
        {{--  like-action --}}
            <div class="d-flex p-2 justify-content-between border-bottom">
                <div class="h3">
                    <img  style="width: 60px" src="{{url('/')}}/uploads/{{$car->country->image}}" alt="">
                </div>
                <div class="h3 text-dark font-weight-bold">
                        {{$car->Price->cost}} 
                        @if ($car->country)
                        {{$car->country->getCurrency()}}
                        @endif
                </div>
                <div @if(!auth()->user()) data-toggle="tooltip" title="يرجى تسجيل الدخول للإعجاب" @else data-toggle="tooltip" title="إعجاب بالإعلان"  @endif class="h3 like-action" ad_id="{{$car->id}}">
                    <span class="heart">{!! getHeart('vehicles_sell',$car->id)!!}</span>
                    (<span class="count">{{getLikesCount('vehicles_sell',$car->id)}}</span>)
                </div>
            </div>
            {{--  end like-action --}}
            <a  class="text-decoration-none" href="{{URL::route('vehicles-sell-view', [$car->id,app()->getLocale()] )}}">

            <div class="d-flex p-2 justify-content-between">
                @if ($car->governorate && $car->country)
                <p>
                    <span class="second-detail margin-right">
                        <i class="fa fa-map-marker-alt" aria-hidden="true"></i>
                        {{$car->governorate->getName()}},  {{$car->country->getName()}}
                    </span>
                </p>
                @endif
                <p class="second-title">
                    <span class="second-detail">
                        <i class="fa fa-eye"></i> {{$car->visitors}}
                    </span>
                </p>
               
            </div>
            <div class="d-flex pb-2 mx-2 justify-content-between">
                <p>
                    <span class="second-detail margin-right">
                        {{-- <i class="far fa-clock"></i>  {{Carbon\Carbon::parse($car->end_ad_date)->toFormattedDateString()}} --}}
                        <i class="far fa-clock"></i>  {{format_interval($car->created_at)}}
                    </span>
                </p>
            </div>
   
            <div class="third-title border-top border-bottom px-3 pt-3">
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
                <div class="w-100 bg-white mt-3">
                        <div class="row">
                            <div class="col-md-6 p-0 m-0">
                                <a  href="https://wa.me/{{$car->user->phones}}"  data-toggle="tooltip" title="دردشة عن طريق الواتساب"   style="height: 60px;line-height:40px" class="btn border my-1 w-100" >  <strong> <i class="fab  fa-whatsapp-square text-success mx-1" ></i> {{__('site.whatsApp')}}  </strong></a>
                            </div>
                            <div class="col-md-6 p-0 m-0">
                                <a   href="tel:{{$car->user->phones}}" data-toggle="tooltip"   title="الإتصال بصاحب الإعلان"  style="height: 60px;line-height:40px" class="btn border my-1 w-100"  > <strong> <i class="fa fa-phone text-success mx-1" aria-hidden="true"></i> {{__('site.phone number')}}  </strong></a>
                            </div>
                    </div>
    
                </div>
            </div>
            <div class="w-100">
                <form class="p-0 w-100" action="{{route('chat.index',Crypt::encrypt($car->user->id))}}" method="get">
                    <button style="height: 50px" type="submit" class="btn btn-success w-100">{{__('site.chat')}}</button>
                </form>
           </div>
        </div>
    </a>
</div>
@endforeach
</div>

<div class="row justify-content-center">
    {{$cars->links()}}
 </div>