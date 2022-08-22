<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin Login - Dashboard Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/fontawesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/dashboard.css">


        <script type="text/javascript" src="{{url('/')}}/js/jquery.js"></script>

        <!-- Styles -->

    </head>
    <body dir="{{app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
        <div class="login-navbar">
            <div class="container ">
            @if(app()->getLocale() == 'en')
            <div class="row">
                <div class="col-md-11">
                    Welcome My Admin
                </div>
                <div class="col-md-1">
                    <a href="{{url('/')}}/dashboard/secure/login/ar" style="color: white"> العربية </a>
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-md-11 right" >
                        مرحبا بكـ
                    </div>
                    <div class="col-lg-1">
                        <a style="color:white;" href="{{url('/')}}/dashboard/secure/login/en">English</a>
                    </div>
                </div>
            @endif
        </div>
        </div>

        <div class="container">
            <br>
            @if(session()->get('errors'))
                <div class="alert alert-danger fade in alert-dismissable" style="opacity: 1">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    {{ session()->get('errors') }}
                </div>
            @endif

            <br>
            @if(app()->getLocale() == 'en')

                   <form method="post" action="{{route('dashboard-login')}}">
                       @csrf
                       <div class="row">
                        <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                Email <small class="text-danger">*</small>
                            </label>
                            <input type="email" name="email" required="required" max="255" class="SpecificInput">
                        </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    Password <small class="text-danger">*</small>
                                </label>
                                <input type="password" name="password" required="required" max="255" class="SpecificInput">
                                <div class="f-r m-t">
                                     <input class="btn btn-primary" type="submit" name="submit" value="Login">
                                </div>
                            </div>
                        </div>

                </div>
                 </form>
            @else

             <form method="post" action="{{route('dashboard-login')}}">
                       @csrf
                       <div class="row" style="text-align: right;">
                        <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                البريد الالكتروني <small class="text-danger">*</small>
                            </label>
                            <input type="email" name="email" required="required" max="255" class="SpecificInput">
                        </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    كلمة المرور <small class="text-danger">*</small>
                                </label>
                                <input type="password" name="password" required="required" max="255" class="SpecificInput">
                                <div class="f-l m-t">
                                     <input class="btn btn-primary" type="submit" name="submit" value="تسجيل الدخول">
                                </div>
                            </div>
                        </div>

                </div>
                 </form>
            @endif

        </div>

    </body>
</html>
