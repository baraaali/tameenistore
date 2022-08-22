<div class="col-md-12  my-3 bg-white p-3">
    <div class="row">

      <div class="col-md-4">
          <a href="{{URL::route('vehicles-sell-view', [$car->id,app()->getLocale()] )}}">
          <img style="height:220px" src="{{url('/')}}/uploads/{{$car->main_image}}"
          class="card-image w-100" alt="{{$car->getName()}}" style="width: 100%">
          <div class=" d-flex justify-content-center mt-1 direction">

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
              
      </a>
          </div>
         </div>
         <div class="col-md-8 direction">
      
            <a href="{{URL::route('vehicles-sell-view', [$car->id,app()->getLocale()] )}}">
                <div class="d-flex p-2 justify-content-between mb-2">
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
            <div class="d-flex justify-content-between">
                <div class="h3 text-primary font-weight-bold">
                    {{$car->Price->cost}} 
                    @if ($car->country)
                    {{$car->country->getCurrency()}}
                    @endif
                </div>
                <div @if(!auth()->user()) data-toggle="tooltip" title="يرجى تسجيل الدخول للإعجاب" @else data-toggle="tooltip" title="إعجاب بالإعلان"  @endif class="h3 like-action" ad_id="{{$car->id}}">
                    <span class="heart">{!! getHeart('vehicles_sell',$car->id)!!}</span>
                    (<span class="count">{{getLikesCount('vehicles_sell',$car->id)}}</span>)
                    <span class="second-detail mx-2">
                        <i class="fa fa-eye text-success"></i> ({{$car->visitors}})
                    </span>
                </div>
            </div>
            
            <div class="d-flex pb-2 mx-2 justify-content-between">
            <p>
                <span class="second-detail margin-right">
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
       </div>
    </div>
    
</div>
    
