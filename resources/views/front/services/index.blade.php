@extends('layouts.app')


@section('content')
<div class="container">
  <!-- start  banner-->
  <div style="direction: ltr" class="owl-carousel banners owl-theme">
    @foreach ($banners as $banner)
    <div class="item"><img  src="{{asset('uploads/'.$banner->file)}}"></div>
    @endforeach
</div>         
<!-- end banner -->
 <div class="container">
     <section>
         <ol class="breadcrumb bg-light">
             <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('site.home')}}</a></li>
             <li class="breadcrumb-item"></li>
             <li class="breadcrumb-item active">{{__('site.ads')}}</li>
         </ol>
         <div class="row">
             <div class="col-md-12">
                 <h4 class="text-right px-4">{{__('site.number of ads')}} {{$services_count}}</h4>
             </div>
         </div>
     </section>
     <section>
         <div class="container">
            <div class="filter row">
                <div class="col-md-4">
                     <div  class="form-group">
                       <label class="text-right d-block" for="search">{{__('site.search')}}</label>
                       <input type="text" class="search-field form-control text-right" name="search" placeholder="بحث">
                     </div>

                </div>
                <div class="col-md-8">
                   <div class="row">
                   <div class="col-md-3">
                    <div class="form-group">
                        <label style="display:block">
                            الصنف <small class="text-danger">*</small>
                        </label>
                        <select id="catChange" class="SpecificInput direction  select2 "
                                name="cat_id" style="width:100%;">
                                <option  value="">
                                    {{__('site.choose')}}
                                </option>  
                            @foreach($services_categories as $category)
                                  <option class="direction"  value="{{$category->id}}">
                                    {{$category->getName()}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                   </div>
                   <div class="col-md-3">
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
                   </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="display:block">
                            الصنف الفرع فرعي 
                        </label>
                        <select id="mincatChange" class="SpecificInput direction  select2"
                                name="mini_sub_cat" style="width:100%;">
                                <option class="direction"  value="">{{__('site.choose')}}</option>
                           
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button  type="button" class="btn btn-primary search mt-4 w-100">{{__('site.search')}}</button>
                </div>
                   </div>
                </div>
                </div>
            </div>
        
     </section>
     <section class="my-4">
        <div class="col-md-12 loading  d-none">
            <div class="d-flex justify-content-center ">
                <div class="spinner-border  m-5" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
             </div>
           </div>
         <div class="col-md-12 ads">
            @include('front.services.items')
         </div>
         
     </section>
     
 </div>


@endsection

@section('js')
<script>
  
var csrf =  $('meta[name="csrf-token"]').attr('content');
 var lang =  $('meta[name="lang"]').attr('content');
 var search_fields = {}

    var getSubCategories = function()
    {
        $('#catChange').on('change',function(){
            var id= $(this).val()
            search_fields[$(this).attr('name')] = $(this).val()
            if(id.length)
            {
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('modules.sub-category-list')}}",
                type:'post',
                data:{id:id},
                success : function(categories){
                    var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
                    categories.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e['name_'+lang]+'</option>'
                    });
                    $('#subcatChange').html(html)
                    $('#subcatChange').trigger('change')
                    var sub_cat = "{{request()->sub_cat}}";
                    if(sub_cat.length && sub_cat != 'all')
                    {
                        $('#subcatChange').val(sub_cat)
                        $('#subcatChange').trigger('change')
                    }
                },error:function($e){
                    console.log($e);
                }
            })
        }else{
            var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
            $('#subcatChange').html(html)
        }
        })
    }
    var getMiniSubCategories = function()
    {
        $('#subcatChange').on('change',function(){
            var id= $(this).val()
            search_fields[$(this).attr('name')] = $(this).val()
            if(id){
            $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('modules.mini-sub-category-list')}}",
                type:'post',
                data:{id:id},
                success : function(categories){
                    var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
                    categories.forEach(e => {
                    html+= '<option value="'+e.id+'">'+e['name_'+lang]+'</option>'
                    });
                    $('#mincatChange').html(html)
                    console.log(html);
                    $('#mincatChange').trigger('change')

                },error:function($e){
                    console.log($e);
                }
            })
          }else{
            var html  = '<option value="">'+'{{__("site.choose")}}'+'</option>'
            $('#mincatChange').html(html)
        }
        })
    }
    
    var miniCategoriesChange = function()
    {
        $('#mincatChange').on('change',function(){
            search_fields[$(this).attr('name')] = $(this).val()
        })

    }
    var search = function()
    {
        $('.search').on('click',function(){
            search_fields['search'] = $('.search-field').val()
            $('.loading').removeClass('d-none')
            $('.ads div').addClass('d-none')
            $.ajax({
                type: "POST",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route("search-services")}}',
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
            console.log(search_fields);
        })
    }

    var getPage = function()
    {
        var cat_id = "{{request()->cat_id}}";
        if(cat_id.length && cat_id != 'all')
        {
            $('#catChange').val(cat_id)
           $('#catChange').trigger('change')
        } 
      
    }
    var init = function()
    {
        getSubCategories()
        getMiniSubCategories()
        miniCategoriesChange()
        search()
        getPage()
    }
    $(document).ready(function(){
        init()
        $('.like-action').on('click',function(){

            window.setLike($(this),'services')
        })
    })
</script>
    
@endsection