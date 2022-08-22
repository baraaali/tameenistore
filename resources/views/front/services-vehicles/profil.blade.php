@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/star-rating-svg.css')}}">
@endsection

@section('content')
<div class="container">
  <!-- start  banner-->
  {{-- <div style="direction: ltr" class="owl-carousel banners owl-theme">
    <div class="item"><img src="{{asset('assets_web/images/ad1.jpg')}}"></div>
    <div class="item"><img src="{{asset('assets_web/images/ad2.jpg')}}"></div>
    <div class="item"><img src="{{asset('assets_web/images/ad3.jpg')}}"></div>
    <div class="item"><img src="{{asset('assets_web/images/ad1.jpg')}}"></div>
    <div class="item"><img src="{{asset('assets_web/images/ad2.jpg')}}"></div>
</div>          --}}
<!-- end banner -->
 <div class="container">
     <section>
         <ol class="breadcrumb bg-light">
             <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('site.home')}}</a></li>
             <li class="breadcrumb-item"></li>
             <li class="breadcrumb-item active">{{__('site.maintenance centers')}}</li>
         </ol>
    
     </section>
     <section id="mcenter-profil">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-6">
                  <div class="item">
                      <img class="w-100" src="{{asset('uploads/'.$mcenter->image)}}">
                      <div class="p-2 bg-light">
                          <div class="d-flex justify-content-between">
                             <div class="p-1  font-weight-bold">
                                 {{$mcenter->getName()}} <span class="mx-1 rating"></span>
                                </div>
                             <div class="p-1  font-weight-bold"> {{$mcenter->getStore->getName()}} </div>
                          </div>
                          <div class="d-flex justify-content-between">
                              <div class="p-1"> {{$mcenter->visitors}} <i  class="fa fa-eye" aria-hidden="true"></i> </div>
                             <div class="p-1">{{$mcenter->owner->Country->getName()}}</div>
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
                 <form class="request-form border p-2 my-3" action="{{route('save-maintenance-request')}}" method="post">
                  @csrf
                  <input type="hidden" name="mcenter_id" id="mcenter_id" value="{{$mcenter->id}}">
                  <div class="p-2 bg-light">
                      <div class="form-group services">
                          <label class="my-1 font-weight-bold" for="delivery_service">
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
                                      {{ $service->price}}
                                      @if($service->mcenter)
                                      <span class="currency">{{$service->mcenter->owner->country->getCurrency()}}</span>
                                      @endif
                                  </div>
                           </div>
                           <div class="p-3 my-1 border collapse" id="item-service{{$service->id}}">
                              {{ $service->getDescription()}}
                           </div>
                           @endforeach
                               
                        </div>
                        <div  id="additional-services-block" class="form-group">
                          <label class="my-1 font-weight-bold" for="delivery_service">
                              {{__('site.additional services')}}
                          </label>
                               <div class="w-100 additional-services ">-</div>
                        </div>
                        <div class="form-group">
                          <label class="my-1 font-weight-bold" for="delivery_service">
                              {{__('site.price')}}
                          </label>
                          <div class="bg-white p-2">
                            <input type="hidden" name="price" value="0">
                            <div class="p-1 d-flex flex-wrap-reverse"><strong class="price mx-2"> 0.00 </strong>  {{$currency}} ({{__("site.cash")}})</div>
                          </div>
                        </div>
                      <div class="form-group">
                          <label class="my-1 font-weight-bold" for="delivery">{{__('site.delivery to')}}</label>
                          <div class="bg-white p-2">
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
                          <label class="my-1 font-weight-bold delivery_day" for="delivery_day">
                              {{__('site.delivery day')}}
                              <div class="bg-white p-2">
                                  <input name="delivery_day"  placeholder="yyyy/mm/dd" class="mx-2"  id="datepicker">
                              </div>
                          </label>
                        </div>
                        <div class="form-group">
                          <label class="my-1 font-weight-bold" for="delivery_time">
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
    </section>
     
 </div>


@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.ar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('js/star-rating-svg.js')}}"></script>

<script>
 var csrf =  $('meta[name="csrf-token"]').attr('content');
 var lang =  $('meta[name="lang"]').attr('content');

    var loadRating = function()
    {
        const rating = "{{$mcenter->getRating()}}";
        $('.rating').starRating({
                    readOnly: true,
                    initialRating: parseInt(rating),
                    strokeColor: '#894A00',
                    strokeWidth: 10,
                    starSize: 25,
                    useFullStars:true
        })
    }
   
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
        slideDescription();
        loadRating();

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
        $('#additional-services-block').hide()
        var html = '';
        $('.services input').on('change',function(){
            var ids = []
            $('.additional-services').html('')
            $('#additional-services-block').hide()

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
                    html = '';
                    const  currency = $('.currency').length ? $('.currency').first().html() : '' ;
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
                                    `+s.price+` `+ currency +`
                                </div>
                         </div>
                         <div class="p-3 my-1 border collapse" id="item-addservice`+s.id+`">
                            `+s[lang+'_description']+`
                     </div>
                    `
                    $('.additional-services').html(html)
                })

                if(html.length)
                $('#additional-services-block').show()
                else
                $('#additional-services-block').hide()
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