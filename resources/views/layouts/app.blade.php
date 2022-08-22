<!doctype html>
<html lang="en">
  <head>
    <title>تاميني ستور</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <meta name="lang" content="{{ app()->getLocale() }}">
    <meta name="user_id" content="{{ auth()->user() ? auth()->user()->id : null }}">
   
    <meta name="description" content="{{$settings->description}}">
    <meta name="keywords" content="{{$settings->keywords}}">
    <meta name="author" content="{{$settings->auth_meta_tags}}">

    <!--  CSS -->
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_web/plugins/owlcarousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_web/plugins/owlcarousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_web/plugins/fontawesome/css/all.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
       
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets_web/css/app.css')}}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('assets_web/css/app-rtl.css')}}">
    @yield('css')
  </head>
  <body>
    <div id="loading" class="bg-light">
      <div  class="spinner-grow text-info"></div>
    </div>
    @include('partials.header')
    <div class="content">
       <div class="container">
        @include('dashboard.layout.message')
       </div>
         @yield('content')
     </div>
     @include('partials.footer')

     <script src="{{asset('assets_web/js/app.js')}}"></script>
     <script src="{{asset('assets_web/plugins/owlcarousel/owl.carousel.min.js')}}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
     <script src="{{asset('assets_web/js/custom.js')}}"></script>
       <!--Start of Tawk.to Script-->
    <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
          var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
          s1.async=true;
          s1.src='https://embed.tawk.to/5fe5ffd5a8a254155ab64ca7/1eqd6umfm';
          s1.charset='UTF-8';
          s1.setAttribute('crossorigin','*');
          s0.parentNode.insertBefore(s1,s0);
      })();
  </script>
  <!--End of Tawk.to Script-->
  
    @yield('js')
  </body>
</html>