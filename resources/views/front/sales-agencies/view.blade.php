@extends('layouts.app')


@section('content')
<div class="container">
<div class="row">
<div class="col-md-4 mb-4">
        <div class="card">
             <img style="height:300px" src="{{url('/')}}/uploads/{{$agency->image}}"
             class="card-image w-100" alt="{{$agency->getName()}}" >
<div class="w-100">
    <h3 class=
    "direction p-3">{{$agency->getName()}}</h3>
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
                    <span class="heart">{!! getHeart('sales_agencie',$agency->id)!!}</span>
                    (<span class="count">{{getLikesCount('sales_agencie',$agency->id)}}</span>)
                </div>
            </div>
            {{--  end like-action --}}
            

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
</div>   
</div>
<div class="col-md-8">
    <div class="row">
        <ul class="nav nav-tabs w-100 bg-white">
            <li class="nav-item w-50 ">
              <a class="nav-link active" data-toggle="tab" href="#new">سيارات جديدة </a>
            </li>
            <li class="nav-item w-50">
              <a class="nav-link" data-toggle="tab" href="#old">سيارات مستعملة</a>
            </li>
          </ul>
          
          <!-- Tab panes -->
          <div class="tab-content w-100">
              @if (count($agency->cars ))
            <div class="tab-pane container active p-0" id="new">
                @foreach ($agency->cars as $car)
                @if ($car->used == "1")
                @include('front.sales-agencies.car')
                @endif
                @endforeach
            </div>
            <div class="tab-pane container fade p-0" id="old">
                @foreach ($agency->cars as $car)
                @if ($car->used != "1")
                @include('front.sales-agencies.car')
                @endif
                @endforeach
            </div>
            @else
            <p class="text-center p-3 mt-4">لا يوجد سيارات</p>
            @endif
          </div>
      
    </div>
</div>

</div>
@endsection

@section('js')
    <script>

        $('.like-action').on('click',function(){
            window.setLike($(this),'sales_agencie')
        })
    </script>
@endsection