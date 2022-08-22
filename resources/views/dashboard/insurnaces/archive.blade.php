@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			الوكالات
		</h5>
		<a href="{{route('agents-create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i> 
		</a>
		<a href="{{route('agents',0)}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-angle-left"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع  الوكالات
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
					إسم  الوكالة
				</td>
				<td>
					صورة  الوكالة
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
				@foreach($agents as $key=>$agent)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							<button class="btn btn-dark btn-xs">
								{{$agent->country->ar_name}}
							</button>
						</td>

						<td>
							<button class="btn btn-primary btn-xs">
								{{$agent->owner->name}}
							</button>
						</td>

						<td>
							{{$agent->ar_name}}
						</td>

						<td>
							<img src="{{url('/')}}/uploads/{{$agent->image}}" style="width:auto;height:50px ">
						</td>
						<td>
							@if($agent->special == 0)

							<button class="btn btn-default btn-xs">
								عادية
							</button>
							@elseif ($agent->special == 1)

							<button class="btn btn-primary btn-xs">
								فضية
							</button>

							@elseif ($agent->special == 2)

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
							@if($agent->status == 1)

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
							<a href="{{route('agents-restore',$agent->id)}}" class="btn btn-primary btn-xs">
								<i class="fa fa-redo"></i> إسترجاع
							</a>
							<a href="{{route('agents-delete',$agent->id)}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i> حذف
							</a>
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		{{$agents->links()}}
	</div>
</div>


@endsection