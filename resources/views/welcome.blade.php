
@extends('layouts.app')

@section('content')
<div class="page-content index">
    <div class="container">
    <!-- start  banner-->
        <div style="direction: ltr" class="owl-carousel banners owl-theme">
            @foreach ($banners as $banner)
            <div class="item"><img src="{{asset('uploads/'.$banner->file)}}"></div>
            @endforeach
     </div>         
    <!-- end banner -->
    <!-- start groups -->
    <div class="groups_container">
        @if($commercial_ads->count())
         <div class="w-100">
            <div class="group_title">
                <div class="group_icon">
                    <span class="div_icon">
                        <i class="fas fa-bullhorn"></i>
                    </span>
                    <div class="group_name"> {{__('site.commercial ads')}} </div>
                    <div class="group_name float-left px-3">  <a class="mx-1" href="{{route('all-commercial-ads')}}">{{__('site.read more')}} </a> <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>  </div>
                </div>
            </div>
            <div class="group_body pointer">
                <div style="direction: ltr" items="{{intval($commercial_ads->count()) >= 4 ? 4 :  intval($commercial_ads->count())}} " class="owl-carousel items items-welcome owl-theme">
                    @foreach ($commercial_ads as $ad)
                    <a href="{{route('show-commercial-ad',$ad->id)}}">
                        <div class="item"><img  style="height: 300px" src="{{asset('uploads/'.$ad->main_image)}}"></div>  
                    </a>
                        @endforeach
                </div>
           </div>
         </div>
         @endif
         <!--start assurance -->
       <div class="w-100">
        <div class="group_title">
            <div class="group_icon">
                <span class="div_icon">
                    <i class="fas fa-file-contract"></i>
                </span>
                <span class="group_name"> التأمين </span>
            </div>
        </div>
        <div class="group_body row">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('insurance-complete')}}" class="category_link"
                    title="التأمين الشامل" alt="التأمين الشامل">
                    <div class="category_image">
                        <img src="{{asset('assets_web/images/assur2.jpg')}}"
                            alt="التأمين الشامل" title="التأمين الشامل" />
                    </div>
                    <div class="category_name">التأمين الشامل</div>
                </a>
                </div>
                <div class="col-md-6">
                    <a href="{{route('insurance-single')}}" class="category_link"
                    title="التأمين ضد الغير" alt="التأمين ضد الغير">
                    <div class="category_image">
                        <img src="{{asset('assets_web/images/assur1.jpg')}}"
                            alt="التأمين ضد الغير" title="التأمين ضد الغير" />
                    </div>
                    <div class="category_name">التأمين ضد الغير</div>
                </a>
                </div>
            </div>
            <div class="w-100">
                <div class="group_title my-1">
                    <div class="group_icon">
                        <span class="group_name"> شركاؤنا </span>
                    </div>
                </div>

                <div style="direction: ltr"  items="{{intval($insurances->count()) >= 4 ? 4 :  intval($insurances->count())}} "  class="owl-carousel items-sub owl-theme">
                    @foreach ($insurances as $logo => $id)
                    <div class="item"><img height="200px" src="{{url('/')}}/uploads/{{$logo}}"></div>  
                    @endforeach
    
                    
                </div>
            </div>
         
        </div>
    </div>
 
         <!--  end assurance-->
        <div class="row">
              <!-- cars for sell -->
        <div class="col-md-6">
            <div class="group_title">
                <div class="group_icon">
                    <span class="div_icon">
                        <i class="fas fa-taxi"></i>
                    </span>
                   <a href="{{route('vehicles-sell','all')}}"> <span class="group_name"> مركبات للبيع </span></a> 
                    <span class="ads_count"> ({{$vehicles_sell_count}} إعلان ) </span>
                </div>
            </div>
            <div class="group_body row">
           
            @foreach ($vehicles as $vehicle)
            <div class="category_container">
                <a href="{{route('vehicles-sell',$vehicle->id)}}" class="category_link" >
                    <div class="category_image">
                        <img  style="height: 200px" src="{{ asset('uploads/vehicles/'.$vehicle->image) }}"
                            alt="{{$vehicle->getName()}}"  />
                    </div>
                    <div class="category_name">{{$vehicle->getName()}}</div>
                </a>
            </div>
            @endforeach
            </div>
        </div>
        <!-- end cars for sell -->
        <!-- cars for rent -->
             <div class="col-md-6">
                <div class="group_title">
                    <div class="group_icon">
                        <span class="div_icon">
                            <i class="fas fa-taxi"></i>
                        </span>
                        <a href="{{route('vehicles-rent','all')}}"> <span class="group_name"> مركبات للكراء </span></a> 
                        <span class="ads_count"> ({{$vehicles_rent_count}} إعلان ) </span>
                    </div>
                </div>
                <div class="group_body row">
                  
            @foreach ($vehicles as $vehicle)
            <div class="category_container">
                <a href="{{route('vehicles-rent',$vehicle->id)}}" class="category_link" >
                    <div class="category_image">
                        <img style="height: 200px" src="{{ asset('uploads/vehicles/'.$vehicle->image) }}"
                            alt="{{$vehicle->getName()}}"  />
                    </div>
                    <div class="category_name">{{$vehicle->getName()}}</div>
                </a>
            </div>
            @endforeach
                </div>
            </div>
        <!-- end cars for rent -->
        </div>

        <!-- start agents -->
              <!--start assurance -->
       <div class="w-100">
        <div class="group_title">
            <div class="group_icon">
                <span class="div_icon">
                    <i class="fas fa-file-contract"></i>
                </span>
                <span class="group_name"> وكالات </span>
            </div>
        </div>
        <div class="group_body">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('sales-agencies')}}" class="category_link"
                    title="وكالات البيع" alt="وكالات البيع">
                    <div class="category_image">
                        <img width="100%" src="{{asset('assets_web/images/agent_rent.jpeg')}}"
                            alt="وكالات البيع" title="وكالات البيع" />
                    </div>
                    <div class="category_name">وكالات البيع</div>
                </a>
                </div>
                <div class="col-md-6">
                    <a href="{{route('rental-agencies')}}" class="category_link"
                    title="وكالات التأجير" alt="وكالات التأجير">
                    <div class="category_image">
                        <img  width="100%" src="{{asset('assets_web/images/agent_rent.jpeg')}}"
                            alt="وكالات التأجير" title="وكالات التأجير" />
                    </div>
                    <div class="category_name">وكالات التأجير</div>
                </a>
                </div>
            </div>
         
        </div>
    </div>
        <!-- end agents -->
        <!-- start cars services -->
        <div class="row">
            <div class="col-md-12">
                <div class="group_title">
                    <div class="group_icon">
                        <span class="div_icon">
                            <i class="fas fa-tools"></i>
                        </span>                 
                      <a href="{{route('services-vehicles','all')}}"><span class="group_name">  خدمات المركبات</span></a> 
                    </div>
                </div>
                <div class="group_body row">
                @foreach ($services_vehicles as $service)
                    <div class="col-md-3 my-1">
                        <a href="{{route('services-vehicles',$service->id)}}" class="category_link">
                            <div class="category_image bg-white  my-1">
                                <img style="height: 250px" src="{{ asset('uploads/'.$service->image) }}" />
                            </div>
                            <div class="category_name">{{$service->getName()}}</div>
                        </a>
                    </div>
                    @endforeach
                   
                 
                
                   
                </div>
            </div>
        </div>
        <!-- end cars services -->
          <!-- start  services -->
          <div class="row">
            <div class="col-md-12">
                <div class="group_title">
                    <div class="group_icon">
                        <span class="div_icon">
                            <i class="fas fa-hands-helping"></i>
                        </span>
                     <a href="{{route('services',['all','all'])}}"> <span class="group_name">  خدمات </span></a>
                    </div>
                </div>
                <div class="group_body row">
                   @foreach ($services_categories as $cat)
                   <div class="category_container ">
                    <a href="{{route('services',[$cat->id,'all'])}}" class="category_link">
                       <div class="category_image">
                          {{-- <img src="{{asset('assets_web/images/cdn/cat/v4/1vu7pcXTgc.jpg')}}" alt="{{$cat->getName()}}" title="{{$cat->getName()}}"> --}}
                          <img style="height: 150px" src="{{asset('uploads/'.$cat->image)}}" alt="{{$cat->getName()}}" title="{{$cat->getName()}}">
                       </div>
                       <div class="category_name">
                        {{$cat->getName()}}
                       </div>
                    </a>
                 </div>
                   @endforeach
                  
                 </div>
            </div>
        </div>
        <!-- end  services -->
        <!-- start  estats -->
        <div class="row">
                <div class="col-md-12">
                    <div class="group_title">
                        <div class="group_icon">
                            <span class="div_icon">
                                <i class="fas fa-building"></i>                                   
                            </span>
                          <a href="{{route('services',['11','all'])}}"> <span class="group_name"> العقارات </span></a>
                        </div>
                    </div>
                    <div class="group_body row">
                        @foreach ($estates_services as $subcat)
                        <div class="category_container">
                            <a href="{{route('services',[11,$subcat->id])}}" class="category_link">
                                <div class="category_image">
                                    <img style="height: 250px" src="{{asset('uploads/'.$subcat->image)}}"  alt=" {{$subcat->getName()}}" />
                                </div>
                                <div class="category_name">  {{$subcat->getName()}}</div>
                            </a>
                        </div>
                        @endforeach
                        
                       
                    </div>
                </div>
        </div>
        <!-- end  estats -->
    </div>
</div>
@endsection

@section('js')
<script>

//     $(document).ready(function(){
//    $(".banners").owlCarousel({
//    items:1,
//    loop:true,
//    margin:10,
//    autoplay:true,
//    autoplayTimeout:2500,
//    autoplayHoverPause:true,
//    nav:true,
//    dots:false,
//    })
//    })

/*loop:true,
   margin:10,
   nav:true,
   items: 4,
   center: true,
   autoplayTimeout: 2000,
   autoplay: 100, // time for slides changes
   smartSpeed: 1000, // duration of change of 1 slide*/

  </script>

@endsection

