@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                   <span style="color:white;font-weight:600">
                        @if(app()->getLocale() == 'ar')
                        {{ __('تسجيل الدخول') }}
                    @else
                        {{ __('Login') }}
                    @endif
                   </span>
                </div>

                <div class="card-body">
                     @if (session()->has('error'))

                                            <div class="alert alert-danger">
                                                {{session('error')}}
                                            </div>

                                        @endif
                    <form method="POST" action="{{ route('custom-user-route') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                @if( app()->getLocale() == 'ar')
                                {{ __('البريد الالكتروني') }}
                                @else
                                {{ __('E-Mail Address') }}
                                @endif
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">
                            
                            @if( app()->getLocale() == 'ar')
                                {{ __('كلمة المرور') }}
                                @else
                                {{ __('Password') }}
                                @endif</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                               
                            </div>
                        </div>

                      
                        <a href="{{url('/')}}/user-forget-password/{{app()->getLocale()}}" class="btn btn-link" >
                             @if(app()->getLocale() == 'ar')
                                        {{ __('هل نسيت كلمة السر ؟') }}
                                    @else
                                        {{ __(' Forget Your Password ? ') }}
                                    @endif
                            
                        </a>
                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-9">
                                <button type="submit" class="btn btn-primary">
                                    @if(app()->getLocale() == 'ar')
                                        {{ __('تسجيل الدخول') }}
                                    @else
                                        {{ __('Login') }}
                                    @endif
                                </button>

                              
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
