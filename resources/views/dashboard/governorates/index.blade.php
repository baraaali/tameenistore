@extends('dashboard.layout.app')
@section('css')
    <style>
    .select2-container{
     display:block
        }
    </style>
@endsection

@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			البلاد و المناطق
		</h5>
		<a href="{{route('governorates-create')}}" class="btn btn-light"   style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i>
		</a>
		{{-- <a href="{{route('governorates-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a> --}}
	</div>

	<div class="card-body" style="background-color: white;color:#31353D">
		<div class="filter col-md-4">
			<div class="form-group">
			  <input type="text" class="form-control" id="search"  placeholder="بحث">
			</div>
		</div>
		<label style="display: block">
			جميع المناطق
		</label>

		<br>
		
		<div class="data-table">
			@include('dashboard.governorates.table')
		</div>
	</div>
</div>
<div class="data-edit">
    {{-- @include('dashboard.governorates.edit') --}}
</div>
@endsection

@section('js')
	<script>
		$(document).ready(function(){
			$('#search').on('input',function(){
				var search = $(this).val()
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('governorates-post')}}",
					type:'post',
					data : {search:search},
					success : function(res){
						$('.data-table').html(res)
					}

				})
			})
            $('.btn-edit').on('click',function(){
                var id = $(this).attr('_id')
                $.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{url('/')}}/dashboard/governorates/edit/"+id,
					type:'get',
					success : function(res){
                        console.log(res);
						$('.data-edit').html(res)
                        $('.select2').select2()
                        $(".select2").val($('.select2').attr('value')).trigger('change');
                        $('#edit').modal('show')
					}
		        })
		})
		})
	</script>
@endsection
