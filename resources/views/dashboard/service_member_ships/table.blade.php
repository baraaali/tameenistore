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
        النوع 
    </th>
    <th>
        عدد الشهور  
    </th>
    <th>
        السعر  
    </th>
    <th>
        عدد الإعلانات 
    </th>
    <th>
        نشط
    </th>

    <th>
        العمليات
    </th>
    </thead>
    <tbody >
    @foreach($service_member_ships as $key=>$service_member_ship)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$service_member_ship->getName('ar')}}
            </td>
            <td>
                {{$service_member_ship->getName('en')}}
            </td>
            <td>
                {{$service_member_ship->getCategory()}}
            </td>
            <td>
                {{__('site.'.$service_member_ship->type)}}
            </td> 
            <td>
                {{$service_member_ship->months_number}}
            </td> 
             <td>
                {{$service_member_ship->price}}
            </td> 
            
            <td>
                {{$service_member_ship->ads_number}}
            </td>
            <td>
                @if ($service_member_ship->status == '1')
                <span class="badge badge-success p-2">{{__('site.active')}}</span>
                @else 
                <span class="badge badge-danger p-2">{{__('site.inactive')}}</span>
                @endif
            </td>

            {{-- <td>
                <button class="cl_{{$service_member_ship->id}} btn {{$service_member_ship->status=='0'?'btn-danger':'btn-success'}} stat" id="{{$service_member_ship->id}}" data-url="{{$service_member_ship->status}}" >
                    {{$service_member_ship->status}}
                    {{$service_member_ship->status==0?'غير نشط':'نشط'}}</button>
                <input type="hidden" id="statusVal" class="statusVal_{{$service_member_ship->id}}" value="{{$service_member_ship->status}}">
            </td> --}}

            <td>
                <a href="#" data-toggle="modal" data-target="#edit{{$service_member_ship->id}}" _id="{{$service_member_ship->id}}" class="btn btn-primary btn-xs edit">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                {{--							<a href="{{route('service_member_ships.destroy',$service_member_ship->id)}}" id="confirmDelete" class="btn btn-danger">--}}
                {{--								<i class="fa fa-trash text-white"></i> حذف--}}
                {{--							</a>--}}
                {{--                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete_confirmation" data-toggle="modal" data-target="#confirmDelete"--}}
                {{--                               data-action="{{ route('service_member_ships.destroy', $service_member_ship->id) }}">--}}
                {{--                                <i class="fa fa-close text-danger"></i>حذف--}}
                {{--                            </a>--}}
                <a class=" btn btn-danger  btn-xs" onclick="return confirm('Are you sure?')" href="{{ route('service_member_ships.destroy', $service_member_ship->id)}}">
                    <i class="fa fa-trash text-white"></i> حذف </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{{$service_member_ships->links()}}