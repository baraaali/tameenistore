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
		<a href="{{route('cats-archive')}}"  class="btn btn-light"  style="float: left" >
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
				@foreach($cats as $key=>$cat)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							{{$cat->name_ar}}
						</td>
						<td>
							{{$cat->name_en}}
						</td>
                        <td>
                            <button class="cl_{{$cat->id}} btn {{$cat->status==0?'btn-danger':'btn-success'}} stat" id="{{$cat->id}}" data-url="{{$cat->status}}" >
                                {{$cat->status==0?'غير نشط':'نشط'}}</button>
                            <input type="hidden" id="statusVal" class="statusVal_{{$cat->id}}" value="{{$cat->status}}">
                        </td>

						<td>
							<a href="#" data-toggle="modal" data-target="#edit{{$cat->id}}" class="btn btn-primary btn-xs">
								<i class="fa fa-edit"></i> تعديل
							</a>
							<a href="{{route('cats-delete',$cat->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs">
								<i class="fa fa-trash"></i> حذف
							</a>
						</td>
					</tr>
				@endforeach

			</tbody>
		</table>
		{{$cats->links()}}
	</div>
</div>

<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
      </div>
      <form class="form" method="post" action="{{route('cats-store')}}" enctype="multipart/form-data">
      	@csrf
      <div class="modal-body">
       	<div class="form-group">
       		<label>
       			الاسم بالعربية
       		</label>
       		<input type="text" name="name_ar" class="SpecificInput" required="required">
       	</div>
       	<div class="form-group">
       		<label>
       			الاسم  بالانجليزية
       		</label>
       		<input type="text" name="name_en" class="SpecificInput" required="required">
       	</div>
        <div class="form-group">
          <label>
            الصورة
          </label>
          <input type="file" name="image" class="SpecificInput" >
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


@foreach($cats as $cat)
<div class="modal fade" id="edit{{$cat->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
      </div>
      <form class="form" method="post" action="{{route('cats-update')}}" enctype="multipart/form-data">
      	@csrf
      	<input type="hidden" name="id" value="{{$cat->id}}">
      <div class="modal-body">
       	<div class="form-group">
       		<label>
       			الاسم بالعربية
       		</label>
       		<input type="text" value="{{$cat->name_ar}}" name="name_ar" class="SpecificInput" required="required">
       	</div>
       	<div class="form-group">
       		<label>
       			الاسم  بالانجليزية
       		</label>
       		<input type="text" value="{{$cat->name_en}}" name="name_en" class="SpecificInput" required="required">
       	</div>
         <div class="form-group">
          <label>
            الصورة
          </label>
          <input type="file" name="image" class="SpecificInput" >
          @if(isset($cat->image)) 
          <img src="{{asset('uploads/'.$cat->image) }}" alt="" style="width: 100px;height: 100px">
          @endif
        </div>
       	<div class="form-group">
       		<input type="checkbox" {{$cat->status == 1 ? 'checked' : ''}} name="status" value="1">
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
                url: '/dashboard/cats/catChangeStatus',
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
