@extends('Cdashboard.layout.app')
@section('controlPanel')

<script
    src="https://www.paypal.com/sdk/js?client-id=ATJFAlYl69yLxPYihfgMsfEpdu9aXozynbwrwcrTPFc3uZfaGg9nf0qjIA2a3Ohu4ApvzhHoeOmG2gvq&currency=USD"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
</script>
    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    ?>


    @if(app()->getLocale() == 'ar')

        <style>
            .form-group {
                direction: rtl;
                text-align: right !important;
            }
            .font_20{
               font-size: 20px;
            }
        </style>

    @else
        <style>
            .form-group {
                direction: ltr;
                text-align: left !important;
            }
            .font_20{
                font-size: 20px;
            }
        </style>
    @endif
@include('dashboard.layout.message')
    <div class="col-lg-12" style="background-image: url({{asset('/bg.jpg')}})">
        <div class="row">


            <div class="col-md-12">
                <div class="tab-content mt-5" id="v-pills-tabContent" style="padding-top:0px">
                    <div class="text-center my-5">
                        <span class="text-primary font_20">{{__('site.your_balance')}} :</span>
                        <span class="text-danger font_20 btn btn-warning">@if (isset($balance))
                                {{$balance->balance}} $
                            @else {{__("site.you_don't_have_balance")}}
                            @endif
                        </span>
{{--                        <h5 class="my-5 text-danger">{{__('site.charge_balance')}}</h5>--}}
{{--                        <form action="{{ url('charge') }}" method="post">--}}
{{--                            @csrf--}}
{{--                            <input type="text" class="btn btn-warning" placeholder="{{__('site.add_value_charge')}}" name="amount" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"--}}
{{--                            style="border: 2px solid #000">--}}
{{--                            <input type="submit" class="btn btn-primary" name="submit" value="{{__('site.charge')}}">--}}
{{--                        </form>--}}
{{--                        <div id="paypal-button-container"></div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
