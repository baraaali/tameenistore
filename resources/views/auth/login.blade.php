@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb bg-white">
        <li>
            <a class="text-dark px-3" href="https://tameenistore.com">{{__('site.home')}}</a>
        </li>
        >
        <li class="active">
            <a  class="text-dark px-3"  href="https://tameenistore.com/login">{{__('site.login')}}</a>
        </li>
    </ol>
</div>
<section>
    <div class="container">
        <div class="wrapper my-3 bg-white">
                <a href="#">
                    <img class="d-block m-auto" src="{{ asset('assets_web/images/logo.png') }}" width="230" height="130" class="d-inline-block p-2 align-top" alt="">
                </a>
        <div>
        <div class="text-center text-secondary">
                    <h3 class="heading login_page_arabic_text_style">{{__('site.login')}}</h3>
                    <p class="sub-heading">{{__('site.enjoy the service now')}}</p>
        </div>
        <div class="row">
           <div class="col-md-12">
           <div class="col-md-4 m-auto">
            @if (session()->has('error'))
            <div class="alert alert-danger text-center" role="alert">
                <strong>{{__('auth.failed')}}</strong>
            </div>
            @endif
           </div>
           </div>
            <div class="col-md-4 m-auto p-3">
                    <form  class="form form-horizontal" method="POST" enctype="multipart/form-data"  action="{{ route('custom-user-route') }}">
                        @csrf
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-12">{{__('site.email')}}</label>
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ __($message) }}</strong>
                            </span>
                           @enderror
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-12">{{__('site.password')}}</label>
                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                           @enderror
                        </div>
                        </div>
                    </div>

                <div class="col-md-12">
                            <label class="w-100">
                                <div class="form-check">
                                  <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                                   <span class="mx-4"> {{__('site.remember me')}}</span>
                                  </label>
                                </div>
                            </label>
                    </div>

                    <div class="col-md-12">
                        <a  class="d-block text-dark py-3" href="{{route('password.request')}}" class="forget-link">{{__('site.you forgot your password ?')}}</a>
                    </div>

                    <div class="buttons login_button">
                        <div class="row">
                            <div class="col-md-12">
                                        <button class="btn btn-block btn-primary" type="submit" id="login_button">{{__('site.login')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>
</section>
@endsection