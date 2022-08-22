@extends('Cdashboard.layout.app')
@section('controlPanel')


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
        </style>

    @else
        <style>
            .form-group {
                direction: ltr;
                text-align: left !important;
            }
        </style>
    @endif
    <style>
            .height_text{
                height: 120px !important;
            }
        </style>
    @include('dashboard.layout.message')
    <div class="col-lg-12">
        <div class="row">

            <div class="col-lg-12">
                <span>
                @if(app()->getLocale() == 'ar')
                    <h5 class="modal-title" id="exampleModalLabel">إنشاء قسم</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Make departement</h5>
                @endif </span>
                @if (Request::segment(6)=='admin')
               <span class="text-left"> <a href="{{route('modules-show') }}" class="mr-4 btn btn-success">
                  السابق
               </a></span>
               @endif
                <div class="card-body"
                     style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                    <div class="form">
                        <form method="POST" action="{{route('updateServices',$row->id)}}" enctype="multipart/form-data" id="createCar">
                            @csrf
                            <nav>
                                @if(app()->getLocale() == 'ar')
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab"
                                           href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">معلومات
                                            رئيسية</a>
                                    </div>
                                @else
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab"
                                           href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Main
                                            Information</a>
                                       {{--  <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab"
                                           href="#nav-price" role="tab" aria-controls="nav-price" aria-selected="false">Car
                                            Price</a> --}}
                                    </div>
                                @endif
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                     aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        الدولة - المنطقة  <small class="text-danger">*</small>
                                                    @else
                                                        Country-Region <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                
                                                <select class="SpecificInput select2 countChange" dir="rtl"
                                                        name="country_id" >
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}" @if($row->country_id==$country->id)selected
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
                                            <div class="form-group">
                                                <label>
                                                    @if(app()->getLocale() == 'ar')
                                                        المحافظة <small class="text-danger">*</small>
                                                    @else
                                                        Goverment <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                {{-- {{ dd()}} --}}
                                                <select class="SpecificInput govChange" dir="rtl" name="gover_id">
                                                @if($row->gover_id>0)
                                                <option value="">
                                                    <?php $gove=DB::table("countries")->where('id',252)->first();
                                                    ?>
                                                    {{$gove->ar_name}}
                                                </option>
                                                @endif
                                                </select>
                                            </div>
                                            
                                             <div class="form-group">
                                            <label class="Label-AddADS Productsection" for="Productsection">{{__('site.departement')}}</label>
                                                <?php
                                                $lang=app()->getLocale();
                                                $name=$lang=='ar'?'name_ar':'name_en';
                                                $name2=$lang=='ar'?'name_ar':'name_en';
                                                $cats=\App\Cat::where('status',1)->get()
                                                ?>

                                            <select id="category_id" required name="cat_id" class="SpecificInput select2 " title=" اختر  القسم">
                                                
                                                @foreach ($cats as $cat)
                                                    <option value="{{$cat->id}}"
                                                        @if ($row->cat_id==$cat->id)
                                                           selected 
                                                        @endif>{{$cat->$name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="form-group" id="sub_cat_div" 
                                            @if ($row->sub_cat<1)
                                                style="display:none;"
                                            @endif>
                                                <label> {{__('site.sub_cat')}}</label>
<br>
                                                <select class="SpecificInput" dir="rtl" name="sub_cat" id="sub_cat_id">
                                                    @if ($row->sub_cat>0)
                                                        <option value="{{$row->sub_cat}}">{{$row->subCats->name_ar}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group" id="mini_sub_cat_div" @if ($row->mini_sub_cat<1)
                                                style="display:none;"
                                            @endif>
                                                <label> {{__('site.mini_sub_cat')}} </label>

                                                <select name="mini_sub_cat" id="mini_sub_cat_id" class="SpecificInput" >
                                                   @if ($row->mini_sub_cat>0)
                                                        <option value="{{$row->mini_sub_cat}}">{{$row->MiniSubCats->name_ar}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('site.name_ar')}}<small class="text-danger">*</small>
                                                </label>
                                                <input type="text" required class="SpecificInput" name="name_ar" value="{{$row->name_ar}}">
                                            </div>
                                             <div class="form-group">
                                                <label>{{__('site.name_en')}}<small class="text-danger">*</small>
                                                </label>
                                                <input type="text" required class="SpecificInput" name="name_en" 
                                                value="{{$row->name_en}}">
                                            </div>
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
                                                    @if (count($row->images)>0)
                                                        @foreach ($row->images as $img)
                                                         <img src="{{ asset('uploads/'.$img->file) }}" style="width: 100px;height:100px"> @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('site.description_ar')}}<small class="text-danger">*</small></label>
                                                <textarea class="SpecificInput height_text " required
                                                          name="ar_description" @if(old('ar_description') != null){{ old('ar_description') }}@endif>{{$row->ar_description}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('site.description_en')}}<small class="text-danger">*</small></label>
                                                <textarea class="SpecificInput height_text" required
                                                  name="en_description" @if(old('en_description') != null){{ old('en_description') }}@endif>
                                                      
                                                {{$row->en_description}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('site.price')}}<small class="text-danger">*</small>
                                                </label>
                                                <input type="number" required class="SpecificInput" value="{{$row->price}}" name="price">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('site.main_image')}}</label>
                                                <input type="file" name="image"
                                                       class="SpecificInput">
                                                       <img src="{{ asset('uploads/'.$row->image) }}" style="width: 100px;height:100px">
                                            </div>
                                          
                                        </div>

                                    </div>
                                </div>
                             
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('site.close')}}</button>
                                <input type="submit"  id="submitFormCar" name="submit" class="btn btn-primary" value="{{__('site.save')}}">
                            </div>
                        </form>
                    </div>

                </div>


            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $('.countChange').change(function () {
                $.ajax({ 
                    url: "{{url('/')}}/view/goverment/" + $(this).val(),
                    context: document.body
                }).done(function (data) {
                       console.log(data);
                    $('.govChange').find('option').remove().end();
                    $
                    @if(app()->getLocale() == 'ar')
                        .each(data, function (i, item) {
                            $('.govChange').append('<option value="' + item.id + '">' + item.ar_name + '</option>')
                        });
                    @else
                .
                    each(data, function (i, item) {
                        $('.govChange').append('<option value="' + item.id + '">' + item.en_name + '</option>')
                    });
                    @endif

                });
            });
        });
        $(document).ready(function () {
            $('.govChange').change(function () {
             
                $.ajax({
                    url: "{{url('/')}}/view/department/" + $(this).val(),
                    context: document.body
                }).done(function (data) {
                    
                    $('.depChange').find('option').remove().end();
                    $
                    @if(app()->getLocale() == 'ar')
                        .each(data, function (i, item) {
                            $('.depChange').append('<option value="' + item.id + '">' + item.ar_name + '</option>')
                        });
                    @else
                .
                    each(data, function (i, item) {
                        $('.depChange').append('<option value="' + item.id + '">' + item.en_name + '</option>')
                    });
                    @endif

                });
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
            $('#category_id').on('change',function(){
            var sub = $(this).val();
            $('#sub_cat_div').css("display", "block");
        
            if(sub){
                $.ajax({
                    type:"GET",
                    url:"{{route('get-sub-cat-list')}}?sub_id="+sub,
                    success:function(res){
                        console.log(res);
                        if(res){
                            $("#sub_cat_id").empty();
                            $("#mini_sub_cat").empty();
                            $('#mini_sub_cat_div select').val(0);
                            $('#mini_sub_cat_div').css("display", "none");
                            $("#sub_cat_id").append('<option value="0" >'+"تصنيف رئيسى "+'</option>');
                            $.each(res,function(key,value){
                                $("#sub_cat_id").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#sub_cat_id").empty();
                        }
                    }
                });
            }else{
                $("#sub_cat_id").empty();
            }

        });
        $('#sub_cat_id').on('change',function(){

            var sub_id = $(this).val();
            if(sub_id>0){

                $.ajax({
                    type:"GET",
                    url:"{{url('get-mini-sub-cat-list')}}?sub_id="+sub_id,
                    success:function(res){
                        if(res){
                            $('#mini_sub_cat_div').css("display", "block");
                            $("#mini_sub_cat_id").empty();
                            $("#mini_sub_cat_id").append('<option value="0" >'+"تصنيف رئيسى "+'</option>');
                            $.each(res,function(key,value){
                                $("#mini_sub_cat_id").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $('#mini_sub_cat_div').css("display", "none");
                            $("#mini_sub_cat_id").empty();
                        }
                    }
                });
            }else{
                $('#mini_sub_cat_div').css("display", "none");
                $("#mini_sub_cat_id").empty();
            }

        });

    </script>

@endsection
