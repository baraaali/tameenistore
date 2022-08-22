@extends('Cdashboard.layout.app')
@section('controlPanel')
    <?php

    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }

    $name = app()->getLocale() == 'ar' ? 'ar_name' : 'fr_name'
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
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{__('site.promotion')}}</h4>
            <div class="p-3">
                <h3 class="text-right">  {{__('site.balance notifications')}} : <strong class="text-success"> {{auth()->user()->notifications_balance}} {{__('site.notification')}} </strong>
                    <button type="button" class="btn btn-warning text-white mx-3"  data-toggle="modal" data-target="#addNotficationsBalanceID">{{__('site.add balance')}}</button>
                </h3>
               
            </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">

                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative;display: inline-block;top: 6px;">
                                    @if(app()->getLocale() == 'ar')
                                         ترويج الإعلانات
                                    @else
                                        promotions
                                    @endif
                                </h5>
                                <a href="{{route('promotion-new',app()->getLocale())}}" class="btn btn-light circle">
                                    <i class="fas fa-plus-circle"></i>
                                    {{__('site.add_new')}}
                                </a>
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                @if (empty($promotions))
                                <label style="display: block">
                                    @if(app()->getLocale() == 'ar')
                                        لايوجد  طلبات الترويج
                                    @else
                                        no Prmotions
                                    @endif
                                </label>
                                <br>
                                @endif
                                <table class="table table-stroped table-responsive ">
                                    <thead class="bg-light ">
                                       <tr>
                                           <th>{{__('site.name of the ad')}}</th>
                                           <th>{{__('site.target Category')}}</th>
                                           <th>{{__('site.target count')}}</th>
                                           <th>{{__('site.views')}}</th>
                                           <th>{{__('site.status')}}</th>
                                           <th>{{__('site.date')}}</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ([] as $promotion)
                                        <tr>
                                                <td>{{$promotion->ad($promotion)->first()->$name}}</td>
                                                <td>{{$promotion->target($promotion)}}</td>
                                                <td>{{$promotion->target($promotion,'count')}}</td>
                                                <td>{{$promotion->ad($promotion)->first()->visitors}}</td>
                                                <td>{{__('site.'.$promotion->status)}}</td>
                                                <td>{{$promotion->created_at}}</td>
                                            </tr>
                                        @endforeach
                                        {{$promotions->links()}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

          </div>
        </div>
    </div>
    {{-- add Notfications Balance  Modal--}}
    <div class="modal fade" id="addNotficationsBalanceID" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">{{__('site.add balance')}}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label for="package">{{__('site.notifications package')}}</label>
                      <select class="form-control" name="package" id="package">
                        <option value="">-- {{__('site.choose')}} -- </option>
                        @foreach ($packages as $item)
                        <option price="{{$item->price}}" value="{{$item->id}}"> {{$item->$name}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="my-2 text-danger discount_price">
                       {!!__('site.deducted from your account') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary d-block text-right submit-balance">{{__('site.submit charge')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
 <script>
  var csrf =  $('meta[name="csrf-token"]').attr('content');
  var setPriceDiscount = function()
     {
         $('.discount_price').hide()
         $('.submit-balance').prop('disabled',true)
         $('#package').on('change',function(){
          if($(this).val())
          {
           var price = parseFloat($('#package option:selected').attr('price'))
           $('.discount_price span').html(price)
           $('.submit-balance').prop('disabled',false)
           $('.discount_price').show()
          }else
          {
          $('.discount_price').hide()
          $('.submit-balance').prop('disabled',true)
          }
         })
     }
     var addNotficationsBalance = function()
     {
      $('.submit-balance').on('click',function(){
          var package_id =  $('#package').val()
        if(package_id)
        $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('add-balance-promotion')}}",
                type:'post',
                data:{package_id: package_id},
                success : function(res){
                    console.log(res);
                    window.location.reload()
                }
		        })

      })
     }
     $(document).ready(function(){
        addNotficationsBalance()
         setPriceDiscount()
     })
 </script>
@endsection
