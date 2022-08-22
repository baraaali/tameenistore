@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			المعارض
		</h5>
		<a href="{{route('exhibitors-create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i> 
		</a>
		<a href="{{route('exhibitors-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع المعارض
		</label>
		
		<br>

		<table class="table table-stroped table-responsive ">
			<thead class="bg-light ">
				<td>
					رقم
				</td>
				<td>
					الدولة - المنطقة
				</td>
				<td>
					إسم  المستخدم
				</td>
				<td>
					إسم المعرض
				</td>
				<td>
					صورة المعرض
				</td>
				<td>
					  نوع العضوية
				</td>
				<td>
					الحالة
				</td>
				<td>
					العمليات
				</td>
				
			</thead>
			<tbody >
				@foreach($exhibitors as $key=>$exhibitor)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							<button class="btn btn-dark btn-xs">
								{{$exhibitor->country->ar_name}}
							</button>
						</td>

						<td>
							<button class="btn btn-primary btn-xs">
								{{$exhibitor->owner->name}}
							</button>
						</td>

						<td>
							{{$exhibitor->ar_name}}
						</td>

						<td>
							<img src="{{url('/')}}/uploads/{{$exhibitor->image}}" style="width:auto;height:50px ">
						</td>
						<td>
							@if($exhibitor->special == 0)

							<button class="btn btn-default btn-xs">
								عادية
							</button>
							@elseif ($exhibitor->special == 1)

							<button class="btn btn-primary btn-xs">
								فضية
							</button>

							@elseif ($exhibitor->special == 2)

							<button class="btn btn-danger">
								ذهبية
							</button>

							@else

							<button class="btn btn-success btn-xs">
								مميزة
							</button>

							@endif
							
						</td>
						<td>
							@if($exhibitor->status == 1)

							<button class="btn btn-success btn-xs">
								نشط
							</button>
							@else

							<button class="btn btn-danger">
								غير نشط
							</button>

							@endif
						</td>
						<td>
							<a href="{{route('exhibitors-edit',['id'=>$exhibitor->id])}}" class="btn btn-primary btn-xs">
								<i class="fa fa-edit"></i> تعديل
							</a>
							<a href="{{url('/')}}/dashboard/exhibitors/delete/{{$exhibitor->id}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i> حذف
							</a>
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		{{$exhibitors->links()}}
	</div>
</div>


@endsection