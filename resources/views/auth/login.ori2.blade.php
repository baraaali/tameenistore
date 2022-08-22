@extends('layouts.app')

@section('content')
<div class="page-content sign-in-up">
    <!-- start page-heading.html-->
    <section class="header-section">
        <div class="container border_only_login_page">
            <div class="heading-wrapper">
                <div class="">
                    <ol class="breadcrumb">
                        <li>
                            <a href="https://tameenistore.com">{{__('site.home')}}</a>
                        </li>
                        <li class="active">
                            <a href="https://tameenistore.com/login">{{__('site.login')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- end page-heading.html-->
    <div class="container">
        <div class="new_big_logo_div w-50 mx-auto p-1">
            <div class="main_logo_styles">
                <a href="https://tameenistore.com">
                    <img src="{{asset('assets_v2/imgs/logo.png')}}" alt="tameenistore" title="tameenistore" width="200">
                </a>
            </div>
            <div>
                <div class="text-center">
                    <h3 class="heading login_page_arabic_text_style">{{__('site.login')}}</h3>
                    <p class="sub-heading">{{__('site.enjoy the service now')}}</p>
                </div>
            </div>
        </div>

        
        <div class="content none_margin_login_page w-50 mx-auto">
            <div class="row">
                @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{__('auth.failed')}}</strong>
                </div>
                @endif
                <div class="my-4">
                        <form  class="form form-horizontal" method="POST" enctype="multipart/form-data"  action="{{ route('custom-user-route') }}">
                            @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">{{__('site.email')}}</label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __($message) }}</strong>
                                </span>
                               @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-3">{{__('site.password')}}</label>
                            <div class="col-sm-8 col-md-8 get_parent_label_error_js">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                               @enderror
                            </div>
                        </div>

                        <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-8 m-b-lg" hidden="">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">{{__('site.remember me')}}
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-8 m-b-lg forgote_text_login_pahe">
                            <a href="{{route('user-forget-password')}}" class="forget-link">{{__('site.you forgot your password ?')}}</a>
                        </div>

                        <div class="buttons login_button">
                            <div class="row">
                                <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button class="btn btn-block btn-primary" type="submit" id="login_button">{{__('site.login')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection