
@extends('dashboard.layout.app')
@section('content')

<div class="col-lg-12">
    <div class="row">

        <div class="col-lg-12">
            @if(app()->getLocale() == 'ar')
                <h5 class="modal-title" id="exampleModalLabel"> إضافة مركبة للإيجار</h5>
            @else
                <h5 class="modal-title" id="exampleModalLabel">Make Advertisment</h5>
            @endif
            <div class="card-body"
                 style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                <div class="form">
                    <form method="POST" action="{{route('Ads-store')}}" enctype="multipart/form-data" id="createCar">
                        @csrf
                        <nav>
                            @if(app()->getLocale() == 'ar')
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab"
                                       href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">معلومات
                                        رئيسية</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                       href="#nav-profile" role="tab" aria-controls="nav-profile"
                                       aria-selected="false">خصائص ا السيارة</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                       href="#nav-contact" role="tab" aria-controls="nav-contact"
                                       aria-selected="false">صفات السيارة</a>
                                    <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab"
                                       href="#nav-price" role="tab" aria-controls="nav-price" aria-selected="false">إسعار
                                        السيارة</a>
                                </div>
                            @else
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab"
                                       href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Main
                                        Information</a>
                                    <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab"
                                       href="#nav-profile" role="tab" aria-controls="nav-profile"
                                       aria-selected="false">Car Propreties</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                       href="#nav-contact" role="tab" aria-controls="nav-contact"
                                       aria-selected="false">Car Shape</a>
                                    <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab"
                                       href="#nav-price" role="tab" aria-controls="nav-price" aria-selected="false">Car
                                        Price</a>
                                </div>
                            @endif
                        </nav>

                        <div class="tab-content mt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                 <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    نوع العربة <small class="text-danger">*</small>
                                                @else
                                                    Vehicle Type <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <select class="SpecificInput vehicleChange select2" name="vehicle_id" >
                                                <option value="0">{{__('site.other')}}</option>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    الدولة - المنطقة  <small class="text-danger">*</small>
                                                @else
                                                    Country-Region <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="hidden" id="cash" value="" name="cash">
                                            <select  id="country" class="SpecificInput select2" dir="rtl"
                                                    name="country_id" >
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}" @if(old('country_id') != null){{ old('country_id') }}selected
                                                        @endif @if (auth()->user()->country_id==$country->id)selected
                                        
                                                        @endif>
                                                        @if(app()->getLocale() == 'ar')
                                                            {{$country->ar_name}}
                                                        @else
                                                            {{$country->en_name}}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                     </div>
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        المحافظة <small class="text-danger">*</small>
                                                    @else
                                                    governorate <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                <select  id="governorate" class="SpecificInput select2 govChange" dir="rtl"
                                                        name="governorate_id">
                                        
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        المدينة <small class="text-danger">*</small>
                                                    @else
                                                     city <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                <select  id="city" class="SpecificInput select2" dir="rtl"
                                                        name="city_id">
                                        
                                                </select>
                                            </div>
                                     </div>
                                 </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    الاسم بالعربي  <small class="text-danger">*</small>
                                                @else
                                                    Name In Arabic <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text"  name="ar_name" max="191"
                                                   class="SpecificInput" @if(old('ar_name') != null){{ old('ar_name') }}@endif>
                                        </div>
                                     
                                       
                                             
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    البراند <small class="text-danger">*</small>
                                                @else
                                                    Brand <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <select class="SpecificInput brandChange select2" name="ar_brand" >
                                                <option value="0">{{__('site.other')}}</option>
                                            
                                            </select>
                                        </div>


                                        


                                    </div>
                                  
                                    <div class="col-md-6">
                                      
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    الاسم  الانجليزية  <small class="text-danger">*</small>
                                                @else
                                                    Name In English <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text" name="en_name" max="191"
                                                   class="SpecificInput"  @if(old('en_name') != null){{ old('en_name') }}@endif>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    الموديل  <small class="text-danger">*</small>
                                                @else
                                                    Model <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <select class="SpecificInput modelChange select2" name="ar_model">
                                                <option value="0">{{__('site.other')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('site.main_image')}}</label>
                                            <input type="file" name="main_image"
                                                   class="SpecificInput">
                                        </div>
                                    </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        صور السيارة <small class="text-danger">*</small>
                                                    @else
                                                        Car Image <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                <input type="file" multiple  class="SpecificInput uploader"
                                                       name="images[]" accept="image/*">
                                                <div class="uploadedimages">
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                
                             </div>
                        
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                 aria-labelledby="nav-profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                     سنة الصنع  <small class="text-danger">*</small>
                                                @else
                                                    Year <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                   name="year" max="191" class="SpecificInput"  @if(old('year') != null){{ old('year') }}@endif>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    اللون  <small class="text-danger">*</small>
                                                @else
                                                    Color<small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text" name="color" max="191" class="SpecificInput" @if(old('color') != null){{ old('color') }}@endif>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label>{{__('site.rent_sell')}}*</label>
                                            <select class="SpecificInput" name="sell">
                                                @if(auth()->user()->type!=3)
                                                    <option value="1">{{__('site.sell')}}</option>
                                                @else
                                                    <option value="0">{{__('site.rent')}}</option>
                                                @endif
                                            </select>
                                        </div>  --}}
                                        {{-- @if(auth()->user()->type==3) --}}
                                        <div class="form-group">
                                            @php $arr=[1=>'daily',2=>'weekly',3=>'monthly',4=>'rent_for_have']  @endphp
                                            <label>{{__('site.rent_type')}}</label>
                                            <select class="SpecificInput" name="rent_type">

                                                    @for($i=1;$i<count($arr);$i++)
                                                    <option value="{{$i}}">{{__('site.'.$arr[$i])}}</option>
                                                    @endfor

                                            </select>
                                        </div>
                                        {{-- @endif --}}
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    أقصي سرعة للسيارة  <small class="text-danger">*</small>
                                                @else
                                                    Max Speed<small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                   name="maxSpeed" max="191" class="SpecificInput"  @if(old('maxSpeed') != null){{ old('maxSpeed') }}@endif>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    ناقل الحركة  <small class="text-danger">*</small>
                                                @else
                                                    Transmission<small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <select class="SpecificInput" name="transmission">
                                                @if(app()->getLocale() == 'ar')
                                                    <option value="0">
                                                        عادي
                                                    </option>
                                                    <option value="1">
                                                        اوتوماتيك
                                                    </option>
                                                @else
                                                    <option value="0">
                                                        Manual
                                                    </option>
                                                    <option value="1">
                                                        Auatomatic
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    الوقود  <small class="text-danger">*</small>
                                                @else
                                                    Fuel Type <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text" name="fuel" max="191" class="SpecificInput" @if(old('fuel') != null){{ old('fuel') }}@endif>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    حالة  السيارة <small class="text-danger">*</small>
                                                @else
                                                    Car Condition <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <select class="SpecificInput" name="used">
                                                @if(app()->getLocale() == 'ar')
                                                    <option value="1">
                                                        جديدة
                                                    </option>
                                                    <option value="2">
                                                        مستعملة
                                                    </option>
                                                @else
                                                    <option value="1">
                                                        New
                                                    </option>
                                                    <option value="2">
                                                        Used
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    مطلوب \ معروض<small class="text-danger">*</small>
                                                @else
                                                    Required / Offered <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <select class="SpecificInput" name="talap">
                                                @if(app()->getLocale() == 'ar')
                                                    <option value="1">
                                                        مطلوب
                                                    </option>
                                                    <option value="2">
                                                        معروض
                                                    </option>
                                                @else
                                                    <option value="1">
                                                        Required
                                                    </option>
                                                    <option value="2">
                                                        Offered
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    حعدد الكيلو مترات<small class="text-danger">*</small>
                                                @else
                                                    KM ? <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                   name="kilometers" max="191" class="SpecificInput" @if(old('kilometers') != null){{ old('kilometers') }}@endif>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    المحرك <small class="text-danger">*</small>
                                                @else
                                                    Motor Type <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                   placeholder="1600" name="engine" max="191"
                                                   class="SpecificInput"  @if(old('engine') != null){{ old('engine') }}@endif>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                 aria-labelledby="nav-contact-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    وصف السيارة باعربية  <small class="text-danger">*</small>
                                                @else
                                                    Car Descript <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <textarea class="SpecificInput" required
                                                      name="ar_description" @if(old('ar_description') != null){{ old('ar_description') }}@endif></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    مميزات السيارة بالعربية  <small class="text-danger">*</small>
                                                @else
                                                    Car Features <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <textarea class="SpecificInput" name="ar_features"
                                            @if(old('ar_features') != null){{ old('ar_features') }}@endif></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    وصف السيارة  بالانجليزية   <small class="text-danger">*</small>
                                                @else
                                                    Car Description In English <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <textarea class="SpecificInput" required
                                                      name="en_description" @if(old('en_description') != null){{ old('en_description') }}@endif>

                                            </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                @if(app()->getLocale() == 'ar')
                                                    ومميزات السيارة  بالانجليزية  <small
                                                        class="text-danger">*</small>
                                                @else
                                                    Car Features In English <small class="text-danger">*</small>
                                                @endif
                                            </label>
                                            <textarea class="SpecificInput" name="en_features"
                                            @if(old('en_features') != null){{ old('en_features') }}@endif></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="nav-price" role="tabpanel"
                                 aria-labelledby="nav-price-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        السعر<small class="text-danger">*</small>
                                                    @else
                                                        Car Price <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                <input type="number" required class="SpecificInput" name="cost">
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        هل تريد عمل خصم قيمة ؟
                                                    @else
                                                        Do you want to make an offer ?
                                                    @endif
                                                </label>
                                                <input type="number" class="SpecificInput" name="discount_amount">
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        هل تريد عمل خصم  نسبة ؟
                                                    @else
                                                        Do you want to make an offer in precentage ?
                                                    @endif
                                                </label>
                                                <input type="number" class="SpecificInput" name="discount_percent">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        تحديد وقت بدأ الخصومات ؟
                                                    @else
                                                        Start Offers In
                                                    @endif
                                                </label>
                                                <input type="date" class="SpecificInput" name="discount_start_date">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                             تحديد وقت   نهاية الخصومات ؟
                                                    @else
                                                        End Offers In
                                                    @endif
                                                </label>

                                                <input type="date" class="SpecificInput" name="discount_end_date">
                                            </div>
{{--                                                <div class="form-group col-md-6">--}}
{{--                                                    <label>{{__('site.number_days')}}</label>--}}
{{--                                                    <input type="number" step="1" min="1" value="1" class="SpecificInput" name="number_days" id="number_days" required>--}}
{{--                                                </div>--}}
                                            <div class="form-group col-md-6">
                                                <label>{{__('site.ads_type')}}
{{--                                                        <span class="text-danger" id="show_price"></span>--}}
                                                </label>
                                                <select name="special" class="SpecificInput change_member" id="special">
                                                    <option>{{__('site.select')}}</option>
                                                    @foreach(\App\AdsMembership::get() as $price)
                                                        <option value="{{$price->id}}" data-url="{{$price->price}}">{{$price->getName()}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                            <input type="button"  id="submitFormCar"  class="btn btn-primary" value="{{__('site.save')}}">
                        </div>
                    </form>
                </div>

            </div>


        </div>
    </div>
</div>

{{-- scripts js--}}
<script>
     var csrf =  $('meta[name="csrf-token"]').attr('content');
     var lang =  $('meta[name="lang"]').attr('content');

     var submit = function ()
     {
        $('#submitFormCar').on('click',function(){
            $('#createCar').submit()
        })
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
    var getBands = function(){
        $('.vehicleChange').on('change',function(){
            $.ajax({
                url: "{{url('/')}}/view/get-brands/" + $(this).val(),
                context: document.body
            }).done(function (data) {
                $('.brandChange').find('option').remove().end();
                $('.brandChange').append('<option value="-1">{{__("site.other")}}</option>')
                $.each(data, function (i, item) {
                    $('.brandChange').append('<option value="' + item.id + '">' + item.name + '</optin>')
                });

            });
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
    var setCountry =  function()
    {
    var country_id =  $('meta[name="country_id"]').attr('content');
       $('#country').val(country_id)
       $('#country').trigger('change')
    }
    $(document).ready(function () {
        submit()
        getBands()
        $('.brandChange').change(function () {
            $.ajax({
                url: "{{url('/')}}/view/childerns/" + $(this).val(),
                context: document.body
            }).done(function (data) {
                $('.modelChange').find('option').remove().end();
                $('.brandChange').append('<option value="-1">{{__("site.other")}}</option>')
                $.each(data, function (i, item) {
                    $('.modelChange').append('<option value="' + item.id + '">' + item.name + '</optin>')
                });

            });
        });
    });


    $(document).ready(function () {
     getGovernorates()
     getCities()
     setCountry()
    });
    $(document).ready(function () {
        $('.govChange').change(function () {
 
        });

        $('.change_member , #number_days').change(function () {
           var price=$('.change_member').children(':selected').data('url');
           var days=$('#number_days').val();
           if (days <1) {
               alert('من فضلك ادخل عدد ايام صحيح');
               return false;
           }
           total=days*price;
           $('#show_price').text("سيتم خصم مبلغ  " + total +"$ من رصيدك ");
           $('#cash').val(price);
        });

    });

</script>
{{-- end scripts js--}}

@endsection


