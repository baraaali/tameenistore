@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			اعلانات السيارات
		</h5>
		<a href="{{route('cars-create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i> 
		</a>
		<a href="{{route('cars')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-angle-left"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع   الاعلانات
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
					إسم   العربية
				</td>
				<td>
					البراند
				</td>
				<td>
					المودل
				</td>
				<td>
					السعر
				</td>
				<td>
					 الحالة
				</td>
				<td>
					  نوع الاعلان
				</td>
				<td>
					 الزيارات
				</td>
				<td>
					العمليات
				</td>
				
			</thead>
			<tbody >
				@foreach($cars as $key=>$car)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							<button class="btn btn-dark btn-xs">
								{{$car->country->ar_name}}
							</button>
						</td>

						<td>
							<button class="btn btn-primary btn-xs">
								{{$car->OwnerInformation->User->name}}
							</button>
						</td>

						<td>
							{{$car->ar_name}}
						</td>
						<td>
							{{$car->brand->name}}
						</td>
						<td>
							{{$car->model->name}}
						</td>
						<td>
							<button class="btn btn-success btn-xs">
								{{$car->Price->currency}} {{$car->Price->cost }} 
							</button>
						</td>

						<td>
							<select class=" status" name="status" >
								<option vlaue="0" {{$car->status == 0 ? 'selected' : ''}}>
									غير نشط
								</option>
								<option value="1" {{$car->status == 1 ? 'selected' : ''}}>
									نشط
								</option>
							</select>
							
						</td>
						<td>

							<select class="special" name="special">
								<option value="0" {{$car->special == 0 ? 'selected' : ''}}>
									عادي
								</option>
								<option value="1" {{$car->special == 1 ? 'selected' : ''}}>
									مفضل
								</option>
								<option value="2" {{$car->special == 2 ? 'selected' : ''}}>
									فضي
								</option>
								<option value="3" {{$car->special == 3 ? 'selected' : ''}}>
									مميز
								</option>
							</select>
							
							
						</td>
						<td>
							{{$car->visitors}}
						</td>
						<td>
							<a href="{{route('cars-restore',$car->id)}}" class="btn btn-primary btn-xs">
								<i class="fa fa-redo"></i> إسترجاع
							</a>
							<a href="{{route('cars-force',$car->id)}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i> حذف
							</a>
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		{{$cars->links()}}
	</div>
</div>


@endsection