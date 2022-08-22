@extends('dashboard.layout.app')
@section('content')
    <?php $arr=['الرئيسيه','سيارات للبيع','سيارات للايجار','وكالات البيع','وكالات الايجار','الاعلانات','كل الاقسام','القسم الواحد'
//        ,'بجوار الاعلانات الذهبيه','بجوار الاعلانات المميزة ','بجوار الاعلانات الفضيه','بجوار الاعلانات العاديه'
    ];
    $types=['اعلى الصفحه','جانب الصفحه الايمن','جانب الصفحه الايسر'];
    ?>
    <div class="card text-white bg-primary shadow">

        <br>
        <div class="card-header mt-3">
            <h5 style="position: relative;
    display: inline-block;
    top: 6px;">
                انواع الاعلانات
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
                انواع الاعلانات
            </label>
            <table class="table table-stroped table-responsive table-straped text-center  ">
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
                <th>السعر </th>
                <th>المده </th>
                <th>مكان الظهور </th>
                <th>صفحه الظهر </th>
                <th>
                    العمليات
                </th>
                </thead>
                <tbody >
                @foreach($banners as $key=>$banner)
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            {{$banner->name_ar}}
                        </td>

                        <td>{{$banner->name_en}}</td>
                        <td>{{$banner->price}}</td>
                        <td>{{$banner->duration}}</td>
                        <td>{{$types[$banner->type]}}</td>
                        <td>{{$arr[$banner->page]}}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit{{$banner->id}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> تعديل
                            </a>

                            <a class=" btn btn-danger btn-xs " onclick="return confirm('Are you sure?')" href="{{ route('banners.destroy', $banner->id)}}">
                                <i class="fa fa-trash text-white"></i> حذف </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$banners->links()}}
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
                </div>
                <form class="form" method="post" action="{{route('banners.store')}}">
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
                            <label>
                           السعر
                            </label>
                            <input type="number" name="price" class="SpecificInput" required>
                        </div>
                        <div class="form-group">
                            <label>
                                المدة
                            </label>
                            <input type="number" name="duration" class="SpecificInput" required>
                        </div>
                        <div class="form-group">
                            <label>
                                مكان الظهور
                            </label>
                            <select name="type" id="" class="SpecificInput">
                                @for($j=0;$j<count($types);$j++)
                                    <option value="{{$j}}" class="SpecificInput">{{$types[$j]}}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                صفحه الظهور
                            </label>
                            <select name="page" id="" class="SpecificInput">
                                @for($i=0;$i<count($arr);$i++)
                                <option value="{{$i}}" class="SpecificInput">{{$arr[$i]}}</option>
                                @endfor
                            </select>
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


    @foreach($banners as $banner)
        <div class="modal fade" id="edit{{$banner->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">إضافة صفحة جديدة</h5>
                    </div>
                    <form class="form" method="post" action="{{route('banners.update',$banner->id)}}">
                        @csrf
                        {{ method_field('put') }}
                        <input type="hidden" name="id" value="{{$banner->id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>
                                    الاسم باللغة العربيه
                                </label>
                                <input type="text" value="{{$banner->name_ar}}" name="name_ar" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label>
                                    الاسم باللغة الانجليزيه
                                </label>
                                <input type="text" value="{{$banner->name_en}}" name="name_en" class="SpecificInput" required="required">
                            </div>
                            <div class="form-group">
                                <label>
                                    السعر
                                </label>
                                <input type="number" name="price" class="SpecificInput" required value="{{$banner->price}}">
                            </div>
                            <div class="form-group">
                                <label>
                                    المدة
                                </label>
                                <input type="number" name="duration" class="SpecificInput" required value="{{$banner->duration}}">
                            </div>

                            <div class="form-group">
                                <label>
                                    مكان الظهور
                                </label>
                                <select name="type" id="" class="SpecificInput">
                                    @for($j=0;$j<count($types);$j++)
                                        <option value="{{$j}}"  @if($j==$banner->type) selected @endif class="SpecificInput">{{$types[$j]}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label>
                                    صفحه الظهور
                                </label>
                                <select name="page" id="" class="SpecificInput">
                                    @for($i=0;$i<count($arr);$i++)
                                        <option value="{{$i}}"  @if($i==$banner->page) selected @endif class="SpecificInput">{{$arr[$i]}}</option>
                                    @endfor
                                </select>
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

@section('js')--}}

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
{{--                url: '/dashboard/banners/brandChangeStatus',--}}
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
{{--@endsection
