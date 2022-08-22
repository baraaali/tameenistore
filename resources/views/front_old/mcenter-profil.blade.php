@extends('layouts.app')
@section('css')
    <style>
        .times div { cursor: pointer; }
        .selected-time { background-color :  #4fc76a !important }
        .unavailabile { background-color :  #afafaf !important }
        .services .fa-info-circle,.cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <?php
    use Carbon\Carbon;
    if ($lang == 'ar' || $lang == 'en') {
        App::setlocale($lang);
    } else {
        App::setlocale('ar');
    }
    $name = $lang.'_name';
    ?>
    <style>
        .sty_search {
            margin-top: 10px !important;
            padding: 5px;
            border-radius: 10px;
            width: 140px;
        }

        .pt-4, .py-4 {
            padding-top: 0rem !important;
        }

        .sty_select {
            border: 1px solid #d3d3d3;
            border-radius: 5px;
        }
    </style>
    <div class="col-lg-12 cover-adv"
         style="height:200px;background-image:url({{url('/')}}/uploads/photo-1493238792000-8113da705763.jpg">
        @if(app()->getLocale() == 'ar')

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                   {{$mcenter->ar_name}} 
                    <br>
                    <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>

        @else

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                    {{$mcenter->en_name}} 
                    <br>
                    <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>
        @endif
    </div>
    <div class="container">
      <div class="col-md-12">
          <div class="row mt-4">
              <div class="col-md-6">
                <div class="item">
                    <img class="w-100" src="{{asset('uploads/'.$mcenter->image)}}">
                    <div class="p-2 bg-light">
                        <div class="d-flex justify-content-between">
                           <div class="p-1  font-weight-bold">{{$mcenter->getName()}} </div>
                           <div class="p-1  font-weight-bold"> {{$mcenter->getStore->getName()}} </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="p-1"> {{$mcenter->visitors}} <i  class="fa fa-eye" aria-hidden="true"></i> </div>
                           <div class="p-1">القاهرة</div>
                        </div>
                        <div class="d-flex  flex-wrap">
                            @foreach ($mcenter->getServices() as $service)
                                <div class="p-1 mx-1 border">{{$service->getName()}}</div>
                            @endforeach
                        </div>
                        <div class="border-top my-3"></div>
                        <div class="p-1">
                            <p> {{$mcenter->getDescription()}}  </p>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
               <form class="request-form" action="{{route('save-maintenance-request')}}" method="post">
                @csrf
                <input type="hidden" name="mcenter_id" id="mcenter_id" value="{{$mcenter->id}}">
                <div class="p-2 bg-light">
                    <div class="form-group services">
                        <label class="my-3 font-weight-bold" for="delivery_service">
                            {{__('site.services')}}
                        </label>
                        @foreach ($services as $i => $service)
                        <div class="p-2 d-flex  justify-content-between my-2 bg-white">
                                <div class="">
                                    <label class="mx-3" >
                                     <input  type="checkbox" _price="{{$service->price}}" name="services[]" value="{{$service->id}}" >
                                     {{ $service->getName()}} 
                                     </label>
                                </div>
                                <div class="item-service" _id="{{ $service->id}}">
                                   <span class="cursor-pointer"> {{__('site.read more')}}</span>
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                                <div>
                                    {{ $service->price}} <span class="currency">{{$service->mcenter->country->getCurrency()}}</span>
                                </div>
                         </div>
                         <div class="p-3 my-1 border collapse" id="item-service{{$service->id}}">
                            {{ $service->getDescription()}}
                         </div>
                         @endforeach
                             
                      </div>
                      <div class="form-group">
                        <label class="my-3 font-weight-bold" for="delivery_service">
                            {{__('site.additional services')}}
                        </label>
                             <div class="w-100 additional-services ">-</div>
                      </div>
                      <div class="form-group">
                        <label class="my-3 font-weight-bold" for="delivery_service">
                            {{__('site.price')}}
                        </label>
                             <input type="hidden" name="price" value="0">
                             <div class="p-1 d-flex flex-wrap-reverse"><strong class="price mx-2"> 0.00 </strong>  {{$currency}} ({{__("site.cash")}})</div>
                      </div>
                    <div class="form-group">
                        <label class="my-3 font-weight-bold" for="delivery">{{__('site.delivery to')}}</label>
                        <div class="my-3">
                            <label class="mx-3">
                                <input type="radio" name="delivery_to" value="workshop" checked>
                                {{__('site.workshop')}}
                            </label>
                            <label class="mx-3">
                              <input type="radio" name="delivery_to" value="house" checked>
                              {{__('site.house')}}
                          </label>
                           
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="my-3 font-weight-bold delivery_day" for="delivery_day">
                            {{__('site.delivery day')}}
                            <input name="delivery_day"  placeholder="yyyy/mm/dd" class="mx-2"  id="datepicker">
                        </label>
                      </div>
                      <div class="form-group">
                        <label class="my-3 font-weight-bold" for="delivery_time">
                            {{__('site.delivery time')}}
                        </label>
                        <div class="col-md-12">
                            <div class="row times">
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="7_am-8_am"  class="d-none"  type="checkbox"  > 07:00{{__('site.am')}} -  08:00{{__('site.am')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="8_am-9_am"  class="d-none"  type="checkbox"  > 08:00{{__('site.am')}} -  09:00{{__('site.am')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="9_am-10_am"  class="d-none"  type="checkbox"  > 09:00{{__('site.am')}} -  10:00{{__('site.am')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="10_am-11_am"  class="d-none"  type="checkbox"  > 10:00{{__('site.am')}} -  11:00{{__('site.am')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="11_am-12_pm"  class="d-none"  type="checkbox"  > 11:00{{__('site.am')}} -  12:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="12_pm-1_pm"  class="d-none"  type="checkbox"  > 12:00{{__('site.pm')}} -  01:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="1_pm-2_pm"  class="d-none"  type="checkbox"  > 01:00{{__('site.pm')}} -  02:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="2_pm-3_pm"  class="d-none"  type="checkbox"  > 02:00{{__('site.pm')}} -  03:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="3_pm-4_pm"  class="d-none"  type="checkbox"  > 03:00{{__('site.pm')}} -  04:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="4_pm-5_pm"  class="d-none"  type="checkbox"  > 04:00{{__('site.pm')}} -  05:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="5_pm-6_pm"  class="d-none"  type="checkbox"  > 05:00{{__('site.pm')}} -  06:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="6_pm-7_pm"  class="d-none"  type="checkbox"  > 06:00{{__('site.pm')}} -  07:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="7_pm-8_pm"  class="d-none"  type="checkbox"  > 07:00{{__('site.pm')}} -  08:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="8_pm-9_pm"  class="d-none"  type="checkbox"  > 08:00{{__('site.pm')}} -  09:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="9_pm-10_pm"  class="d-none"  type="checkbox"  > 09:00{{__('site.pm')}} -  10:00{{__('site.pm')}}</div></div>
                                <div class="col-md-4 mb-1"><div class="bg-warning text-white p-1 text-center"> <input name="delivery_time" value="10_pm-11_pm"  class="d-none"  type="checkbox"  > 10:00{{__('site.pm')}} -  11:00{{__('site.pm')}}</div></div>
                            </div>
                        </div>
                      </div>
                      <div class="my-1">
                        <button type="button" class="btn btn-primary w-100 place_order">{{__('site.place order')}}</button>
                    </div>
                </div>

               </form>
              </div>
          </div>
      </div>

    </div>


@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.ar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    var loadDatePicker = function()
    {
      @if($lang == '' || $lang == 'ar')
      var options = { language: 'ar',format:'yyyy/mm/dd' }
      @else
      var options = {format:'yyyy/mm/dd'}
      @endif
     $('#datepicker').datepicker(options)
     var minDate = new Date();
     $('#datepicker').datepicker('setStartDate',minDate);
     $('#datepicker').datepicker('setDate',minDate);
    }
    var selectTime = function()
    {
        $('.times div > div').on('click',function(){
            if($(this).hasClass('selected'))
            {
             $(this).removeClass('selected-time')
             $(this).removeClass('selected')
             $(this).find('input').prop('checked',false) 
            }else{
           $('.times div > div').removeClass('selected-time')
           $('.times div > div  input').prop('checked',false);
            if(!$(this).hasClass('unavailabile'))
            {
             $(this).addClass('selected-time')
             $(this).find('input').prop('checked',true)
             $(this).addClass('selected')
            }
            }
           
        })
    }
    init = function()
    {
        $('[data-toggle="tooltip"]').tooltip();  
        checkCenterAvailability()
        placeOrder()
        loadDatePicker()
        selectTime()
        getAdditionalServices()
        setPrice()
        slideDescription()

    }
    var slideDescription = function(){
        $(document).on('click', '.item-service',function(){
        var id = $(this).attr('_id');
        $('#item-service'+id).slideToggle()
    })
    $(document).on('click','.item-addservice', function(){
        var id = $(this).attr('_id');
        $('#item-addservice'+id).slideToggle()
    })
    }
    var checkCenterAvailability = function()
    {
        $('#datepicker').on('change',function(){
        var date = new Date($(this).val());
        var day = date.toLocaleString('en-us', {weekday:'long'});
        var delivery_day = $(this).val()
        delivery_day = delivery_day.replaceAll('/','-')
        var mcenter_id = $('#mcenter_id').val()
        $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                type: "get",
                dataType: "json",
                url: "/view/mcenters/check-availability/"+mcenter_id+"/"+day+"/"+delivery_day,
                success: function(data){
                    console.log(mcenter_id);
                    console.log(day);
                    console.log(data);
                    $('.times div > div ').addClass('unavailabile')
                    $('.times div > div ').each(function(i,$e){
                        var value = $($e).find('input').attr('value')
                        if(data.indexOf(value) > -1)
                        {
                           $($e).removeClass('unavailabile')
                        }
                        
                    })
                },error : function(e){
                    console.log(e);
                }
        })
                
         
        })
    }
    var setPrice = function()
    {
        var checked_services,checked_addi_services
        var updatePrice = function()
        {
        var price = 0
        if(checked_services)
        checked_services.each(function(i,$e){
            price  = price + parseFloat($($e).attr('_price'))
        })
        if(checked_addi_services)
        checked_addi_services.each(function(i,$e){
            price+= parseFloat($($e).attr('_price'))
        })
        $('.price').html(parseFloat(price).toFixed(2))
        $('input[name="price"]').val(parseFloat(price).toFixed(2))
        }
        // events
        $('.services input').on('change',function(){
             checked_services = $('.services input:checked')
             updatePrice()
        })
        $(document).on('change','.additional-services input',function(){
             checked_addi_services = $('.additional-services input:checked')
              updatePrice()
        })
    }
    var getAdditionalServices = function()
    {
        $('.services input').on('change',function(){
            var ids = []
            $('.additional-services').html('')
            $('.services input').each(function(i,$e){
                if($($e).is(':checked'))
                ids.push($($e).attr('value'))
            })
             $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                type: "post",
                data: {ids:ids},
                dataType: "json",
                url: "{{route('mcenter-get-additional-services')}}",
                success: function(services){
                    var html = ''
                    services.forEach(s => {
                    html +=  ` <div class="p-2 d-flex  justify-content-between my-2 bg-white">
                                <div class="">
                                    <label class="mx-3">
                                     <input  type="checkbox" _price="`+s.price+`" name="additional_services[]" value="`+s.id+`" >
                                     `+s[lang+'_name']+`
                                     </label>
                                </div>
                                <div class="item-addservice" _id="`+s.id+`">
                                   <span class="cursor-pointer"> {{__('site.read more')}}</span>
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                                <div>
                                    `+s.price+` `+ $('.currency').first().html() +`
                                </div>
                         </div>
                         <div class="p-3 my-1 border collapse" id="item-addservice`+s.id+`">
                            `+s[lang+'_description']+`
                     </div>
                    `
                    $('.additional-services').html(html)
                     })
                }
             })
             })
    }

    var placeOrder = function()
    {
        $('.place_order').on('click',function(){
           var services_length = $('input[name="services[]"]:checked').length
           var delivery_day =  $('input[name="delivery_day"]').val()
           var times_length =  $('.times div > div  input:checked').length
           $('.request-form').find('.invalid-feedback').remove()
           if(!services_length)
           $('.services').append('<div class="invalid-feedback d-block my-4">{{__("site.services are required")}}</div>')
           if(!delivery_day)
           $('.delivery_day').append('<div class="invalid-feedback d-block my-4">{{__("site.delivery day is required")}}</div>')
           if(!times_length)
           $('.times').append('<div class="invalid-feedback d-block my-4">{{__("site.delivery time is required")}}</div>')
           
          if($('.request-form').find('.invalid-feedback').length == 0)
          $('.request-form').submit()
        
        })
    }
    $(document).ready(init)


 </script>
@endsection
