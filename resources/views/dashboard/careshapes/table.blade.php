<table class="table table-stroped table-responsive table-straped text-center">
    <thead class="bg-light ">
    <th>
        رقم
    </th>
    <th>
       الإسم بالعربية 
    </th> 
    <th>
        الإسم بالإنجليزية
    </th> 
     <th>
        الصورة 
    </th>

    <th>
        نشط
    </th>

    <th>
        العمليات
    </th>
    </thead>
    <tbody >
    @foreach($careshapes as $key=>$careshape)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$careshape->getName('ar')}}
            </td>
            <td>
                {{$careshape->getName('en')}}
            </td>
            <td>
                @if ($careshape->image)
                <img style="width: 45px" src="{{asset('uploads/'.$careshape->image)}}">
                @endif
            </td>
            <td>
                <button class="cl_{{$careshape->id}} btn {{$careshape->status==0?'btn-danger':'btn-success'}} stat" id="{{$careshape->id}}" data-url="{{$careshape->status}}" >
                    {{$careshape->status==0?'غير نشط':'نشط'}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$careshape->id}}" value="{{$careshape->status}}">
            </td>

            <td>
                <a href="#" data-toggle="modal" data-target="#edit{{$careshape->id}}" class="btn btn-primary btn-xs">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                {{--							<a href="{{route('careshapes.destroy',$careshape->id)}}" id="confirmDelete" class="btn btn-danger">--}}
                {{--								<i class="fa fa-trash text-white"></i> حذف--}}
                {{--							</a>--}}
                {{--                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete_confirmation" data-toggle="modal" data-target="#confirmDelete"--}}
                {{--                               data-action="{{ route('careshapes.destroy', $careshape->id) }}">--}}
                {{--                                <i class="fa fa-close text-danger"></i>حذف--}}
                {{--                            </a>--}}
                <a class=" btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route('careshapes.destroy', $careshape->id)}}">
                    <i class="fa fa-trash text-white"></i> حذف </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{{$careshapes->links()}}