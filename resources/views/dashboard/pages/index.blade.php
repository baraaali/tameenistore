@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			 الاقسام الجديدة
		</h5>
		<a href="#" data-toggle="modal" data-target="#create" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i>
		</a>
		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >
			   <i class="fas fa-trash"></i>
		</a>
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
		    جميع الاقسام
		</label>




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
                            <button class="cl_{{$page->id}} btn {{$page->status==0?'btn-danger':'btn-success'}} stat" id="{{$page->id}}" data-url="{{$page->status}}" >
                                {{$page->status==0?'غير نشط':'نشط'}}</button>
                            <input type="hidden" id="statusVal" class="statusVal_{{$page->id}}" value="{{$page->status}}">
                        </td>

						<td>
							<a href="#" data-toggle="modal" data-target="#edit{{$page->id}}" class="btn btn-primary btn-xs">
								<i class="fa fa-edit"></i> تعديل
							</a>
							<a href="{{route('pages-delete',$page->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger">
								<i class="fa fa-trash text-white"></i> حذف
							</a>
						</td>
					</tr>
				@endforeach

			</tbody>
		</table>
		{{$pages->links()}}
	</div>
</div>

<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
      </div>
      <form class="form" method="post" action="{{route('pages-store')}}">
      	@csrf
      <div class="modal-body">
       	<div class="form-group">
       		<label>
       			الاسم بالعربية
       		</label>
       		<input type="text" name="ar_name" class="SpecificInput" required="required">
       	</div>
       	<div class="form-group">
       		<label>
       			الاسم  بالانجليزية
       		</label>
       		<input type="text" name="en_name" class="SpecificInput" required="required">
       	</div>
       	<div class="form-group">
       		<input type="checkbox" name="status" value="1">
       		<label>
       			نشر ؟
       		</label>

       	</div>
      </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">حفظ</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
      </div>
      </form>
    </div>
  </div>
</div>


@foreach($pages as $page)
<div class="modal fade" id="edit{{$page->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
      </div>
      <form class="form" method="post" action="{{route('pages-update')}}">
      	@csrf
      	<input type="hidden" name="id" value="{{$page->id}}">
      <div class="modal-body">
       	<div class="form-group">
       		<label>
       			الاسم بالعربية
       		</label>
       		<input type="text" value="{{$page->ar_name}}" name="ar_name" class="SpecificInput" required="required">
       	</div>
       	<div class="form-group">
       		<label>
       			الاسم  بالانجليزية
       		</label>
       		<input type="text" value="{{$page->en_name}}" name="en_name" class="SpecificInput" required="required">
       	</div>
       	<div class="form-group">
       		<input type="checkbox" {{$page->status == 1 ? 'checked' : ''}} name="status" value="1">
       		<label>
       			نشر ؟
       		</label>

       	</div>
      </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">حفظ</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection

@section('js')

    <script>
        $(':button').on('click', function() {
            var cat_id = $(this).attr('id');
            var row='statusVal_'+cat_id;
            var data = $('.'+row).val();
            var status=data==0?1:0;
            console.log(status);


            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/pages/catChangeStatus',
                data: {'status': status, 'cat_id': cat_id},
                success: function(data){
                    console.log(data.success)
                    console.log(status);
                    var clas='cl_'+cat_id;
                    if(status==1){
                        $('.'+row).attr('value', '1');
                        $('.'+clas).html('نشط');
                        $('.'+clas).removeClass('btn-danger');
                        $('.'+clas).addClass('btn-success');
                    }
                    else{
                        $('.'+row).attr('value', '0');
                        $('.'+clas).html('غير نشط');
                        $('.'+clas).removeClass('btn-success');
                        $('.'+clas).addClass('btn-danger');
                    }

                }
            });
        });
    </script>
@endsection
