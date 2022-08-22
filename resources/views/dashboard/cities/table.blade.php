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
            المنطقة أو الجهة
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
        @foreach($cities as $key=>$city)
        <tr>
            <td>
                {{$key+1}}
            </td>
            <td>
                {{$city->ar_name}}
            </td>
            <td>
                {{$city->en_name}}
            </td>
            <td>
                {{$city->governorate->ar_name}} |    {{$city->governorate->en_name}}
            </td>
            <td>
                <a href="#" class="btn btn-primary btn-sm btn-edit"  _id="{{$city->id}}" >
                    <i class="fa fa-edit"></i> تعديل
                </a>
            </td>
            <td>
                <a onclick="return confirm('Are you sure?')" href="{{url('/')}}/dashboard/cities/delete/{{$city->id}}" class="btn btn-danger btn-sm ">
                    <i class="fa fa-trash text-white"></i> حذف
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$cities->links()}}