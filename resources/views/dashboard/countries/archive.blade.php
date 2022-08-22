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
		<a href="{{route('countries')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-angle-left"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع المناطق
		</label>
		
		<br>

		<table class="table table-stroped table-responsive ">
			<thead class="bg-light ">
				<td>
					رقم
				</td>
				<td>
					الاسم بالعربية
				</td>
				<td>
					الاسم  بالانجليزية
				</td>
				<td>
					كود الدولة بالعربية
				</td>
				<td>
					كود الدولة بالانجليزية
				</td>
				<td>
					عملة الدولة بالعربية
				</td>
				<td>
					عملة الدولة بالانجلزية
				</td>
				<td>
					الصورة
				</td>
				<td>
					العمليات
				</td>
			</thead>
			<tbody >
				@foreach($countries as $key=>$country)
				<tr>
					<td>
						{{$key+1}}
					</td>
					<td>
						{{$country->ar_name}}
					</td>
					<td>
						{{$country->en_name}}
					</td>
					<td>
						{{$country->ar_code}}
					</td>
					<td>
						{{$country->en_code}}
					</td>
					<td>
						{{$country->ar_currency}}
					</td>
					<td>
						{{$country->en_currency}}
					</td>
					<td>
						<img src="{{url('/')}}/uploads/{{$country->image}}" style="width: 35px; height: 35px;"  style="border-radius: 50%" />
					</td>
					<td>
						<a href="{{url('/')}}/dashboard/countries/restore/{{$country->id}}" class="btn btn-primary btn-xs">
							<i class="fa fa-redo"></i> إسترجاع
						</a>
						<a href="{{url('/')}}/dashboard/countries/force/{{$country->id}}" class="btn btn-danger">
							<i class="fa fa-trash text-white"></i> حذف
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$countries->links()}}
	</div>
</div>


@endsection