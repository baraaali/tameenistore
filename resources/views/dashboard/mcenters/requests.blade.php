@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			طلبات مراكز الصيانة 
		</h5>
		{{-- <a href="{{route('centers-create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i>
		</a>
		<a href="{{route('centers-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a> --}}
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<div class="filter col-md-12">
			<div class="row">
				<div class="col-md-4">
                    <div class="form-group">
                        <select value="" class="form-control select2" name="mcenter_id" id="mcenter_id" > 
                            <option value="" selected >إسم المركز</option>
                            @foreach($centers as $center)
                              <option value="{{$center->id}}">
                                  {{$center->ar_name}}
                              </option>
                          @endforeach
                        </select>
                     </div>
                </div>
				<div class="col-md-4">
                    <div class="form-group">
                        <select value="" class="form-control select2" name="country_id" id="country_id"> 
                            <option value="" selected >{{__('site.country')}}</option>
                            @foreach($countries as $country)
                              <option value="{{$country->id}}">
                                  {{$country->ar_name}}
                              </option>
                          @endforeach
                        </select>
                     </div>
                </div>
				<div class="col-md-4">
					<div class="form-group">
						<select value="" class="form-control select2" name="status" id="status"> 
							<option value="" selected >{{__('site.status')}}</option>
							<option value="in review"  >{{__('site.in review')}}</option>
							<option value="approved"  >{{__('site.approved')}}</option>
							<option value="finished"  >{{__('site.finished')}}</option>
							<option value="rejected"  >{{__('site.rejected')}}</option>
							<option value="canceled"  >{{__('site.canceled')}}</option>
						   
						</select>
					 </div>
				</div>
			</div>
		</div>

		<label style="display: block">
			جميع الطلبات   
		</label>

		<br>

		<div class="data-table">
			@include('dashboard.mcenters.requests-table')
		</div>
	</div>
</div>


@endsection
@section('js')

    <script>
		$(document).ready(function(){
			ajax_filter = function()
			{
				var mcenter_id = $('#mcenter_id').val()
				var country_id = $('#country_id').val()
				var status = $('#status').val()
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('requests-post')}}",
					type:'post',
					data : {mcenter_id:mcenter_id,country_id:country_id,status:status},
					success : function(res){
						console.log(res);
				 	$('.data-table').html(res)
					}
				})
			}
			$('#country_id,#status,#mcenter_id').on('change',function(){
			   ajax_filter()
			})

		})


    </script>
@endsection
