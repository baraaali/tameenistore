@extends('dashboard.layout.app')
@section('content')
<div class="card text-white bg-primary shadow">
	<div class="card-header">
		<h5 style="position: relative;
    display: inline-block;
    top: 6px;">
			وكالات التأمين
		</h5>
		<a href="{{route('insurnaces.create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
			   <i class="fas fa-plus-circle"></i>
		</a>
{{--		<a href="{{route('insurnaces.archive')}}"  class="btn btn-light"  style="float: left" >--}}
{{--			   <i class="fas fa-trash"></i>--}}
{{--		</a>--}}
	</div>
	<div class="card-body" style="background-color: white;color:#31353D">
		<label style="display: block">
			جميع  وكالات التأمين
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
                <td>نوع العضويه</td>
				<td>
					الحالة
				</td>
{{--				<td>--}}
{{--					العمليات--}}
{{--				</td>--}}

			</thead>
			<tbody >
				@foreach($insurnaces as $key=>$insur)
					<tr>
						<td>
							{{$key + 1}}
						</td>
						<td>
							<button class="btn btn-dark btn-xs">
								{{$insur->country->ar_name}}
							</button>
						</td>

						<td>
							<button class="btn btn-primary btn-xs">
								{{$insur->owner->name}}
							</button>
						</td>

						<td>
							{{$insur->ar_name}}
						</td>

						<td>
							<img src="{{url('/')}}/uploads/{{$insur->image}}" style="width:auto;height:50px ">
						</td>
						<td>
							@if($insur->special == 0)

							<button class="btn btn-default btn-xs">
								عادية
							</button>
							@elseif ($insur->special == 1)

							<button class="btn btn-primary btn-xs">
								فضية
							</button>

							@elseif ($insur->special == 2)

							<button class="btn btn-danger">
								ذهبية
							</button>
                            @elseif($insur->special==null)
                                <button class="btn btn-success btn-xs">
                                    لم يشترك بعد
                                </button>
							@else

							<button class="btn btn-success btn-xs">
								مميزة
							</button>

							@endif

						</td>
                        <td>
                            <button class="cl_{{$insur->id}} btn {{$insur->status==0?'btn-danger':'btn-success'}} stat" id="{{$insur->id}}" data-url="{{$insur->status}}" >
                                {{$insur->status==0?'غير نشط':'نشط'}}</button>
                            <input type="hidden" id="statusVal" class="statusVal_{{$insur->id}}" value="{{$insur->status}}">
                        </td>
						<td>
{{--							<a href="{{route('insurnaces.edit',$insur->id)}}" class="btn btn-primary btn-xs">--}}
{{--								<i class="fa fa-edit"></i> تعديل--}}
{{--							</a>--}}
{{--							<a onclick="return confirm('Are you sure?')" href="{{route('insurnaces.destroy',$insur->id)}}" class="btn btn-danger">--}}
{{--								<i class="fa fa-trash text-white"></i> حذف--}}
{{--							</a>--}}
						</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		{{$insurnaces->links()}}
	</div>
</div>


@endsection
@section('js')

    <script>
        $(':button').on('click', function() {
            var agent_id = $(this).attr('id');
            var row='statusVal_'+agent_id;
            var data = $('.'+row).val();
            var status=data==0?1:0;
            console.log(status);


            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/insurnaces/insurChangeStatus',
                data: {'status': status, 'agent_id': agent_id},
                success: function(data){
                    console.log(data.success)
                    console.log(status);
                    var clas='cl_'+agent_id;
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
