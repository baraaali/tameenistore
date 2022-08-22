@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
    		الاقسام الجديدة
		</h5>
		<a href="{{route('pages')}}"  class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-angle-left"></i> 
		</a>
		
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
		    جميع الصفحات المحذوفة
		</label>
		
		<br>

		<table class="table table-stroped table-responsive table-straped text-center">
			<thead class="bg-light ">
				<th>
					رقم
				</th>
				<th>
					 الاسم بالعربية 
				</th>
				<th>
					الاسم بالانجليزية
				</th>

				<th>
					نشط
				</th>
				
				<th>
					العمليات
				</th>
			</thead>
			<tbody >
				@foreach($pages as $key=>$page)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							{{$page->ar_name}}
						</td>
						<td>
							{{$page->en_name}}
						</td>
						<td>
							<select class="active">
								<option value="0" {{$page->status == 0 ? 'selected' : ''}}>
									غير نشط
								</option>
								<option value="1" {{$page->status == 1 ? 'selected' : ''}}>
									نشط
								</option>
							</select>
						</td>
						
						<td>
							<a href="{{route('pages-restore',$page->id)}}" class="btn btn-primary btn-xs">
								<i class="fa fa-redo"></i> استرجاع 
							</a>
							<a href="{{route('pages-delete',$page->id)}}" class="btn btn-danger btn-xs">
								<i class="fa fa-trash"></i> حذف 
							</a>
						</td>
					</tr>
				@endforeach
				
			</tbody>
		</table>
		{{$pages->links()}}
	</div>
</div>



@endsection