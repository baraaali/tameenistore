<div class="row">
    @foreach ($agencies as $agency)
<div class="col-md-4 mb-4">
    <a  class="text-decoration-none" href="{{route('single-rental-agencies',$agency->id)}}">

        <div class="card">
             <img style="height:300px" src="{{url('/')}}/uploads/{{$agency->image}}"
             class="card-image w-100" alt="{{$agency->getName()}}" >
       
            
</a>
<div class="w-100">
    <h3 class="direction p-3">{{$agency->getName()}}</h3>
</div>
        {{--  like-action --}}
            <div class="d-flex p-2 justify-content-between border-bottom">
                
                <div class="h3">
                    <img  style="width: 60px" src="{{url('/')}}/uploads/{{$agency->country->image}}" alt="">
                </div>
                <div class="h3">
                    <i class="fa fa-car text-info"></i> ({{$agency->carsCount()}})
                </div>
            
                <div @if(!auth()->user()) data-toggle="tooltip" title="يرجى تسجيل الدخول للإعجاب" @else data-toggle="tooltip" title="إعجاب بالإعلان"  @endif class="h3 like-action" ad_id="{{$agency->id}}">
                    <span class="heart">{!! getHeart('rental_agencie',$agency->id)!!}</span>
                    (<span class="count">{{getLikesCount('rental_agencie',$agency->id)}}</span>)
                </div>
            </div>
            {{--  end like-action --}}
            <a  class="text-decoration-none" href="{{route('single-rental-agencies',$agency->id)}}">

            <div class="d-flex p-2 justify-content-between">
                @if ($agency->country)
                <p>
                    <span class="second-detail margin-right">
                        <i class="fa fa-map-marker-alt" aria-hidden="true"></i>
                        {{$agency->country->getName()}}
                    </span>
                </p>
                @endif
                <p class="second-title">
                    <span class="second-detail">
                        <i class="fa fa-eye"></i> {{$agency->visitors}}
                    </span>
                </p>
               
               
            </div>
            <div class="w-100">
                <button style="height: 50px" type="button" class="btn btn-primary w-100">معاينة</button>
            </div>
          
   
    </div>
    </a>
</div>
@endforeach

</div>
<div class="row justify-content-center">
    {{$agencies->links()}}
 </div>