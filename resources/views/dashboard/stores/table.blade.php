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
        القسم 
    </th>
    <th>
        نشط
    </th>

    <th>
        العمليات
    </th>
    </thead>
    <tbody >
    @foreach($stores as $key=>$store)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$store->getName('ar')}}
            </td>
            <td>
                {{$store->getName('en')}}
            </td>
            <td>
                {{$store->getCategory()}}
            </td>
      
            <td>
                @if ($store->status == '1')
                <span class="badge badge-success p-2">{{__('site.active')}}</span>
                @else 
                <span class="badge badge-danger p-2">{{__('site.inactive')}}</span>
                @endif
            </td>

            {{-- <td>
                <button class="cl_{{$store->id}} btn {{$store->status=='0'?'btn-danger':'btn-success'}} stat" id="{{$store->id}}" data-url="{{$store->status}}" >
                    {{$store->status}}
                    {{$store->status==0?'غير نشط':'نشط'}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$store->id}}" value="{{$store->status}}">
            </td> --}}

            <td>
                <a href="#" data-toggle="modal" data-target="#edit{{$store->id}}" _id="{{$store->id}}" class="btn btn-primary btn-xs edit">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                {{--							<a href="{{route('stores.destroy',$store->id)}}" id="confirmDelete" class="btn btn-danger">--}}
                {{--								<i class="fa fa-trash text-white"></i> حذف--}}
                {{--							</a>--}}
                {{--                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete_confirmation" data-toggle="modal" data-target="#confirmDelete"--}}
                {{--                               data-action="{{ route('stores.destroy', $store->id) }}">--}}
                {{--                                <i class="fa fa-close text-danger"></i>حذف--}}
                {{--                            </a>--}}
                <a class=" btn btn-danger  btn-xs" onclick="return confirm('Are you sure?')" href="{{ route('stores.destroy', $store->id)}}">
                    <i class="fa fa-trash text-white"></i> حذف </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{{$stores->links()}}