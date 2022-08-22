@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                   <span style="color:white;font-weight:600">
                        @if(app()->getLocale() == 'ar')
                        {{ __('استرجاع كلمة المرور') }}
                    @else
                        {{ __('Reset Password') }}
                    @endif
                   </span>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('custom-email-user',app()->getLocale()) }}">
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

                        

                      
                      
                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-9">
                                <button type="submit" class="btn btn-primary">
                                    @if(app()->getLocale() == 'ar')
                                        {{ __(' إرسال الرمز ') }}
                                    @else
                                        {{ __(' Send Code ') }}
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
