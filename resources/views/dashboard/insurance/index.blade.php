@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			التأمينات الشاملة
		</h5>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع التامينات الشاملة
		</label>

		<br>

		<table class="table table-stroped table-responsive ">
			<thead class="bg-light ">
				<td>
					رقم
				</td>
				<td>
				   اسم المستخدم
				</td>
				<td>
				اسم الشركة
				</td>
				<td>
				موديل السيارة
				</td>
				<td>
				 براند
				</td>
				<td>
				يبدأ في
				</td>
				<td>
				ينتهي في
				</td>
				<td>
					العمليات
				</td>

			</thead>
			<tbody >

				@foreach($CompleteDocs as $CompleteDoc)
					<tr>
						<td>{{$CompleteDoc->id}}</td>
						<td>{{$CompleteDoc->User->name}}</td>
						<td>{{$CompleteDoc->Insurance_Company_ar}}</td>
						<td>{{$CompleteDoc->idmodel->name}}</td>
						<td>{{$CompleteDoc->idbrand->name}}</td>
						<td>{{$CompleteDoc->created_at}}</td>
						<td>{{$CompleteDoc->end_date}}</td>
						<td>
							<a href="{{route('delete-ComDoc',$CompleteDoc->id)}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i> حذف
							</a>
							@if($CompleteDoc->status == 1)
							<a href="{{route('deactive-comp',$CompleteDoc->id)}}" class="btn btn-primary btn-xs">
								<i class="far fa-times-circle"></i> تعطيل
							</a>
							@else
							<a href="{{route('active-comp',$CompleteDoc->id)}}" class="btn btn-success btn-xs">
								<i class="far fa-check-circle"></i> تفعيل
							</a>
							@endif
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		{{$CompleteDocs->links()}}
	</div>
</div>


@endsection
