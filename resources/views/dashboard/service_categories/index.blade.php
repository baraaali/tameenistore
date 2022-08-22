@extends('dashboard.layout.app')
@section('content')
 <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                   الأقسام الأساسية للخدمات  
            </h5>
            <a href="{{route('service_categories.create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
                <i class="fas fa-plus-circle"></i>
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <div class="filter col-md-4">
                <div class="form-group">
                  <input type="text" class="form-control" id="search"  placeholder="بحث">
                </div>
            </div>
            <label style="display: block">
                الأقسام الأساسية للخدمات  
            </label>
            <div class="data-table">
                @include('dashboard.service_categories.table')

            </div>
        </div>
    </div>

    @foreach($service_categories as $service_category)
        <div class="modal fade" id="edit{{$service_category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> تعديل</h5>
                    </div>
                    <form class="form" method="post" action="{{route('service_categories.update',$service_category->id)}}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{$service_category->id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>
                                    الاسم بالعربية
                                </label>
                                <input type="text" value="{{$service_category->getName('ar')}}" name="ar_name" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label>
                                    الإسم بالإنجليزية
                                </label>
                                <input type="text" value="{{$service_category->getName('en')}}" name="en_name" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label class="d-block">
                                    الوصف بالعربية
                                </label>
                                <textarea name="ar_description" id="ar_description" rows="4" class="w-100">{{$service_category->getDescription('ar')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-block">
                                    الوصف بالإنجليزية
                                </label>
                                <textarea name="en_description" id="en_description" rows="4" class="w-100">{{$service_category->getDescription('en')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>
                                     الصورة
                                </label>
                                <input type="file" name="image" >
                            </div>
                          
                            <div class="form-group">
                                <input type="checkbox" {{$service_category->status == 1 ? 'checked' : ''}} name="status" value="1">
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

        var search  = function(){
            $('#search').on('input',function(){
				var search = $(this).val()
				$.ajax({
					headers: {'X-CSRF-TOKEN': csrf},
					url: "{{route('service_categories.search')}}",
					type:'post',
					data : {search:search},
					success : function(res){
						$('.data-table').html(res)
					}

				})
			})
        }
        $(document).ready(function(){
            search()
        })
      /*  $(':button').on('click', function() {
            var service_category_id = $(this).attr('id');
            var row='statusVal_'+service_category_id;
            var data = $(this).attr('data-url');
            var status = data == 1 ? '0' : '1'
            alert(status)
           $.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/service_categories/service_categoryChangeStatus',
                data: {'status': status, 'service_category_id': service_category_id},
                success: function(data){
                    var clas='cl_'+service_category_id;
                    if(status==1){
                        $('.'+row).attr('value', '1');
                        $(this).attr('data-url',status)

                        $('.'+clas).html('نشط');
                        $('.'+clas).removeClass('btn-danger');
                        $('.'+clas).addClass('btn-success');
                    }
                    else{
                        $('.'+row).attr('value', '0');
                        $(this).attr('data-url',status)

                        $('.'+clas).html('غير نشط');
                        $('.'+clas).removeClass('btn-success');
                        $('.'+clas).addClass('btn-danger');
                    }


                }, error : function(e){
                    console.log(e.responseText);
                }
            });
        });*/
    </script>
@endsection
