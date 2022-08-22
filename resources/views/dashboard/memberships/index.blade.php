@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			العضويات
		</h5>
		<a href="{{route('membership-create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i> 
		</a>
		<a href="{{route('membership-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع العضويات
		</label>
		
		<br>

		<table class="table table-stroped table-responsive table-straped text-center">
			<thead class="bg-light ">
				<th>
					رقم
				</th>
				<th>
					الاسم 
				</th>
				<th>
					التكلفة
				</th>
				<th>
					الخصم
				</th>
				<th>
					بداية من
				</th>
				<th>
					 ينتهي في
				</th>
				<th>
					مدة العضوية
				</th>
				<th>
					عدد الاعلانات
				</th>
				
				<th>
					عدد الاشخاص
				</th>
				<th>
					العمليات
				</th>
			</thead>
			<tbody >
				@foreach($memberships as $key=>$membership)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							{{$membership->name}}
						</td>
						<td>
							{{$membership->cost}}
						</td>
						<td>
							{{$membership->discount}}
						</td>
						<td>
							{{$membership->start_date}}
						</td>
						<td>
							{{$membership->end_date}}
						</td>
						<td>
							{{$membership->duration}}
						</td>
						<td>
							{{$membership->limit_posts}}
						</td>
						<td>
							{{$membership->members}}
						</td>
						<td>
							<a href="{{route('membership-edit',$membership->id)}}" class="btn btn-primary btn-xs">
								<i class="fa fa-edit"></i> تعديل 
							</a>
							<a href="{{route('membership-delete',$membership->id)}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i> حذف 
							</a>
						</td>
					</tr>
				@endforeach
				
			</tbody>
		</table>
		{{$memberships->links()}}
	</div>
</div>




@endsection