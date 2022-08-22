@extends('dashboard.layout.app')
@section('content')

    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                كل البلاغات
            </h5>
        </div>
        <div class="card-body" style="background-color: white;color:#31353D">
            <label style="display: block">
                جميع البلاغات
            </label>
            <table class="table table-stroped table-responsive table-straped text-center ">
                <thead class="bg-light ">
                <th>
                    رقم
                </th>
                <th>
                    الاسم
                </th>
                <th>مشاهدة الاعلان</th>
                <th>
                    العمليات
                </th>
                </thead>
                <tbody>
                @foreach($rows as $key=>$row)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            @if($type==1) {{App\NewServices::where('id',$row->ads_id)->first()->name_ar}}
                            @else
                            @isset ($row->cars->ar_name)
                                {{$row->cars->ar_name}}
                            @endisset
                            
                            @endif
                        </td>

                        <td>
                            @if($type==1)
                            <a href="{{route('editServices',[$row->ads_id,'ar'])}}" class="btn btn-warning btn-xs">
                                <i class="fa fa-eye"></i>مشاهدة الاعلان
                            </a>
                            @else
                            <a href="{{route('Ads-edit',[$row->cars->id,'ar'])}}" class="btn btn-warning btn-xs">
                                <i class="fa fa-eye"></i>مشاهدة الاعلان
                            </a>
                            @endif
                        </td>

                        <td>
                            <a href="{{route('notify.eye',$row->id)}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-eye"></i> تمت المشاهدة
                            </a>
                            <a href="{{route('notify.delete',[$row->id,$type])}}" class="btn btn-danger">
                                <i class="fa fa-eye"></i>حذف الاعلان
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$rows->links()}}
        </div>
    </div>

@endsection

@section('js')

    <script>
        $(':button').on('click', function () {
            var brand_id = $(this).attr('id');
            var row = 'statusVal_' + brand_id;
            var data = $('.' + row).val();
            var status = data == 0 ? 1 : 0;
            console.log(status);


            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/dashboard/brands/brandChangeStatus',
                data: {'status': status, 'brand_id': brand_id},
                success: function (data) {
                    console.log(data.success)
                    console.log(status);
                    var clas = 'cl_' + brand_id;
                    if (status == 1) {
                        $('.' + row).attr('value', '1');
                        $('.' + clas).html('نشط');
                        $('.' + clas).removeClass('btn-danger');
                        $('.' + clas).addClass('btn-success');
                    } else {
                        $('.' + row).attr('value', '0');
                        $('.' + clas).html('غير نشط');
                        $('.' + clas).removeClass('btn-success');
                        $('.' + clas).addClass('btn-danger');
                    }

                }
            });
        });
    </script>
@endsection
