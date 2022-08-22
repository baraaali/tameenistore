@extends('layouts.app')


@section('content')
<div class="container">
  <!-- start  banner-->
  <div style="direction: ltr" class="owl-carousel banners owl-theme">
    @foreach ($banners as $banner)
    <div class="item"><img src="{{asset('uploads/'.$banner->file)}}"></div>
    @endforeach
</div>         
<!-- end banner -->
 <div class="container">
     <section class="mb-4">
        <h1> {{$vehicle ? $vehicle->getName() : __('site.vehicles')}}    <span>{{__('site.for rent')}}</span> </h1>
    </section>
     <section>
        <div class="col-lg-12">
            <form action="{{route('search_cars')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label style="font-weight: 600">{{__('site.cars_type')}}</label>
                        <select name="used" class="col-lg-12 cond-ajax sty_select select2">
                            <option selected  value="0">{{(__('site.select_car'))}}</option>
                            <option value="1">{{__('site.new')}}  </option>
                            <option value="2">{{__('site.used')}}  </option>
                            <option value="">{{__('site.both')}} </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label style="font-weight: 600">{{__('site.ad_type')}}</label>
                        <select name="talap" class="col-lg-12 select2">
                            <option selected value="0" >{{(__('site.ad_type'))}}</option>
                            <option value="1">{{__('site.needed')}}  </option>
                            <option value="2">{{__('site.offred')}}  </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label style="font-weight: 600">{{__('site.shows')}}  </label>
                        <select name="agent_id" class="col-lg-12 exhibtors sty_select select2">
                            <option value="0" selected>{{__('site.all')}}</option>
                            @foreach(App\Agents::where('agent_type','!=',2)->where('status',1)->get() as $agent)
                                <option value="{{$agent->id}}" @if(isset($_POST['agent_id'] )) @if($_POST['agent_id'] == $agent->id) {{ 'selected' }} @endif @endif>{{$agent->getName()}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 ">
                        <label style="font-weight: 600">{{__('site.select_vehicle')}}  </label>
                        <select name="vehicle_id" class="col-lg-12 vehicleChange select2">
                            <option value="0" selected >{{__('site.select_vehicle')}}</option>
                            @foreach(App\Vehicle::where('status','1')->get() as $vehicle)
                                <option value="{{$vehicle->id}}">{{$vehicle->getName()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label style="font-weight: 600">{{__('site.select_brand')}}  </label>
                        <select name="ar_brand" class="col-lg-12 brandChange exhibtors sty_select select2">
                            <option value="0" selected>{{__('site.select_brand')}}</option>
                        </select>
                    </div>
                    </div>
                    <div class="row mt-2">

                    <div class="col-md-2 ">
                        <label style="font-weight: 600">{{__('site.select_model')}}  </label>
                        <select name="ar_model" class="col-lg-12 modelChange exhibtors sty_select select2">
                            <option value="0" selected>{{__('site.select_model')}}</option>
                        </select>
                    </div>
                    <div class="col-md-2 ">
                        <label style="font-weight: 600">{{__('site.select_shape')}}  </label>
                        <select name="care_shape_id" class="col-lg-12 shapeChange select2">
                            <option value="0" selected>{{__('site.select_shape')}}</option>
                        </select>
                    </div>
                      <div class="col-md-2 ">
                        <label style="font-weight: 600"> {{__('site.rent_type')}} </label>
                        @php $arr=[1=>'daily',2=>'weekly',3=>'monthly',4=>'rent_for_have']  @endphp
                        <select name="rent_type" class="col-lg-12 shapeChange select2">
                            @for($i=1;$i<count($arr);$i++)
                            <option value="{{$i}}">{{__('site.'.$arr[$i])}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 ">
                        <label style="font-weight: 600">{{__('site.year')}}  </label>
                        <select name="year" class="col-lg-12 sty_select select2">
                            <option value="0">{{__('site.select_year')}}</option>
                            <?php
                            for ($i = -1; $i <= 35; ++$i) {
                                $time = strtotime(sprintf('-%d years', $i));
                                $value = date('Y', $time);
                                $label = date('Y ', $time);
                                printf('<option value="%s"  >%s</option>', $value, $label);
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="search" type="button" class="btn btn-warning w-100 mt-4">{{__('site.search')}}</button>
                    </div>
                </div>
            </form>
        </div>
     </section>
     <section class="mt-4">
           <div class="col-md-12 loading  d-none">
            <div class="d-flex justify-content-center ">
                <div class="spinner-border  m-5" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
             </div>
           </div>
            <div class="col-lg-12 ads">
                 @include('front.vehicles-rent.items',$cars)   
            </div>
     
     </section>
     
 </div>


@endsection


@section('js')
<script>
    var search_fields = {}
    search_fields['sell'] = 0;
    var search = function()
    {
        $('select').on('change',function(){
            $.each($('select'),function(i,e){
                search_fields[$(e).attr('name')] = $(e).val()
            })
        })
        $('#search').on('click',function(){
            $('.loading').removeClass('d-none')
            $.ajax({
                type: "POST",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route("search-vehicles")}}',
                data: search_fields,
                success: function (data) {
                    console.log(data)
                    $('.ads').html(data)
                    $('.loading').addClass('d-none')
                },
                error:function(e){
                    console.log(e);
                }
            })
        })
    }
 
    var brandChange  = function()
    {
        $('.brandChange').change(function () {
           getShapes()
           $.ajax({
               url: "{{url('/')}}/view/childerns/" + $(this).val(),
               context: document.body
           }).done(function (data) {
               $('.modelChange').find('option').remove().end();
                var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
               $.each(data, function (i, item) {
                html+= '<option value="' + item.id + '">' + item.name + '</optin>'
               });
                $('.modelChange').append(html)
               $('.modelChange').trigger('change')


           });
       });
    }

    var vehicleChange = function()
    {
        $('.vehicleChange').change(function () {
           getShapes()
           $.ajax({
               url: "{{url('/')}}/view/get-brands/" + $(this).val(),
               context: document.body
           }).done(function (data) {
               $('.brandChange').find('option').remove().end();
                var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
               $.each(data, function (i, item) {
                 html+= '<option value="' + item.id + '">' + item.name + '</optin>'
               });
                $('.brandChange').append(html)
               $('.brandChange').trigger('change')

           });
       });
    }

    var getShapes = function()
     {
         var brand_id = $('.brandChange').val()
         var vehicle_id = $('.vehicleChange').val()
         $.ajax({
               url: "{{url('/')}}/view/get-careshapes/" + vehicle_id + '/' + brand_id,
               context: document.body
           }).done(function (data) {
               $('.shapeChange').find('option').remove().end();
                var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
               $.each(data, function (i, item) {
                html+='<option value="' + item.id + '">' + item.ar_name+' ' + item.en_name+  '</optin>'
               });
                $('.shapeChange').append(html)
             $('.shapeChange').trigger('change')
           });
         
     }

     var getPage = function()
    {
        var vehicle_id = "{{request()->vehicle_id}}";
        if(vehicle_id.length && vehicle_id!= 'all')
        {
            $('.vehicleChange').val(vehicle_id)
            $('.vehicleChange').trigger('change')
        }
    }

    var setLike = function()
    {
        $('.like-action').on('click',function(){
            window.setLike($(this),'vehicles_rent')
     })
    }

     var init = function(){
     search()
     brandChange()
     vehicleChange()
     getShapes()
     getPage()
     setLike()

    }

    $(document).ready(init);
</script>
@endsection