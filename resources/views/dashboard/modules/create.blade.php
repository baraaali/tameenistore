@extends('dashboard.layout.app')
@section('content')
    <?php
    App::setlocale('ar');
    ?>
<div class="card-body"
     style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;" dir="rtl">

    <div class="form-body">
        <form method="POST" action="{{route('modules-store')}}"  enctype="multipart/form-data" novalidate>
            @csrf
                <div class="form-group">
                    <label style="display:block">
                        الصنف <small class="text-danger">*</small>
                    </label>
                    <select id="catChange" class="SpecificInput direction  select2 "
                            name="cat_id" style="width:100%;">
                            <option  value="">
                                {{__('site.choose')}}
                            </option>  
                        @foreach($categories as $category)
                              <option class="direction"  value="{{$category->id}}">
                                {{$category->getName()}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label style="display:block">
                        الصنف الفرعي <small class="text-danger">*</small>
                    </label>
                    <select id="subcatChange" class="SpecificInput direction  select2"
                            name="sub_cat" style="width:100%;">
                            <option class="direction"  value="">
                                {{__('site.choose')}}
                                   
                            </option>
                       
                    </select>
                </div>
                 <div class="form-group">
                    <label style="display:block">
                        الصنف الفرع فرعي 
                    </label>
                    <select id="mincatChange" class="SpecificInput direction  select2"
                            name="mini_sub_cat" style="width:100%;">
                            <option class="direction"  value="">{{__('site.choose')}}</option>
                       
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">الدولة </label>
                        <select class="form-control select2"    name="country_id" id="country">
                            <option value=""  >{{__('site.choose')}}</option>
                            @foreach($countries as $country)
                            <option value="{{$country->id}}">
                                {{$country->getName()}}
                            </option>
                        @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label class="control-label">المنطقة </label>
                        <select class="form-control select2 register_inputs" value="{{old('gover_id')}}"  name="gover_id"  id="governorate">
                            <option value=""  >{{__('site.choose')}}</option>
                        </select>
                </div>
                <div class="form-group">
                    <label class="control-label">المدينة </label>
                        <select class="form-control select2 register_inputs" value="{{old('city_id')}}"  name="city_id" id="city">
                            <option value=""  >{{__('site.choose')}}</option>
                        </select>
                </div>

                <div class="form-group">
                    <label>
                        إسم الاعلان بالعربية <small class="text-danger">*</small>
                    </label>
                    <input type="text" required="required" name="name_ar" maxlength="191" class="SpecificInput">
                </div>

                <div class="form-group">
                    <label>
                        إسم الاعلان بالانجليزيه <small
                            class="text-danger">*</small>
                    </label>
                    <input type="text" required="required" name="name_en" maxlength="191" class="SpecificInput">
                </div>

                <div class="form-group">
                    <label>
                        الوصف بالعربية <small
                            class="text-danger">*</small>
                    </label>
                    <textarea required="required" name="ar_description"
                              style="min-height: 100px"
                              class="SpecificInput"></textarea>
                </div>

                <div class="form-group">
                    <label>
                        الوصف بالانجليزيه <small
                            class="text-danger">*</small>
                    </label>
                    <textarea required="required" name="en_description"
                              style="min-height: 100px"
                              class="SpecificInput"></textarea>

                </div>

                <div class="form-group">
                    <label>
                        السعر <small class="text-danger">*</small>
                    </label>
                    <input type="text"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                           required="required" name="price"
                           class="SpecificInput">
                </div>
                <div class="form-group">
                    <label>{{__('site.ads_type')}}
                    </label>
                    <select name="type" class="SpecificInput" id="type">
                        <option>{{__('site.select')}}</option>
                        @foreach(\App\NewServiceMembership::get() as $price)
                            <option value="{{$price->id}}">{{$price->getName()}}</option>
                        @endforeach
                    </select>
                </div>
              
            <div class="form-group">
                <label>
                    الصورة الرئيسية <small
                        class="text-danger">*</small>
                </label>
                <input type="file" name="main_image" class="SpecificInput">
            </div>
            <div>
                <label for="images">Select Images:</label>
                <input type="file" id="images" name="images[]" multiple><br><br>


            </div>

              <input type="submit" name="submit" class="btn btn-primary"
                           value="{{__('site.save')}}">
        </form>
    </div>


</div>



@endsection
@section('js')
<script>
     var csrf =  $('meta[name="csrf-token"]').attr('content');
     var lang =  $('meta[name="lang"]').attr('content');
    var getSubCategories = function()
    {
        $('#catChange').on('change',function(){
            var id= $(this).val()
            if(id)
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('modules.sub-category-list')}}",
                type:'post',
                data:{id:id},
                success : function(categories){
                    console.log(categories);
                    var html  = ''
                    categories.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e['name_'+lang]+'</option>'
                    });
                    $('#subcatChange').html(html)
                    $('#subcatChange').trigger('change')
                },error:function($e){
                    console.log($e);
                }
            })
        })
    }
    var getMiniSubCategories = function()
    {
        $('#subcatChange').on('change',function(){
            var id= $(this).val()
            if(id)
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('modules.mini-sub-category-list')}}",
                type:'post',
                data:{id:id},
                success : function(categories){
                    console.log(categories);
                    var html  = ''
                    categories.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e['name_'+lang]+'</option>'
                    });
                    $('#mincatChange').html(html)
                },error:function($e){
                    console.log($e);
                }
            })
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
    $(document).ready(function(){
        getSubCategories()
        getMiniSubCategories()
        getGovernorates()
        getCities()
    })
    $('document').ready(function(){
       var country_id =  $('meta[name="country_id"]').attr('content');
       $('#country').val(country_id)
       $('#country').trigger('change')
    })
</script>
@endsection