@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css" integrity="sha512-nSomje7hTV0g6A5X/lEZq8koYb5XZtrWD7GU2+aIJD35CePx89oxSM+S7k3hqNSpHajFbtmrjavZFxSEfl6pQA==" crossorigin="anonymous" />
<style>
    .swiper-container {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .PageCard {
        margin-top: 10px;
        background-image: url({{asset('/bg.jpg')}});
    }
    .backgroundSR {
        background: url({{asset('/car3.jpg')}});
        background-position: center;
        background-size: cover;
        height: 100px;
        position: relative;
    }
    .background_dep {
        background: url({{asset('/bg.jpg')}});
        background-position: center;
        background-size: cover;
        position: relative;
    }
    .layerSR {
        background-color: rgba(30,68,122,.8);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<?php
$day = date('Y-m-d');
?>
    <div class="container">
        <div id="HomePage py-3" >
            <div class="card PageCard">
                <div class="card-body" style="padding:0px;">
                    <h5 class="card-title CT1"><i class="fa fa-car"></i>{{__('site.all_dep')}}</h5>
                    <h6 class="text-muted desc-textpg"><span style="font-weight:bold;">{{__('site.are_u_have_agency')}} </span> {{__('site.u_can_do')}}</h6>
                    <div class="clr"></div>
                    <div class="backgroundSR clearfix2 display-desk">
                        <div class="layerSR">
                            <form action="{{route('searchDepartment',$lang)}}" method="post" class="formsrchSR">
                                @csrf
                                <div class="row pt-4">
                                    <div class="colum col-sm-2 ">
                                        <input type="number" name="start_price" class="btn btn-light SpecificInput" placeholder="{{__('site.start_price')}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="colum col-sm-2 ">
                                        <input type="number" name="end_price" class="btn btn-light SpecificInput" placeholder="{{__('site.to_price')}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="colum col-sm-2 ">
                                        <input type="text" name="name" class="btn btn-light SpecificInput" placeholder="{{__('site.by_name')}}">
                                    </div>

                                    <div>
                                        <button type="submit" name="search" class="btn btn-primary"><i class="fa fa-search"></i> بحث </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            @include('dashboard.layout.message')
            @foreach($items as $item)
                    <div class="col-md-4">
                        <div class="card" style="padding:20px;height:400px;">
                            <div class="" style="height:150px">

{{--                                    @foreach($item->images as $image)--}}
                                      <div class="">
                                          @if($item->dicount_percent>0 && $item->end_date>$day)
                                              <span class="notify-badge mtop-20">{{$item->dicount_percent}}%</span>
                                          @endif
{{--                                             <img src="{{url('/')}}/uploads/{{$item->main_image}}" style="width:100%;height:150px;" />--}}
                                          <a data-fancybox="cats" href="{{url('/')}}/uploads/{{$item->main_image}}"  >
                                              <img src="{{url('/')}}/uploads/{{$item->main_image}}" alt="" class="img-thumbnail" style="width:100%;height:200px; margin-bottom: 20px" >
                                          </a>
                                        </div>
{{--                                    @endforeach--}}
                                    </div>
                                    <!-- Add Arrows -->
                            <hr>
                            <div class="cost-holder" Style="z-index:999">
			                            {{$item->price}} {{$item->country->en_currency}}
			                        </div>
                            <?php
                                $name = app()->getLocale().'_name';
                                $desc = app()->getLocale().'_desciption';
                            ?>

                            <p class="card-hint-line" style="">
			                            <span class="hint-line badge badge-danger" style="color:white;font-weight:100">
			                                <i class="fa fa-map-marker-alt"></i>
			                               @if(app()->getLocale() == 'ar')
			                                {{$item->country->ar_name}}
			                               @else
			                                {{$item->country->en_name}}
			                               @endif
			                            </span>

			                        </p>
			                        <p class="card-title">
                                        <a href="{{route('showCat',['id'=>$item->id,'lang'=>$lang])}}">
			                            {{\Illuminate\Support\Str::limit($item->$name, 30 )}}
                                        </a>

			                        </p>
			                        <p class="second-title">
			                            {{\Illuminate\Support\Str::limit($item->$desc,30 )}}
			                       </p>
			                       <hr>
                            <small class="text-muted">{{Carbon\Carbon::parse($item->end_ad_date)->toFormattedDateString()}}</small>
                            <hr>
			                       <a href="{{route('showCat',['id'=>$item->id,'lang'=>$lang])}}">
			                       <button class="btn btn-dark btn-block">
			                           <i class="fas fa-phone"></i> {{__('site.show')}}
			                       </button>
			                       </a>
                        </div>
                    </div>
            @endforeach
        </div>
          {{$items->links()}}
    </div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js" integrity="sha512-ZHauUc/vByS6JUz/Hl1o8s2kd4QJVLAbkz8clgjtbKUJT+AG1c735aMtVLJftKQYo+LD62QryvoNa+uqy+rCHQ==" crossorigin="anonymous"></script>
  <script>
    var swiper = new Swiper('.swiper-container', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>
@endsection
