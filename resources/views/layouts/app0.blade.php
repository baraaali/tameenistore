<!DOCTYPE html>
<html lang="ar">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>اكبر سوق في قطر | تأمييني ستور</title>
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="اكبر سوق في قطر | تأمييني ستور" />
    <meta name="twitter:description"
        content="الموقع الاعلى تصنيفا في قطر . نشر إعلانات مجانية. بيع وشراء السيارات المستعملة، شقة للايجار، وظائف البحث وسلع ذات جودة أكثرو رخيصة في قطر سوق قطر سيل ليفنج " />
    <meta name="twitter:url" content="http://tameenistore.com/" />
    <meta name="twitter:image" content="http://tameenistore.com/themes/qatar/imgs/favicon/favicon-194x194.png')}}" />
    <meta name="twitter:site" content="@tameenistore" />
    <meta name="description"
        content="الموقع الاعلى تصنيفا في قطر . نشر إعلانات مجانية. بيع وشراء السيارات المستعملة، شقة للايجار، وظائف البحث وسلع ذات جودة أكثرو رخيصة في قطر سوق قطر سيل ليفنج" />
    <meta name="facebook-domain-verification" content="fi4acidj3d4px5gqa5uf05ip89z4pn" />
    <meta name="keywords"
        content=", تأمييني ستور، مبوبة مجانيه، اعلانات مبوبة عبر الإنترنت، مبوبة  قطر، اعلانات مبوبة مجانيه في قطر" />
    <meta property="og:url" content="http://tameenistore.com/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="اكبر سوق في قطر | تأمييني ستور" />
    <meta property="og:description"
        content=", تأمييني ستور، مبوبة مجانيه، اعلانات مبوبة عبر الإنترنت، مبوبة  قطر، اعلانات مبوبة مجانيه في قطر" />
    <meta property="og:image:width" content="620" />
    <meta property="og:image:height" content="541" />
    <meta property="og:image" content="http://tameenistore.com/assets/imgs/logo.png')}}" />
    <link rel="stylesheet" href="{{ asset('assets_v2/css/home_ar4.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('assets_v2/imgs/favicon.png') }}" />
    <!-- Site custom styles -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/mainAr_3.css') }}" /> --}}
    {{-- <link href="{{ asset('assets_v2/css/icons/icomoon/styles.css') }}" rel="stylesheet"
    type="text/css" /> --}}
    {{-- <link href="{{ asset('assets_v2/css/colors.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('assets_v2/auto/easy-autocomplete.min.css') }}" rel="stylesheet"
    type="text/css" /> --}}


    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"> --}}
    {{-- <link rel="stylesheet" type="text/css"  href="{{ asset('assets_v2/css/styles-rtl50.min.css') }}" /> --}}
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_v2/owlcarousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_v2/owlcarousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_v2/fontawesome/css/all.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_v2/css/bootstrap-v4.css') }}" />
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_v2/css/custom.css') }}" />
    <link rel="stylesheet" type="text/css"  href="{{ asset('assets_v2/css/custom-rtl.css') }}" />
    @yield('css')
</head>

<body class="barriable rtl bg-light" dir="rtl">
    <input type="hidden" id="webLang" data-lang="ar" />
    <input type="hidden" class="input_favorite_value" data-fav="" />
    <input type="hidden" id="user_phone" value="" />
    <!-- page wrapper -->
    <div id="wrapper">
        <input type="hidden" name="lang" id="lang" value="ar" />
        <!-- start header.html-->
        @include('partials.header')
        <div id="site-content">
            <!-- start content -->
            @yield('content')
           <!-- end content -->
        </div>
        @include('partials.footer')
    </div>
    <!-- /page wrapper -->
    <!-- Core JS files -->
    <script src="{{asset('assets_v2/js/core/libraries/jquery.min.js')}}"></script>
    <script src="{{asset('assets_v2/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{asset('assets_v2/js/custom.js')}}"></script>
    
     @yield('js')

</body>

</html>
