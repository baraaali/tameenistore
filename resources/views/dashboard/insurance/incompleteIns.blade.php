@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			تأمينات ضد الغير
		</h5>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع تأمينات ضد الغير
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
<!--			    --><?//  ?>
				@foreach($IncompleteDocs as $IncompleteDoc)
					<tr>
						<td>{{$IncompleteDoc->id}}</td>
						<td>{{$IncompleteDoc->User->name}}</td>
						<td>{{$IncompleteDoc->Insurance_Company_ar}}</td>
						<td>{{$IncompleteDoc->idmodel->name}}</td>
						<td>{{$IncompleteDoc->idbrand->name}}</td>
						<td>{{$IncompleteDoc->created_at}}</td>
						<td>{{$IncompleteDoc->end_date}}</td>
						<td>
							<a href="{{route('delete-InComDoc',$IncompleteDoc->id)}}" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i> حذف
							</a>
							@if($IncompleteDoc->status == 1)
							<a href="{{route('deactive-IncComp',$IncompleteDoc->id)}}" class="btn btn-primary btn-xs">
								<i class="far fa-times-circle"></i> تعطيل
							</a>
							@else
							<a href="{{route('active-IncComp',$IncompleteDoc->id)}}" class="btn btn-success btn-xs">
								<i class="far fa-check-circle"></i> تفعيل
							</a>
							@endif
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		{{$IncompleteDocs->links()}}
	</div>
</div>


@endsection
