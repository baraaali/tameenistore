@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			الاعضاء
		</h5>

		<a href="{{route('users')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-angle-left"></i> 
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع العملاء المحذوفين
		</label>
		
		<br>

		<table class="table table-stroped table-responsive ">
			<thead class="bg-light ">
				<th>
					الرقم
				</th>
				<th>
					الاسم
				</th>
				<th>
					البريد الالكتروني
				</th>
				<th>
					العضوية
				</th>
				<th>
					نوع الحساب
				</th>
				<th>
					حذف 
				</th>
			</thead>
			<tbody >
				@foreach($users as $key=>$user)
					<tr>
						<td>
							{{$key+1}}
						</td>
						<td>
							{{$user->name}}
						</td>
						<td>
							{{$user->email}}
						</td>
						<td>
							
						</td>
						<td>
							
						</td>
						<td>
							<a href="{{route('users-restore',$user->id)}}" class="btn btn-primary btn-xs">
								<i class="fa fa-redo"></i>
								استعادة
							</a>
						</td>
					</tr>

				@endforeach
			</tbody>
		</table>
		{{$users->links()}}
	</div>
</div>


@endsection