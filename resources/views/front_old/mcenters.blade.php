@extends('layouts.app')
@section('css')
    <style>
        .tag{
    position: absolute;
    top: 0;
    color: #fff;
    background: #ffa500fc;
    padding: 5px 19px;
    border-radius: 10px;
    border-top-right-radius: 0;
    box-shadow: 1px 1px 1px #504c4cad;
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
       .cursor-pointer{
           cursor: pointer;
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
                   مراكز الصيانة
                    <br>
                    <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>

        @else

            <div class="upper">
                <h2 class="place" style="margin: 0px auto;">
                    Maintenance Centers
                    <br>
                    <hr style="width: 2%;border-color: #0674FD;border-width: 2px;">
            </div>
        @endif
    </div>
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
                              {{$country->$name}}
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
                     <br>
                        <input type="submit" id="search" class="btn btn-warning btn-sm sty_search text-white mt-4" value="{{__('site.search')}}">
                </div>
             </div>
             <div class="row mt-4 mcenters-data">
                 @include('front.mcenters-items')
             </div>
        </div>

    </div>


@endsection
@section('js')
    <script>
        var search = {}
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
					url: "{{route('mcenters-search')}}",
					type:'post',
                    data:search,
					success : function(res){
                       console.log(res);
                       $('.mcenters-data').html(res)
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
                   if(data.length)
                   {
                     data.forEach(e => {
                         $('#sub_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                     });
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
                    $('#child_category').html('');
                   if(data.length)
                   {
                     data.forEach(e => {
                         $('#child_category').append('<option value="'+e.id+'">'+e.ar_name+'</option>')
                     });
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
        var init = function()
        {
            getSubCategories()
            getChildCategories()
            getGovernorates()
            getCities()
            onSearch()
            slideDescription()
        }
        $(document).ready(init)
   
   
    </script>
@endsection
