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
    @foreach($vehicles as $key=>$vehicle)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$vehicle->getName('ar')}}
            </td>
            <td>
                {{$vehicle->getName('en')}}
            </td>
            <td>
                @if ($vehicle->image)
                <img style="width: 45px" src="{{asset('uploads/vehicles/'.$vehicle->image)}}">
                @endif
            </td>
            <td>
                <button class="cl_{{$vehicle->id}} btn {{$vehicle->status==0?'btn-danger':'btn-success'}} stat" id="{{$vehicle->id}}" data-url="{{$vehicle->status}}" >
                    {{$vehicle->status==0?'غير نشط':'نشط'}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$vehicle->id}}" value="{{$vehicle->status}}">
            </td>

            <td>
                <a href="#" data-toggle="modal" data-target="#edit{{$vehicle->id}}" class="btn btn-primary btn-xs">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                {{--							<a href="{{route('vehicles.destroy',$vehicle->id)}}" id="confirmDelete" class="btn btn-danger">--}}
                {{--								<i class="fa fa-trash text-white"></i> حذف--}}
                {{--							</a>--}}
                {{--                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete_confirmation" data-toggle="modal" data-target="#confirmDelete"--}}
                {{--                               data-action="{{ route('vehicles.destroy', $vehicle->id) }}">--}}
                {{--                                <i class="fa fa-close text-danger"></i>حذف--}}
                {{--                            </a>--}}
                <a class=" btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route('vehicles.destroy', $vehicle->id)}}">
                    <i class="fa fa-trash text-white"></i> حذف </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{{$vehicles->links()}}