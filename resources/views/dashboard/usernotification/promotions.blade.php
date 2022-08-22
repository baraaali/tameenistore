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

 App::setlocale('ar');


$name = app()->getLocale() == 'ar' ? 'ar_name' : 'fr_name'
?>
   
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			البلاد و المناطق
		</h5>
		{{-- <a href="{{route('governorates-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a> --}}
	</div>

	<div class="card-body" style="background-color: white;color:#31353D">
		{{-- <div class="filter col-md-4">
			<div class="form-group">
			  <input type="text" class="form-control" id="search"  placeholder="بحث">
			</div>
		</div> --}}
		<br>
		
		<div class="data-table">
			@include('dashboard.usernotification.table-promotions')
		</div>
	</div>
</div>

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
                <form id="promotion-update-form" action="{{route('promotion-update')}}" method="post">
                    <div class="form-group">
                      <input type="hidden"  name="id">
                      @csrf
                      <label for="status">{{__('site.status')}}</label>
                      <select class="form-control" name="status" id="status">
                        <option value="in review">{{__('site.in review')}}</option>
                        <option value="approved">{{__('site.approved')}}</option>
                        <option value="rejected">{{__('site.rejected')}}</option>
                      </select>
                    </div>
                    <div id="notes" class="form-group">
                      <label for="notes">{{__('site.notes')}}</label>
                      <textarea class="form-control" name="notes"  rows="3"></textarea>
                       <button type="submit" class="btn btn-primary my-4">{{__('site.confirm')}}</button>
                    </div>
                </form>

                <h1 class="subject text-center mb-3">  </h1>
                <img class="m-auto w-100 image" src="#">
                <p class="text-justify mt-3 body"></p>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<form></form>

@endsection()

@section('js')
 <script>
    var csrf =  $('meta[name="csrf-token"]').attr('content');
    var submitFromStatus = function()
    {
        $('#promotion-update-form #status').on('change',function(){
            if($(this).val() == 'rejected')
            $('#notes').show()
            else {
                $('#notes').hide()
                $('#promotion-update-form').submit()
            }
        })
    }
     var viewAd = function()
     {
        $('.btn-view').on('click',function(){
            $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "/promotion/show/"+$(this).attr('_id'),
					type:'get',
					success : function(res){
                       if(res != null)
                       {
                        $('.modal .image').attr('src',"{{url('/')}}/uploads/"+res.image)
                        $('.modal .subject').html(res.subject)
                        $('.modal #status').val(res.status)
                        $('[name="id"]').val(res.id)
                        $('[name="notes"]').html(res.notes)
                        $('.modal .body').html(res.body)
                        $('.preview-modal-btn').trigger('click')
                       }
                    }
                })
        })
     }
     $(document).ready(function(){
        viewAd()
        $('#notes').hide()
        submitFromStatus()
     })
 </script>

@endsection