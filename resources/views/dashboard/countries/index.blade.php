@extends('dashboard.layout.app')
@section('content')

<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			البلاد و المناطق
		</h5>
		<a href="{{route('countries-create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i>
		</a>
		<a href="{{route('countries-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a>
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
			@include('dashboard.countries.table')
		</div>
	</div>
</div>

@endsection

@section('js')
	<script>
		$(document).ready(function(){
			$('#search').on('input',function(){
				var search = $(this).val()
				if(search)
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('countries-post')}}",
					type:'post',
					data : {search:search},
					success : function(res){
						$('.data-table').html(res)
					}

				})
				
			})
		})
	</script>
@endsection
