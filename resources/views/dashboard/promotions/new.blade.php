@extends('dashboard.layout.app')

@section('css')
<style>
    .ck-content{
    height: 300px !important;
    overflow: auto !important;
    } 
</style>
@endsection

@section('content')
<?php

if ($lang == 'ar' || $lang == 'en') {
    App::setlocale($lang);
} else {
    App::setlocale('ar');
}

$name = app()->getLocale() == 'ar' ? 'ar_name' : 'en_name'
?>
<input type="hidden"  id="lang" value="{{app()->getLocale()}}">

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
<div class="col-lg-12" >
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{__('site.new promotion')}}</h4>

<div class="col-lg-12">
    <form id="promotion-form"     enctype="multipart/form-data" action="{{route('promotion-new-post')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
    
                        <div class="card text-white bg-primary shadow">
                            <div class="card-header">
                                <h5 style="position: relative;display: inline-block;top: 6px;">
                                    {{__('site.new promotion')}}
                                </h5>
                               
                            </div>
                            <div class="card-body" style="background-color: white;color:#31353D">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ad-type">{{__('site.ad type')}}</label>
                                            <select class="form-control" name="ad_type" id="ad-type">
                                              <option value="cars">{{__('site.car ads')}}</option>
                                              <option value="categories">{{__('site.subcategories ads')}}</option>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ad-name">{{__('site.ad name')}}</label>
                                            <select class="form-control" name="ad_id" id="ad-name">
                                              <option>{{__('site.choose')}}</option>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6 class="my-3"><strong>{{__('site.geography target')}}  <span class="text-success target-count">0</span></strong></h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country">{{__('site.country')}}</label>
                                            <select class="form-control select2" multiple="multiple"  name="countries[]" id="country">
                                              <option value="" disabled  >{{__('site.choose')}}</option>
                                              @foreach($countries as $country)
                                              <option value="{{$country->id}}">
                                                  {{$country->$name}}
                                              </option>
                                          @endforeach
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="governorate">{{__('site.governorate')}}</label>
                                            <select class="form-control select2"  multiple="multiple" name="governorates[]" id="governorate">
                                              <option value="" disabled >{{__('site.choose')}}</option>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city">{{__('site.city')}}</label>
                                            <select class="form-control select2"  multiple="multiple" name="cities[]" id="city">
                                              <option value="" disabled >{{__('site.choose')}}</option>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subject">{{__('site.subject')}}</label>
                                            <input type="text" class="form-control" name="subject" id="subject" aria-describedby="subject" placeholder="{{__('site.subject')}}">
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="image">{{__('site.principal image')}}</label>
                                            <input type="file" class="form-control" name="image" id="image" >
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="body">{{__('site.ad body')}}</label>
                                          <input type="hidden" name="body" >
                                          <textarea class="form-control" id="body" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-block text-right">
                                        <button type="button" class="btn btn-primary submit">{{__('site.submit for review')}}</button>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

      </div>
    </div>
</div>


<!-- Button trigger modal -->
<button type="button" class="d-none  preview-modal-btn" data-toggle="modal" data-target="#preview-modal"></button>
<!-- Modal -->
<div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">{{__('site.ad preview')}}</h5>
            </div>
            <div class="modal-body">
                <h1 class="subject text-center mb-3">  </h1>
                <img class="m-auto w-100 image" src="#">
                <p class="text-justify mt-3 body"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary confirm-add">{{__('site.confirm')}}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
  <script>
      var csrf =  $('meta[name="csrf-token"]').attr('content');
      var lang = $('#lang').val()
      var editor,image
    
      var getGovernorates = function()
        {
            $('#country').on('change',function(){
                var ids= $(this).val()
                if(ids && ids.length)
                $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('cities-get-governorates-post')}}",
					type:"post",
                    data:{ids:ids},
					success : function(governorates){
                        var html  = ''
                        governorates.forEach(e => {
                        html+= '<option value="'+e.id+'">'+e[lang+'_name']+'</option>'
                        });
                        $('#governorate').html(html)
                        $('#governorate').trigger('change')
                    },
                    error:function(e){
                        console.log(e)
                    }
                })
            })
        } 
       var getCities = function()
        {
            $('#governorate').on('change',function(){
                var ids = $(this).val()
                if(ids && ids.length)
                $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('cities-get-post')}}",
					type:'post',
                    data:{ids:ids},
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
      
      var setAds = function(ads)
      {
          var html  = ''
          ads.forEach(e => {
              html+= '<option value="'+e.id+'">'+e[lang+'_name']+'</option>'
          });
          $('#ad-name').html(html)
      }
      var getTargetCount = function()
      {
        $('#country,#governorate,#city').on('change',function(){
                var country = $('#country').val()
                var governorate = $('#governorate').val()
                var city = $('#city').val()
                $.ajax({
                    headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('promotion-target-count')}}",
					type:'post',
                    data:{country:country,governorate:governorate,city:city},
					success : function(count){
                        $('.target-count').html(count)
                    }
                })
        })
      }
      var getAdsByType = function()
      {
          var call_ajax = function(type){
            var type = $('#ad-type').val()
             $.ajax({
                headers: {'X-CSRF-TOKEN': csrf},
                url: "{{route('promotion-get-ads')}}",
                type:'post',
                data:{type: type},
                success : function(ads){
                    setAds(ads)
                }
		        })
          }
          call_ajax()
          $('#ad-type').on('change',function(){
             call_ajax()
          })
      }
      var chargePreview = function()
      {
          var subject = $('#subject').val()
          var body =  $('[name="body"]').val()
          if(subject.length && body.length && image){
          $('.modal .image').attr('src',URL.createObjectURL(image))
          $('.modal .subject').html(subject)
          $('.modal .body').html(body)
          $('.preview-modal-btn').trigger('click')
          }
          else
          alert('No preview of this ad')
          $('.confirm-add').on('click',function(){
            $('#promotion-form').submit()
          })
          
      }
      var submit = function()
      {
          $('.submit').on('click',function(){
              $('[name="body"]').val(editor.getData())
              chargePreview()
          })
      }
      var init = function()
      {
          $('.select2').select2()
          ClassicEditor
        .create( document.querySelector( '#body'),{
            language: 'ar'
        }).then(e=>{
            editor = e
        })
        .catch( error => {
            console.error( error );
        } );
        $('#image').on('change',function(event){
           if(event.target.files.length)
           image =  event.target.files[0]
        })
      }
      $(document).ready(function(){
        getAdsByType()
        getGovernorates()
        getCities()
        getTargetCount()
        submit()
        init()
      })
  </script>
@endsection
