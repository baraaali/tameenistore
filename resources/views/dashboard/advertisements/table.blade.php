<table class="table table-stroped table-responsive table-straped text-center ">
    <thead class="bg-light ">
    <th>
        رقم
    </th>
    <th>
       الاسم
    </th>
    <th>
        اسم المالك
    </th>
    <th>
        اسم الدوله
    </th>
    <th>الصورة</th>
    <th>الحاله</th>
{{--    <th>نوع الإعلان</th>--}}
    <th>المشاهدات</th>
    <th>تاريخ بدايه الاعلان</th>
    <th>تاريخ انتهاء الاعلان</th>
    <th>
        العمليات
    </th>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$item->Banner->name_ar}}
            </td>
            <td>
                {{$item->user->name}}
            </td>
            <td>
                {{$item->country->ar_name}}
            </td>
            <td>
                <img src="{{asset('uploads/'.$item->file)}}" alt=""
                     style="height:50px;width: 50px" class="img-thumbnail">
            </td>
            <td>
                <button class="cl_{{$item->id}} btn {{$item->active==1?'btn-danger':'btn-success'}} stat" id="{{$item->id}}" data-url="{{$item->active}}" >
                    {{$item->active==0?' نشط':'غير نشط '}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$item->id}}" value="{{$item->active}}">
            </td>
            <td>{{$item->count_view}}</td>
            <td>{{$item->start_date}}</td>
            <td>{{$item->end_date}}</td>
            <td>
{{--                <a href="{{route('editServices',[$item->id,'ar','admin'])}}" class="btn btn-light circle" >--}}
{{--                    <i class="fas fa-plus-circle"></i>--}}
{{--                </a>--}}
{{--                <a href="{{route('editServices',[$item->id,'ar','admin'])}}" class="btn btn-primary btn-xs" --}}
{{--                   data-target="">--}}
{{--                    <i class="fa fa-edit"></i>--}}
{{--                </a>--}}
                <a onclick="return confirm('Are you sure?')" href="{{route('advertisements.destroy',$item->id)}}"
                   class="btn btn-danger">
                    <i class="fa fa-trash text-white"></i>
                </a>

                <a href="" class="btn btn-info btn-xs" data-toggle="modal"
                   data-target="#renewRow{{$item->id}}">
                    <i class="fa fa-sync"></i>
                </a>

            </td>
        </tr>
{{--                    --}}

        <!-- Modal -->
        <div class="modal fade" id="renewRow{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تجديد الاعلان </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('advertisements.renew')}}">
                            @csrf
                            <input type="hidden" name="item_date_id"
                                   value="{{$item->id}}">
                            <input required type="number" name="item_days" class="form-control form-group" placeholder="ادخل عدد الايام ">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق </button>
                            <input type="submit" class="btn btn-primary" value="تجديد">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--------- Branches  Edit Modal !---------->
        <div class="modal fade" id="exampleModalLabel2{{$item->id}}" tabindex="-1"
             role="dialog" aria-labelledby="#exampleModalLabel2{{$item->id}}"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">تعديل
                            البيانات </h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body"
                             style="background-color: white;color:#31353D;border:1px solid #d3d3d3;border-radius: 5px;margin-top: 30px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </tbody>
</table>
      {{$items->links()}}