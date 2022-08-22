@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                انواع الاستخدامات
            </h5>
            <a href="#" data-toggle="modal" data-target="#create" class="btn btn-light"  style="float: left;margin-right:10px;" >
                <i class="fas fa-plus-circle"></i>
            </a>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <label style="display: block">
                انواع الاستخدامات
            </label>
            <table class="table table-stroped table-responsive table-straped text-center">
                <thead class="bg-light ">
                <th>
                    رقم
                </th>
                <th>
                    الاسم باللغة العربيه
                </th>

                <th>
                    الاسم باللغة الانجليزيه
                </th>

                <th>
                    العمليات
                </th>
                </thead>
                <tbody >
                @foreach($uses as $key=>$use)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            {{$use->name_ar}}
                        </td>

                        <td>{{$use->name_en}}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit{{$use->id}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> تعديل
                            </a>

                            <a class=" btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route('uses.destroy', $use->id)}}">
                                <i class="fa fa-trash text-white text-primary"></i> حذف </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$uses->links()}}
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
                </div>
                <form class="form" method="post" action="{{route('uses.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>
                                الاسم باللغة العربيه
                            </label>
                            <input type="text" name="name_ar" class="SpecificInput" required>
                        </div>
                        <div class="form-group">
                            <label>
                                الاسم باللغة الانجليزيه
                            </label>
                            <input type="text" name="name_en" class="SpecificInput" required>
                        </div>
                        <div class="form-group">
                            {{--       		<input type="checkbox" name="status" value="1">--}}
                            {{--       		<label>--}}
                            {{--       			نشر ؟--}}
                            {{--       		</label>--}}

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


    @foreach($uses as $use)
        <div class="modal fade" id="edit{{$use->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
                    </div>
                    <form class="form" method="post" action="{{route('uses.update',$use->id)}}">
                        @csrf
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{$use->id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>
                                    الاسم باللغة العربيه
                                </label>
                                <input type="text" value="{{$use->name_ar}}" name="name_ar" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label>
                                    الاسم باللغة الانجليزيه
                                </label>
                                <input type="text" value="{{$use->name_en}}" name="name_en" class="SpecificInput" required="required">
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

{{--@section('js')--}}

{{--    <script>--}}
{{--        $(':button').on('click', function() {--}}
{{--            var brand_id = $(this).attr('id');--}}
{{--            var row='statusVal_'+brand_id;--}}
{{--            var data = $('.'+row).val();--}}
{{--            var status=data==0?1:0;--}}
{{--            console.log(status);--}}


{{--            $.ajax({--}}
{{--                type: "GET",--}}
{{--                dataType: "json",--}}
{{--                url: '/dashboard/uses/brandChangeStatus',--}}
{{--                data: {'status': status, 'brand_id': brand_id},--}}
{{--                success: function(data){--}}
{{--                    console.log(data.success)--}}
{{--                    console.log(status);--}}
{{--                    var clas='cl_'+brand_id;--}}
{{--                    if(status==1){--}}
{{--                        $('.'+row).attr('value', '1');--}}
{{--                        $('.'+clas).html('نشط');--}}
{{--                        $('.'+clas).removeClass('btn-danger');--}}
{{--                        $('.'+clas).addClass('btn-success');--}}
{{--                    }--}}
{{--                    else{--}}
{{--                        $('.'+row).attr('value', '0');--}}
{{--                        $('.'+clas).html('غير نشط');--}}
{{--                        $('.'+clas).removeClass('btn-success');--}}
{{--                        $('.'+clas).addClass('btn-danger');--}}
{{--                    }--}}

{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
