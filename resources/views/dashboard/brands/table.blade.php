<table class="table table-stroped table-responsive table-straped text-center">
    <thead class="bg-light ">
    <th>
        رقم
    </th>
    <th>
        الاسم
    </th>
    <th>
        نوع العربة
    </th>  
    <th>
        بلد الصنع
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
    @foreach($brands as $key=>$brand)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$brand->name}}
            </td>
            <td>
                {{$brand->vehicle->getName('ar')}}
            </td>
            <td>
                {{$brand->manufacturing_country}}
            </td> 
            <td>
                @if ($brand->image)
                <img style="width: 45px" src="{{asset('uploads/'.$brand->image)}}">
                @endif
            </td>
            <td>
                <button class="cl_{{$brand->id}} btn {{$brand->status==0?'btn-danger':'btn-success'}} stat" id="{{$brand->id}}" data-url="{{$brand->status}}" >
                    {{$brand->status==0?'غير نشط':'نشط'}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$brand->id}}" value="{{$brand->status}}">
            </td>

            <td>
                <a href="#" data-toggle="modal" data-target="#edit{{$brand->id}}" _id="{{$brand->id}}" class="btn btn-primary btn-xs edit">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                {{--							<a href="{{route('brands.destroy',$brand->id)}}" id="confirmDelete" class="btn btn-danger">--}}
                {{--								<i class="fa fa-trash text-white"></i> حذف--}}
                {{--							</a>--}}
                {{--                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete_confirmation" data-toggle="modal" data-target="#confirmDelete"--}}
                {{--                               data-action="{{ route('brands.destroy', $brand->id) }}">--}}
                {{--                                <i class="fa fa-close text-danger"></i>حذف--}}
                {{--                            </a>--}}
                <a class=" btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route('brands.destroy', $brand->id)}}">
                    <i class="fa fa-trash text-white text-primary"></i> حذف </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{{$brands->links()}}