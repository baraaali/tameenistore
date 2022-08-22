@extends('dashboard.layout.app')
@section('content')
 <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                   أشكال السيارات  
            </h5>
            <a href="{{route('careshapes.create')}}" class="btn btn-light"  style="float: left;margin-right:10px;" >
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
                أشكال السيارات  
            </label>
          <div class="data-table">
            @include('dashboard.careshapes.table')
          </div>
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة  </h5>
                </div>
                <form class="form" method="post" action="{{route('careshapes.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>
                                الإسم بالعربي
                            </label>
                            <input type="text" name="ar_name" class="SpecificInput" required>
                        </div>
                        <div class="form-group">
                            <label>
                                الإسم بالإنجليزية
                            </label>
                            <input type="text" name="en_name" class="SpecificInput" required>
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


    @foreach($careshapes as $careshape)
        <div class="modal fade" id="edit{{$careshape->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> تعديل</h5>
                    </div>
                    <form class="form" method="post" action="{{route('careshapes.update',$careshape->id)}}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{$careshape->id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>
                                    الاسم بالعربية
                                </label>
                                <input type="text" value="{{$careshape->getName('ar')}}" name="ar_name" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label>
                                    الإسم بالإنجليزية
                                </label>
                                <input type="text" value="{{$careshape->getName('en')}}" name="en_name" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label>
                                     الصورة
                                </label>
                                <input type="file" name="image" >
                            </div>
                          
                            <div class="form-group">
                                <input type="checkbox" {{$careshape->status == 1 ? 'checked' : ''}} name="status" value="1">
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
					url: "{{route('careshapes.search')}}",
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
        $(':button').on('click', function() {
            var careshape_id = $(this).attr('id');
            var row='statusVal_'+careshape_id;
            var data = $(this).attr('data-url');
            var status=data==0?1:0;

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/careshapes/careshapeChangeStatus',
                data: {'status': status, 'careshape_id': careshape_id},
                success: function(data){
                    var clas='cl_'+careshape_id;
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

                }, error : function(e){
                    console.log(e.responseText);
                }
            });
        });
    </script>
@endsection
