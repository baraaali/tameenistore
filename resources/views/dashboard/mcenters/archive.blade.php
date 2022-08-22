@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			مراكز الصيانة
		</h5>
		<a href="{{route('centers')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i> 
		</a>
		<a href="{{route('centers-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع  مراكز الصياة
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
					إسم المركز
				</td>
				<td>
					صورة المركز
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
				@foreach($centers as $key=>$center)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							<button class="btn btn-dark btn-xs">
								{{$center->country->ar_name}}
							</button>
						</td>

						<td>
							<button class="btn btn-primary btn-xs">
								{{$center->owner->name}}
							</button>
						</td>

						<td>
							{{$center->ar_name}}
						</td>

						<td>
							<img src="{{url('/')}}/uploads/{{$center->image}}" style="width:auto;height:50px ">
						</td>
						<td>
							@if($center->special == 0)

							<button class="btn btn-default btn-xs">
								عادية
							</button>
							@elseif ($center->special == 1)

							<button class="btn btn-primary btn-xs">
								فضية
							</button>

							@elseif ($center->special == 2)

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
							@if($center->status == 1)

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
							<a href="{{route('centers-restore',['id'=>$center->id])}}" class="btn btn-primary btn-xs">
								<i class="fa fa-pado"></i> إسترجاع
							</a>
							<a href="{{route('centers-force',['id'=>$center->id])}}" class="btn btn-danger">
								<i class="fa fa-edit"></i> حذف
							</a>
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		{{$centers->links()}}
	</div>
</div>


@endsection