
<header>

  <div class="top-header bg-primary p-2 ">
    <div class="container">
      <div class="dropdown direction">
        <button class="btn btn-primary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        @if (empty($selected_country) || $selected_country == '-1')
        {{__('site.all countries')}}
        @else
        {{__('site.country')}}
        <img class="mx-2" style="width: 30px" src="{{asset('uploads/'.\App\country::where('id',$selected_country)->first()->image)}}">
        @endif
             </button>
         <div class="dropdown-menu " style="width: 250px" aria-labelledby="triggerId">
          <a class="dropdown-item direction" href="{{route('set-country','-1','')}}">
            <div class="d-flex justify-content-between">
             <div class="p-1">
              {{__('site.all countries')}}
             </div>
            </div>
          </a>
          @foreach(\App\country::where('status',1)->get() as $country)
           <a class="dropdown-item direction" href="{{route('set-country',$country->id,'')}}">
             <div class="d-flex justify-content-between">
              <div class="p-1">
                {{$country->getName()}} 
              </div>
              <div class="p-1">
                <img style="width: 30px" src="{{asset('uploads/'.$country->image)}}">
              </div>   
             </div>
           </a>
           @endforeach
         </div>
       </div>


    </div>
  </div>
  <div class="bg-white mb-3">
    <div class="container">
     <div class="d-flex flex-wrap wrapper">
        <a class="navbar-brand" href="{{route('home')}}">
          <img class="p-0 m-0" src="{{ asset('assets_web/images/logo.png') }}" width="170" class="d-inline-block p-2 align-top" alt="">
        </a>
        {{-- <div class="dropdown"></div> --}}
    <div id="dropdown-items" class="dropdown">
        <button  class=" border-none bg-white dropdown-toggle px-2" type="button"  data-toggle="dropdown"
            aria-expanded="false">
            الأقسام
            </button>
       <div class="dropdown-menu direction" >
        <div class="d-flex">
          <div class="w-100">
            <a class="dropdown-item" href="{{route('all-commercial-ads')}}">
              <div class="text"> <i class="fas fa-bullhorn text-primary mx-1"></i>  {{__('site.commercial ads')}}  </div>
            </a>
            {{-- <a class="dropdown-item" href="#">
              <div class="text"> <i class="fas fa-file-contract text-primary mx-1"></i>  {{__('site.insurance')}}  </div>
            </a> --}}
  
            <a class="dropdown-item" href="{{route('vehicles-sell','all')}}">
              <div class="text"> <i class="fas fa-taxi text-primary mx-1"></i>  مركبات للبيع </div>
            </a>
  
              <a class="dropdown-item" href="{{route('vehicles-rent','all')}}">
                <div class="text"> <i class="fas fa-taxi text-primary mx-1"></i> مركبات للكراء </div>
              </a>
  
                <a class="dropdown-item" href="{{route('services-vehicles','all')}}">
                  <div class="text"> <i class="fas fa-tools text-primary mx-1"></i> خدمات المركبات  </div>
                </a>
                  
                  <a class="dropdown-item" href="{{route('services',['all','all'])}}">
                    <div class="text"> <i class="fas fa-hands-helping text-primary mx-1"></i> خدمات   </div>
                  </a>
  
                   <a class="dropdown-item" href="{{route('services',['11','all'])}}">
                <div class="text"> <i class="fas fa-building text-primary mx-1"></i> العقارات   </div>
                </a>
                 <a class="dropdown-item" href="{{route('insurance-single')}}">
                <div class="text"> <i class="fas fa-address-card text-primary mx-1"></i> تأمين ضد الغبر </div>
                </a>
                  <a class="dropdown-item" href="{{route('insurance-complete')}}">
                <div class="text"> <i class="fas fa-globe text-primary mx-1"></i> تأمين شامل </div>
                </a>
                   <a class="dropdown-item" href="{{route('sales-agencies')}}">
                <div class="text"> <i class="fas fa-house-user text-primary mx-1"></i> وكالات البيع </div>
                </a>
                <a class="dropdown-item" href="{{route('rental-agencies')}}">
                  <div class="text"> <i class="fas fa-home text-primary mx-1"></i> وكالات التأجير </div>
                  </a>
           </div>
        
        </div>

       </div> 

     
      </div>
      <form class="search flex-grow-1 position-relative">
        <input id="search-field" class="form-control" type="search" placeholder="{{__('site.search')}}" aria-label="Search">
       <div id="search-box" class="p-2 mt-1 bg-light  direction">
         <ul class="list-group p-0 m-0">
          
         </ul>
        </div>
      </form>
      <nav class="navbar navbar-expand-lg navbar-light p-0">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"  id="menu-toggle">
          <ul class="navbar-nav m-0 p-0 mt-lg-0">
            @if (!auth()->user())
            <li class="nav-item bg-white p-3">
              <a class="nav-link" href="{{route('user-login')}}"> <i class="fas fa-user px-2"></i>  تسجيل دخول</a>
            </li>
            <li class="nav-item bg-primary p-3 active">
              <a class="nav-link text-white" href="{{route('user-register')}}"> حساب جديد</a>
            </li>
            @else
            <li class="nav-item bg-white p-3">
              <a class="nav-link" href="#"> <i class="fas fa-user px-2"></i> {{ substr(auth()->user()->name,0,13)}} </a>
            </li>       
            <li class="nav-item bg-primary p-3 active">
              <a class="nav-link text-white" href="{{route('dashboard')}}"><i class="fas fa-th-large px-2"></i>  لوحة التحكم</a>
            </li>
            @endif
          </ul>
        </div>
      </nav>
     </div>
    </div>
  </div>
</header>
