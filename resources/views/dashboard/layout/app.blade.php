<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ app()->getLocale() }}">
    <meta name="country_id" content="{{ auth()->user()->country->id }}">


    <title>تاميني ستور</title>


        <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/bootstrap.min.css">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{asset('assets_web/css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/dashboard.css">
        @if (app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{asset('assets_web/css/app-rtl.css')}}">
         @endif
        
        <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    
         <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://cdn.tiny.cloud/1/rcipqrnmq01td2d87j42wmmfq1sxtfssmwi7pxv7oe4zncyk/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
         
        {{-- <script>tinymce.init({selector:'textarea'});</script><!-- Scripts --> --}}
         {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <!-- Fonts --><link rel="dns-prefetch" href="//fonts.gstatic.com"><link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    {{-- {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <script>(function(w,d,s,g,js,fs){ 
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));

</script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fancybox/dist/jquery.fancybox.min.css') }}">
    <script src="{{ asset('assets/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <style>
    .select2-container{
     display:block
        }
    </style>
    @yield('css')
</head>
<body>
    <div id="app" dir="rtl">
                 <div class="page-wrapper chiller-theme toggled">
                      <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                        <i class="fas fa-bars"></i>
                      </a>
                      <!-- start sidebar -->
                     
                      @if (auth()->user()->guard == 1) 
                      @include('dashboard.sidebars.admin') 
                      @elseif(auth()->user()->type == 5 && !is_null(auth()->user()->mcenter))  
                      @include('dashboard.sidebars.mcenter') 
                      @elseif(auth()->user()->type == 2  && !is_null(auth()->user()->agentDetails))
                      @include('dashboard.sidebars.agency-sell')
                      @elseif(auth()->user()->type == 3 && !is_null(auth()->user()->agentDetails))
                      @include('dashboard.sidebars.agency-rent')
                      @elseif(auth()->user()->type == 4 )
                      @include('dashboard.sidebars.insurance')
                      @else
                      @include('dashboard.sidebars.regular')
                      @endif
                      
                     
                      
                      {{-- @endif --}}
                      <!-- end sidebar -->
                      <!-- sidebar-wrapper  -->
                      <main class="page-content">
                        <div class="container-fluid">
                        @include('dashboard.layout.message')
                            @yield('content')
                        </div>

                      </main>
                      <!-- page-content" -->
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>





    </div>

<script type="text/javascript">
    jQuery(function ($) {

    $(".sidebar-dropdown > a").click(function() {
  $(".sidebar-submenu").slideUp(200);
  if (
    $(this)
      .parent()
      .hasClass("active")
  ) {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .parent()
      .removeClass("active");
  } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .next(".sidebar-submenu")
      .slideDown(200);
    $(this)
      .parent()
      .addClass("active");
  }
});

$("#close-sidebar").click(function() {
  $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function() {
  $(".page-wrapper").addClass("toggled");
});
    });
</script>
<script>
$(document).ready(function(){
        $('.select2').select2();

    });

// $(function () {
//     $('.datepicker').datetimepicker({
//         format: "DD/MM/YY",
//     });
// })
var csrf =  $('meta[name="csrf-token"]').attr('content');

</script>

@yield('js')

</body>
</html>
