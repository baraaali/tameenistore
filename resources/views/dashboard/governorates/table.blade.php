<table class="table table-stroped table-responsive   table-responsive d-table">
    <thead class="table-primary">
       <tr>
        <th>
            رقم
        </th>
        <th>
            الاسم بالعربية
        </th>
        <th>
            الاسم  بالانجليزية
        </th>
        <th>
            الدولة
        </th>
        <th>
            تعديل
        </th>
    <th>
        حذف
    </th>
       </tr>
    
    </thead>
    <tbody>
        @foreach($governorates as $key=>$governorate)
        <tr>
            <td>
                {{$key+1}}
            </td>
            <td>
                {{$governorate->ar_name}}
            </td>
            <td>
                {{$governorate->en_name}}
            </td>
            <td>
                {{$governorate->country->ar_name}} |  {{$governorate->country->en_name}}
            </td>
            <td>
                <a href="#" class="btn btn-primary btn-sm btn-edit"  _id="{{$governorate->id}}" >
                    <i class="fa fa-edit"></i> تعديل
                </a>
            </td>
            <td>
                <a onclick="return confirm('Are you sure?')" href="{{url('/')}}/dashboard/governorates/delete/{{$governorate->id}}" class="btn btn-danger btn-sm ">
                    <i class="fa fa-trash text-white"></i> حذف
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$governorates->links()}}