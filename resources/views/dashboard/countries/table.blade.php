<table class="table table-stroped table-responsive   table-responsive">
			<thead class="table-primary">
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
					تعديل
				</td>
            <td>حذف</td>
			</thead>
			<tbody>
				@foreach($countries as $key=>$country)
{{--				<tr class="btn{{$key %2==0?' btn-danger':'btn-warning'}}">--}}
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
						<img src="{{$country->image}}" style="width: auto; height: 25px;" />
					</td>
					<td>
						<a href="{{url('/')}}/dashboard/countries/edit/{{$country->id}}" class="btn btn-primary btn-sm ">
							<i class="fa fa-edit"></i> تعديل
						</a>
					</td>
                    <td>
                        <a onclick="return confirm('Are you sure?')" href="{{url('/')}}/dashboard/countries/delete/{{$country->id}}" class="btn btn-danger btn-sm ">
                            <i class="fa fa-trash text-white"></i> حذف
                        </a>
                    </td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$countries->links()}}