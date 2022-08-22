@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3 text-center">
            <h6 style="position: relative; display: inline-block;">مستندات العملاء
            </h6>
            {{--		<a href="{{route('pages-archive')}}"  class="btn btn-light"  style="float: left" >--}}
            {{--			   <i class="fas fa-trash"></i>--}}
            {{--		</a>--}}
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">

            <table class="table table-stroped table-responsive table-straped text-center  table-hover">
                <thead class="table-active">
                <th>
                    رقم
                </th>
                <th>
                    اسم العميل
                </th>
                <th>
                    صورة الرخصه
                </th>

                <th>
                    صورة الهويه
                </th>

                <th>
                    رقم الرخصة
                </th>
                <th>
                اسم الشركة
                </th>
                <th>
                    تاريخ البدء
                </th>
                <th>
                    تاريخ الانتهاء
                </th>
                </thead>
                <tbody >
                @foreach($docs as $key=>$doc)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>{{$doc->User->name}}</td>
                        <td>
                            <a data-fancybox="cats" href="{{asset('uploads/'.$doc->license_image)}}">
                                <img src="{{asset('uploads/'.$doc->license_image)}}" alt="" class="img-thumbnail" style="width: 70px;height: 70px">
                            </a>
                        </td>
                        <td>
                            <a data-fancybox="cats" href="{{asset('uploads/'.$doc->id_image)}}">
                                <img src="{{asset('uploads/'.$doc->id_image)}}" alt="" class="img-thumbnail" style="width: 70px;height: 70px">
                            </a>
                        </td>
                        <td>
                            {{$doc->license_number}}
                        </td>
                        <td>
                            {{$doc->company_name}}
                        </td>
                        <td>
                            {{$doc->start_date}}
                        </td>
                        <td>
                            {{$doc->end_date}}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$docs->links()}}
        </div>
    </div>


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
