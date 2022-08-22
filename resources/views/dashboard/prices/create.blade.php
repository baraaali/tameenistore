@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
		    أقسام داخل الصفحات
		</h5>
		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			إنشاء قسم جديد
		</label>
		<form method="POST" action="{{url('/')}}/">
		    @csrf
		</form>
			
	
	</div>
</div>




@endsection