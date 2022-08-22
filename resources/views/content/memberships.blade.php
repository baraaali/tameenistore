@extends('layouts.app')
@section('content')
<style>
    body{
        overflow-x:hidden;
    }
    .py-4{
        padding-top:0px !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
<br>
<div class="section-2 col-lg-12">
      <div class="container text-center">
        <h1 class="wow animate__fadeInDown" data-wow-duration="1s">
            @if(app()->getLocale() == 'ar')
                 العضويات
            @else
                 Memeber Ships
            @endif
        </h1>
        <hr class="breakLine">

    </div>

    <?php
    $type=auth()->user()->type;
    if ($type==0)$member='limit_person';
    elseif ($type==4)$member='limit_docs';
    else $member='limit_posts';
    $memberships = \App\membership::where($member,'>',0)->orderBy('cost','asc')->get();
    ?>

     <script
    src="https://www.paypal.com/sdk/js?client-id=ATJFAlYl69yLxPYihfgMsfEpdu9aXozynbwrwcrTPFc3uZfaGg9nf0qjIA2a3Ohu4ApvzhHoeOmG2gvq&currency=USD"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
  </script>
    <div class="container">
    <div class="row">
            @foreach($memberships as $membership)
                <div class="col-md-4">
                    <div class="card"  style="height:320px">
                          <div class="card-body">
                            <h5 class="card-title">
                                {{$membership->name}}
                            </h5>
                           <hr>
                            <p class="card-text">
                                @if(app()->getLocale() == 'ar')
                                    {!! $membership->ar_m_feature !!}
                                @else
                                    {!! $membership->en_m_feature !!}
                                @endif
                            </p>
                            @if(app()->getLocale() == 'ar')

                            <div class="badge badge-success" style="position:absolute;left:0px;padding-right:10px;padding-left:10px;top:5px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;">
                                <span>
                                    {{$membership->cost}} $
                                </span>
                            </div>

                            @else

                             <div class="badge badge-success" style="position:absolute;left:0px;padding-right:10px;padding-right:10px;top:5px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;">
                                <span>
                                    {{$membership->cost}} $
                                </span>
                            </div>


                            @endif

                            @if($membership->cost == 0)

                            <a href="{{url('/')}}/join/to/membershib/{{$membership->id}}/{{app()->getLocale()}}"  class="btn btn-primary btn-block" style="position: absolute;
    bottom: 15px;
    width: 81%;color:white">
                                @if(app()->getLocale() == 'ar')
                                    إختر هذا
                                @else
                                    Choose This
                                @endif
                            </a>
                            @else


                            <div id="paypal-button-container{{$membership->id}}"></div>

                             <script>

                                paypal.Buttons({
                                    createOrder: function(data, actions) {
                                      // This function sets up the details of the transaction, including the amount and line item details.
                                      return actions.order.create({
                                        purchase_units: [{
                                          amount: {
                                            value: '{{$membership->cost}}'
                                          }
                                        }]
                                      });
                                    },
                                    onApprove: function(data, actions) {
                                      // This function captures the funds from the transaction.
                                      return actions.order.capture().then(function(details) {

                                        window.location.href = "{{url('/')}}/join/to/membershib/{{$membership->id}}/{{app()->getLocale()}}";
                                      });
                                    }
                                  }).render('#paypal-button-container{{$membership->id}}');
                                  //This function displays Smart Payment Buttons on your web page.
                              </script>

                            @endif
                          </div>
                        </div>
                </div>
                <script>
                paypal.Buttons().render('#paypal-button-container');
                // This function displays Smart Payment Buttons on your web page.
              </script>
            @endforeach
    </div>
    </div>
</div>




@endsection
