@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/star-rating-svg.css')}}">
@endsection

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
     <section>
         <ol class="breadcrumb bg-light">
             <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('site.home')}}</a></li>
             <li class="breadcrumb-item"></li>
             <li class="breadcrumb-item active">{{__('site.maintenance centers')}}</li>
         </ol>
         <div class="row">
             <div class="col-md-12">
                 <h4 class="text-right px-4">{{__('site.number of maintenance centers')}} {{$mcenters_count}}</h4>
             </div>
         </div>
     </section>
     <section>
         <div class="container">
            <div class="col-md-12">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="country">{{__('site.country')}}</label>
                            <select class="form-control select2"    value="{{old('country_id')}}"  name="country_id" id="country">
                              <option value=""  >{{__('site.choose')}}</option>
                              @foreach($countries as $country)
                              <option value="{{$country->id}}">
                                  {{$country->getName()}}
                              </option>
                          @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="governorate">{{__('site.governorate')}}</label>
                            <select class="form-control select2" value="{{old('governorate_id')}}"  name="governorate_id"_ id="governorate">
                              <option value=""  >{{__('site.choose')}}</option>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">{{__('site.city')}}</label>
                            <select class="form-control select2"value="{{old('city_id')}}"  name="city_id" id="city">
                              <option value="" >{{__('site.choose')}}</option>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mcenter_vehicle_id">{{__('site.vehicle type')}}</label>
                            <select class="form-control select2"    value="{{old('mcenter_vehicle_id')}}"  name="mcenter_vehicle_id" id="mcenter_vehicle_id">
                              <option value=""  >{{__('site.choose')}}</option>
                              @foreach($vehicles as $vehicle)
                              <option value="{{$vehicle->id}}">
                                  {{$vehicle->getName()}}
                              </option>
                          @endforeach
                            </select>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                     <div class="form-group">
                         <label for="category">  القسم  </label>
                         <select value="" class="form-control select2" name="category" id="category"> 
                            <option value=""  >{{__('site.choose')}}</option>
                            @foreach($categories as $category)
                               <option value="{{$category->id}}">
                                   {{$category->ar_name}}
                               </option>
                           @endforeach
                         </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                     <div class="form-group">
                         <label for="sub_category">  القسم الفرعي  </label>
                         <select disabled value="" class="form-control select2" name="sub_category" id="sub_category"> 
                             <option value="">{{__('site.choose')}}</option>
                         </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                     <div class="form-group">
                         <label for="child_category">  القسم الفرع فرعي   </label>
                         <select disabled value="" class="form-control select2" name="child_category" id="child_category"> 
                           <option value="">{{__('site.choose')}}</option>
                         </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <input type="submit" id="search" class="btn btn-success w-100 sty_search text-white mt-4" value="{{__('site.search')}}">
                    </div>
                 </div>
               
            </div>
        </section>
     <section class="my-4">
       <div class="mcenters-data">
           @include('front.services-vehicles.mcenters-items')
       </div>
         
     </section>
     
 </div>


@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/star-rating-svg.js')}}"></script>

<script>
var csrf =  $('meta[name="csrf-token"]').attr('content');
 var lang =  $('meta[name="lang"]').attr('content');

    var search = {}
    var loadRating = function()
    {
        const rates = $('.rates');
        rates.each(function(i,e){
            const id = $(e).attr('data-id');
            const rate = $(e).attr('data-rate');
            $('.rate'+id).starRating({
                        readOnly: true,
                        initialRating: parseInt(rate),
                        strokeColor: '#894A00',
                        strokeWidth: 10,
                        starSize: 25,
                        useFullStars:true
            })
        })
    }
    var onSearch = function()
    {
        $('#search').on('click',function(){
             search['category'] = $('#category').val()
             search['sub_category'] = $('#sub_category').val()
             search['child_category'] = $('#child_category').val()
             search['country'] = $('#country').val()
             search['governorate'] = $('#governorate').val()
             search['city'] = $('#city').val()
             search['mcenter_vehicle_id'] = $('#mcenter_vehicle_id').val()
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('services-mcenters-search',0)}}",
                type:'post',
                data:search,
                success : function(res){
                   console.log(res);
                   $('.mcenters-data').html(res)
                },
                error:function($e){
                    console.log($e);
                }
            })
        })
    }
    var getSubCategories = function(){
        $('#category').on('change',function(){
         var id = $(this).val()
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/dashboard/service_categories/get-childrens/"+id,
            success: function(data){
                $('#sub_category').html('');
                var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
               if(data.length)
               {
                 data.forEach(e => {
                    html += '<option value="'+e.id+'">'+e.ar_name+'</option>'
                 });
                $('#sub_category').append(html)
                 $("#sub_category").prop('disabled',false)
               }else
                 $("#sub_category").prop('disabled',true)
                 $('#sub_category').trigger('change')
            }
        })
        })
        $('#category').trigger('change')
    }
    var getChildCategories = function(){
        $('#sub_category').on('change',function(){
         var id = $(this).val()
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/dashboard/service_sub_categories/get-childrens/"+id,
            success: function(data){
                var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'

               if(data.length)
               {
                 data.forEach(e => {
                     html += '<option value="'+e.id+'">'+e.ar_name+'</option>';
                 });
                     $('#child_category').append(html)
                 $("#child_category").prop('disabled',false)
               }else
                 $("#child_category").prop('disabled',true)
            }
        })
        })
        $('#sub_category').trigger('change')
    }
    var getGovernorates = function()
    {
        $('#country').on('change',function(){
            var id= $(this).val()
            if(id)
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('user-get-governorates')}}",
                type:'post',
                data:{id:id},
                success : function(governorates){
                    var html  = ''
                    governorates.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e[lang+'_name']+'</option>'
                    });
                    $('#governorate').html(html)
                    $('#governorate').trigger('change')
                }
            })
        })
    } 
   var getCities = function()
    {
        $('#governorate').on('change',function(){
            var id= $(this).val()
            if(id)
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('user-cities-get')}}",
                type:'post',
                data:{id:id},
                success : function(cities){
                    var html  = ''
                    cities.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e[lang+'_name']+'</option>'
                    });
                    $('#city').html(html)
                    $('#city').trigger('change')
                }
            })
        })
    }
    var slideDescription = function(){
    $(document).on('click', '.item-service',function(){
    var id = $(this).attr('_id');
    $('#item-service'+id).slideToggle()
       })

   }
   var getPage = function()
    {
        var cat_id = "{{request()->cat_id}}";
         if(cat_id.length && cat_id != 'all')
         {
             $('#category').val(cat_id)
             $('#category').trigger('change')
        }
    } 
    var init = function()
    {
        getSubCategories()
        getChildCategories()
        getGovernorates()
        getCities()
        onSearch()
        slideDescription()
        getPage()
        loadRating();
    }
    $(document).ready(init)


</script>

    
@endsection