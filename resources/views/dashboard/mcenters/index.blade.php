@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			مراكز الصيانة
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
						<input type="text" class="form-control" id="search"  placeholder="بحث">
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
							<option value="1"  >{{__('site.active')}}</option>
							<option value="0"  >{{__('site.deactive')}}</option>
						   
						</select>
					 </div>
				</div>
			</div>
		</div>

		<label style="display: block">
			جميع  مراكز الصياة
		</label>

		<br>

		<div class="data-table">
			@include('dashboard.mcenters.table')
		</div>
	</div>
</div>


@endsection
@section('js')

    <script>
		var renewal_id = 0
		var renewal = function()
		{
			$(document).on('click','.renewal-save',function(){
			var $check =  $('#renewal').find('input');
             if($($check).is(':checked') && renewal_id )
			 {
			 $('#renewal-id').val(renewal_id)
			 $('#renewal-form').submit()
			 }
			})
			$(document).on('click','.renewal',function(){
			$('#renewal').modal('show')
			 renewal_id = $(this).attr('_id')
          })
		}
       
		var changeStatus = function(){

			var setStatus = function($this){
				var status = $this.attr('data-status');
				status = status == 0 ? 1 : 0 ;
				var id = $this.attr('data-id');
				$.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/mcenters/centerChangeStatus',
                data: {'status': status, 'center_id': id},
                success: function(res){
					if(res.success){
						var status = res.status;
						$this.attr('data-status',status)
						if(status == 1){
						$this.removeClass('badge-danger')
						$this.addClass('badge-success')
						$this.html("{{__('site.active')}}")
						}else{
						$this.removeClass('badge-success')
						$this.addClass('badge-danger')
						$this.html("{{__('site.active')}}")
						$this.html("{{__('site.inactive')}}")
						}
					}
					}
            });
			}
			 $('.change_status').on('click',function(){
				setStatus($(this))
			})
		}

		$(document).ready(function(){
			renewal()
			changeStatus()
			ajax_filter = function()
			{
				var search = $('#search').val()
				var country_id = $('#country_id').val()
				var status = $('#status').val()
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('centers-post')}}",
					type:'post',
					data : {search:search,country_id:country_id,status:status},
					success : function(res){
				 	$('.data-table').html(res)
					}
				})
			}
			$('#search').on('input',function(){
			   ajax_filter()
			})
			$('#country_id,#status').on('change',function(){
			   ajax_filter()
			})

		})

        $(':button').on('click', function() {
            var center_id = $(this).attr('id');
            var row='statusVal_'+center_id;
            var data = $('.'+row).val();
            var status=data==0?1:0;
         
        });
    </script>
@endsection
