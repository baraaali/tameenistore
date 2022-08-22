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
          الوصف بالعربية 
    </th>
    <th>
         الوصف بالإنجليزية 
  </th>
    <th>
        نشط
    </th>

    <th>
        العمليات
    </th>
    </thead>
    <tbody >
    @foreach($service_categories as $key=>$service_category)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$service_category->getName('ar')}}
            </td>
            <td>
                {{$service_category->getName('en')}}
            </td>
            <td>
                @if ($service_category->image)
                <img style="width: 45px" src="{{asset('uploads/'.$service_category->image)}}">
                @endif
            </td>
            <td>
                {{substr($service_category->getDescription('ar'),0,15)}}
                @if (strlen($service_category->getDescription('ar') )> 15)
                {{' ....'}}
              @endif
            </td>
            <td>
                {{substr($service_category->getDescription('en'),0,15)}}
                @if (strlen($service_category->getDescription('en') )> 15)
                {{' ....'}}
              @endif
            </td>

            <td>
                @if ($service_category->status == '1')
                <span class="badge badge-success p-2">{{__('site.active')}}</span>
                @else 
                <span class="badge badge-danger p-2">{{__('site.inactive')}}</span>
                @endif
            </td>

            {{-- <td>
                <button class="cl_{{$service_category->id}} btn {{$service_category->status=='0'?'btn-danger':'btn-success'}} stat" id="{{$service_category->id}}" data-url="{{$service_category->status}}" >
                    {{$service_category->status}}
                    {{$service_category->status==0?'غير نشط':'نشط'}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$service_category->id}}" value="{{$service_category->status}}">
            </td> --}}

            <td>
                <a href="#" data-toggle="modal" data-target="#edit{{$service_category->id}}" class="btn btn-primary btn-xs">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                {{--							<a href="{{route('service_categories.destroy',$service_category->id)}}" id="confirmDelete" class="btn btn-danger">--}}
                {{--								<i class="fa fa-trash text-white"></i> حذف--}}
                {{--							</a>--}}
                {{--                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete_confirmation" data-toggle="modal" data-target="#confirmDelete"--}}
                {{--                               data-action="{{ route('service_categories.destroy', $service_category->id) }}">--}}
                {{--                                <i class="fa fa-close text-danger"></i>حذف--}}
                {{--                            </a>--}}
                <a class=" btn btn-danger  btn-xs" onclick="return confirm('Are you sure?')" href="{{ route('service_categories.destroy', $service_category->id)}}">
                    <i class="fa fa-trash text-white"></i> حذف </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{{$service_categories->links()}}